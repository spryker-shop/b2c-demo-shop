// get store manager
const { getStoresByIds } = require('./libs/store-manager');

// get the settings manager
const { getAppSettingsByStore } = require('./settings');

// get the webpack compiler
const compiler = require('./libs/compiler');

// get the mode arg from
// `npm run yves [storeId1 storeId2... storeIdN]`
// defined in package.json as script
const [mode, ...storeIds] = process.argv.slice(2);

// get the webpack configuration associated with the provided mode
const getConfiguration = require(`./configs/${mode}`);

// get the promise for each store webpack configuration
const configurationPromises = getStoresByIds(storeIds)
    .map(getAppSettingsByStore)
    .map(getConfiguration);

// clear all assets
compiler.clearAllAssets(storeIds);

// build the project
Promise.all(configurationPromises)
    .then(configs => compiler.multiCompile(configs))
    .catch(error => console.error('An error occur while creating configuration', error));
