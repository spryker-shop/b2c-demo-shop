// get arguments from command line (mode, namespace list, theme list and path to config JSON file
const getAttributes = require('./libs/command-line-parser');
const requestedArguments = getAttributes();
const { getFilteredNamespaceConfigList } = require('./libs/namespace-config-parser');
const { getAppSettings } = require('./settings');
const compiler = require('./libs/compiler');

// get the webpack configuration associated with the provided mode
const getConfiguration = require(`./configs/${requestedArguments.mode}`);

// get array of filtered namespace config
const namespaceConfigList = getFilteredNamespaceConfigList(requestedArguments);

// get the promise for each namespace webpack configuration
const configurationPromises = getAppSettings(namespaceConfigList, requestedArguments.pathToConfig)
    .map(getConfiguration);

// build the project
Promise.all(configurationPromises)
    .then(configs => compiler.multiCompile(configs))
    .catch(error => console.error('An error occur while creating configuration', error));
