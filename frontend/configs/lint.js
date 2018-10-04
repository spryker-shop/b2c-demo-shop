const appSettings = require('../settings');
const StyleLintPlugin = require('stylelint-webpack-plugin');

module.exports = {
    mode: 'development',

    plugins: [
        new StyleLintPlugin({
            context: appSettings.paths.project.modules,
            fix: true
        })
    ]
};
