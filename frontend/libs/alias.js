const path = require('path');

// get the aliases from the tsconfig.json file
// and transform them in webpack alises
// allowing the definition of aliases in one place
const getAliasFromTsConfig = appSettings => {
    const tsConfigFile = path.join(appSettings.context, appSettings.paths.tsConfig);
    const tsConfig = require(tsConfigFile);
    const aliases = tsConfig.compilerOptions.paths;

    return Object.keys(aliases).reduce((map, name) => {
        if (name !== '*' && aliases[name].length) {
            const alias = name.replace(/(\/\*?)$/, '');
            const aliasPath = aliases[name][0].replace(/(\/\*?)$/, '');
            map[alias] = path.join(appSettings.context, aliasPath);
        }

        return map;
    }, {});
};

module.exports = {
    getAliasFromTsConfig
};
