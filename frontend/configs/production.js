const { mergeWithCustomize, customizeObject } = require('webpack-merge');
const TerserPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const getConfiguration = require('./development');

const mergeWithStrategy = mergeWithCustomize({
    customizeObject: customizeObject({
        plugins: 'prepend',
    }),
});

const configurationProdMode = async (appSettings) =>
    mergeWithStrategy(await getConfiguration(appSettings), {
        webpack: {
            mode: 'production',
            devtool: false,

            plugins: [
                new CompressionPlugin({
                    filename: '[path][base].br[query]',
                    algorithm: 'brotliCompress',
                    test: /\.(js|css|html|svg)$/,
                    threshold: 10240,
                    minRatio: 0.8,
                }),
            ],

            optimization: {
                minimizer: [
                    new TerserPlugin({
                        parallel: true,
                        extractComments: false,
                        terserOptions: {
                            output: {
                                beautify: false,
                            },
                        },
                    }),

                    new OptimizeCSSAssetsPlugin({
                        cssProcessorOptions: {
                            discardEmpty: true,
                            discardComments: {
                                removeAll: true,
                            },
                        },
                    }),
                ],
            },
        },
    });

module.exports = configurationProdMode;
