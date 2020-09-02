const { join } = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { findComponentEntryPoints, findComponentStyles, findAppEntryPoint } = require('../libs/finder');
const { getAliasList } = require('../libs/alias');
const { getAssetsConfig } = require('../libs/assets-configurator');
const { buildVariantSettings } = require('../settings');

let isImagesOptimizationEnabled = false;
let imagesOptimization = null;

try {
    imagesOptimization = require('../libs/images-optimization');
    isImagesOptimizationEnabled = true;
} catch (e) {
    console.info('Images optimization is disabled.');
}

const getConfiguration = async appSettings => {
    const { buildVariant, isES6Module } = buildVariantSettings;
    const componentEntryPointsPromise = findComponentEntryPoints(appSettings.find.componentEntryPoints);
    const stylesPromise = findComponentStyles(appSettings.find.componentStyles);
    const [componentEntryPoints, styles] = await Promise.all([componentEntryPointsPromise, stylesPromise]);
    const alias = getAliasList(appSettings);

    const vendorTs = await findAppEntryPoint(appSettings.find.shopUiEntryPoints, './vendor.ts');
    const es6PolyfillTs = await findAppEntryPoint(appSettings.find.shopUiEntryPoints, './es6-polyfill.ts');
    const appTs = await findAppEntryPoint(appSettings.find.shopUiEntryPoints, './app.ts');
    const basicScss = await findAppEntryPoint(appSettings.find.shopUiEntryPoints, './styles/basic.scss');
    const utilScss = await findAppEntryPoint(appSettings.find.shopUiEntryPoints, './styles/util.scss');
    const sharedScss = await findAppEntryPoint(appSettings.find.shopUiEntryPoints, './styles/shared.scss');

    return {
        namespace: appSettings.namespaceConfig.namespace,
        theme: appSettings.theme,
        componentEntryPointsLength: componentEntryPoints.length,
        stylesLength: styles.length,
        webpack: {
            context: appSettings.context,
            mode: 'development',
            devtool: 'inline-source-map',

            stats: {
                colors: true,
                chunks: false,
                chunkModules: false,
                chunkOrigins: false,
                modules: false,
                entrypoints: false
            },

            entry: {
                'vendor': vendorTs,
                'es6-polyfill': es6PolyfillTs,
                'app': [
                    appTs,
                    basicScss,
                    ...componentEntryPoints,
                    utilScss,
                ]
            },

            output: {
                path: join(appSettings.context, appSettings.paths.public),
                publicPath: `/${appSettings.urls.assets}/`,
                filename: isES6Module ? `./js/${appSettings.name}.[name].js` : `./js/${appSettings.name}.[name].${buildVariant}.js`,
                jsonpFunction: `webpackJsonp_${appSettings.name.replace(/(-|\W)+/gi, '_')}`
            },

            resolve: {
                extensions: ['.ts', '.js', '.json', '.css', '.scss'],
                alias
            },

            module: {
                rules: [
                    {
                        test: /\.ts$/,
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                ['@babel/env', {
                                    loose: true,
                                    modules: false,
                                    targets: {
                                        esmodules: isES6Module,
                                        browsers: [
                                            '> 1%',
                                            'ie >= 11',
                                        ],
                                    },
                                    useBuiltIns: false,
                                }],
                                '@babel/preset-typescript'
                            ],
                            plugins: [
                                ...(!isES6Module ? ['@babel/plugin-transform-runtime'] : []),
                                ['@babel/plugin-proposal-class-properties'],
                            ]
                        }
                    },
                    {
                        test: /\.(scss|css)/i,
                        use: [
                            MiniCssExtractPlugin.loader, {
                                loader: 'css-loader',
                                options: {
                                    importLoaders: 1,
                                    url: false,
                                }
                            }, {
                                loader: 'postcss-loader',
                                options: {
                                    ident: 'postcss',
                                    plugins: [
                                        autoprefixer({
                                            'browsers': ['> 1%', 'last 2 versions']
                                        })
                                    ]
                                }
                            }, {
                                loader: 'sass-loader'
                            }, {
                                loader: '@spryker/sass-resources-loader',
                                options: {
                                    resources: [
                                        sharedScss,
                                        ...styles
                                    ]
                                }
                            }
                        ]
                    }
                ]
            },

            optimization: {
                runtimeChunk: 'single',
                concatenateModules: false,
                splitChunks: {
                    chunks: 'initial',
                    minChunks: 1,
                    cacheGroups: {
                        default: false,
                        vendors: false
                    }
                }
            },

            plugins: [
                new webpack.DefinePlugin({
                    __NAME__: `'${appSettings.name}'`,
                    __PRODUCTION__: appSettings.isProductionMode
                }),

                ...(isES6Module ? getAssetsConfig(appSettings) : []),

                new MiniCssExtractPlugin({
                    filename: `./css/${appSettings.name}.[name].css`,
                }),

                compiler => compiler.hooks.afterEmit.tap('webpack', () => {
                    if (isImagesOptimizationEnabled) {
                        imagesOptimization(appSettings);
                    }
                }),

                compiler => compiler.hooks.done.tap('webpack', compilationParams => {
                    if (process.env.npm_lifecycle_event === 'yves:watch') {
                        return;
                    }

                    const { errors } = compilationParams.compilation;

                    if (!errors || !errors.length) {
                        return;
                    }

                    errors.forEach(error => console.log(error.message));
                    process.exit(1);
                })
            ]
        }
    };
};

module.exports = getConfiguration;
