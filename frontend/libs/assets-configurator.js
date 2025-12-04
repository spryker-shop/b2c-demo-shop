const fs = require('fs');
const CopyPlugin = require('copy-webpack-plugin');

const getCopyConfig = (appSettings) =>
    Object.values(appSettings.paths.assets).reduce((copyConfig, assetsPath) => {
        if (fs.existsSync(assetsPath)) {
            copyConfig.push({
                from: assetsPath,
                to: '.',
                context: appSettings.context,
                globOptions: {
                    dot: true,
                    ignore: ['**/.gitkeep'],
                },
                noErrorOnMissing: true,
            });
        }

        return copyConfig;
    }, []);

const getCopyStaticConfig = (appSettings) => {
    const staticAssetsPath = appSettings.paths.assets.staticAssets;

    if (fs.existsSync(staticAssetsPath)) {
        return [
            {
                from: staticAssetsPath,
                to: appSettings.paths.publicStatic,
                context: appSettings.context,
            },
        ];
    }

    return [];
};

const getAssetsConfig = (appSettings) => [
    new CopyPlugin({
        patterns: getCopyConfig(appSettings),
    }),

    new CopyPlugin({
        patterns: getCopyStaticConfig(appSettings),
    }),
];

module.exports = {
    getAssetsConfig,
};
