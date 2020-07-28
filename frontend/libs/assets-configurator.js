const fs = require('fs');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const getCopyConfig = appSettings =>
    Object.values(appSettings.paths.assets).reduce((copyConfig, assetsPath) => {
        if (fs.existsSync(assetsPath)) {
            copyConfig.push({
                from: assetsPath,
                to: '.',
                ignore: ['*.gitkeep'],
            });
        }
        return copyConfig;
    },[]);

const getCopyStaticConfig = appSettings => {
    const staticAssetsPath = appSettings.paths.assets.staticAssets;
    if (fs.existsSync(staticAssetsPath)) {
        return [{
            from: staticAssetsPath,
            to: appSettings.paths.publicStatic,
        }];
    }
    return [];
};

const getAssetsConfig = appSettings => [
    new CleanWebpackPlugin(
        [
            appSettings.paths.public,
            appSettings.paths.publicStatic,
        ],
        {
            root: appSettings.context,
            verbose: true,
            beforeEmit: true,
        }
    ),

    new CopyWebpackPlugin(getCopyConfig(appSettings), {
        context: appSettings.context,
    }),

    new CopyWebpackPlugin(getCopyStaticConfig(appSettings), {
        context: appSettings.context,
    }),
];

module.exports = {
    getAssetsConfig
};
