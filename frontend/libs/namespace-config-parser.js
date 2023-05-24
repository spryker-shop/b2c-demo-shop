const getNamespaceMap = (pathToConfig) => {
    const namespaceJson = require(pathToConfig);
    const namespaceMap = new Map();

    namespaceJson.namespaces.forEach((item) => {
        namespaceMap.set(item.namespace, item);
    });

    return namespaceMap;
};

const printWrongNamespaceMessage = (namespace) => {
    console.error(`Namespace "${namespace}" does not exist.`);
    process.exit(1);
};

const getFilteredNamespaceConfigList = (requestedArguments) => {
    const namespaceMap = getNamespaceMap(requestedArguments.pathToConfig);

    if (!requestedArguments.namespaces.length) {
        requestedArguments.namespaces = Array.from(namespaceMap.keys());
    }

    requestedArguments.namespaces
        .filter((requestedNamespace) => !namespaceMap.has(requestedNamespace))
        .map(printWrongNamespaceMessage);

    const generateNamespaceConfig = (requestedNamespace) => {
        const namespaceConfig = Object.assign(namespaceMap.get(requestedNamespace));
        namespaceConfig.themes.push(namespaceConfig.defaultTheme);

        if (!requestedArguments.themes.length) {
            return namespaceConfig;
        }

        requestedArguments.themes.map((theme) => {
            if (!namespaceConfig.themes.includes(theme)) {
                console.warn(`Theme "${theme}" does not exist in "${requestedNamespace}" namespace.`);
            }
        });

        namespaceConfig.themes = namespaceConfig.themes.filter((namespaceTheme) =>
            requestedArguments.themes.includes(namespaceTheme),
        );

        return namespaceConfig;
    };

    return requestedArguments.namespaces
        .filter((requestedNamespace) => namespaceMap.has(requestedNamespace))
        .map((requestedNamespace) => generateNamespaceConfig(requestedNamespace));
};

module.exports = {
    getFilteredNamespaceConfigList,
};
