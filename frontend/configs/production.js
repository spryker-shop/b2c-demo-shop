const { mergeWithCustomize, customizeObject } = require('webpack-merge');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
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

                    new CssMinimizerPlugin({
                        minimizerOptions: {
                            preset: [
                                'default',
                                {
                                    discardComments: { removeAll: true },
                                },
                            ],
                        },
                    }),
                ],
            },
        },
    });

module.exports = configurationProdMode;
