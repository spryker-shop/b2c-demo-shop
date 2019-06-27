const fs = require('fs');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const getCopyConfig = (appSettings) =>
    Object.values(appSettings.paths.assets).reduce((collection, current) => {
        if (fs.existsSync(current)) {
            collection.push({
                from: current,
                to: '.',
                ignore: ['*.gitkeep']
            });
        }
        return collection;
    },[]);

const getAssetsConfig = (appSettings) => [
    new CleanWebpackPlugin([appSettings.paths.public],
        {
            root: appSettings.context,
            verbose: true,
            beforeEmit: true
        }
    ),

    new CopyWebpackPlugin(getCopyConfig(appSettings), {
        context: appSettings.context
    }),
];

module.exports = {
    getAssetsConfig
};
