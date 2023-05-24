const getAttributes = require('./command-line-parser');
const { getFilteredNamespaceConfigList } = require('./namespace-config-parser');
const { getAppSettings } = require('./../settings');
const imagesOptimization = require('../libs/images-optimization');

const requestedArguments = getAttributes();
const namespaceConfigList = getFilteredNamespaceConfigList(requestedArguments);
const appSettingsList = getAppSettings(namespaceConfigList, requestedArguments.pathToConfig);

appSettingsList.forEach((appSettings) => {
    console.info('Image compression has been started...');
    imagesOptimization(appSettings, requestedArguments);
});
