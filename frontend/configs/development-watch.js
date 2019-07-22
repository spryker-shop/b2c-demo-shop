const getConfiguration = require('./development');
const merge = require('webpack-merge');

const configurationWatchMode = async appSettings =>
    merge(await getConfiguration(appSettings), {webpack: {watch: true}});

module.exports = configurationWatchMode;
