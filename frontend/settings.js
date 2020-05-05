const { join } = require('path');

// define global settings
const globalSettings = {
    // define the current context (root)
    context: process.cwd(),

    // build modes
    modes: {
        dev: 'development',
        watch: 'development-watch',
        prod: 'production'
    },

    paths: {
        // locate the typescript configuration json file
        tsConfig: './tsconfig.json',

        // locate the typescript configuration json file
        namespaceConfig: './config/Yves/frontend-build-config.json',

        // core folders
        core: './vendor/spryker-shop',

        // eco folders
        eco: './vendor/spryker-eco',

        // project folders
        project: './src/Pyz/Yves'
    }
};

const getAppSettingsByTheme = (namespaceConfig, theme, pathToConfig) => {
    const entryPointsParts = [
        'components/atoms/*/index.ts',
        'components/molecules/*/index.ts',
        'components/organisms/*/index.ts',
        'templates/*/index.ts',
        'views/*/index.ts'
    ];

    // getting collection of entry points by pattern
    const entryPointsCollection = pathPattern => entryPointsParts.map(element => `${pathPattern}/${element}`);

    // define the applicatin name
    // important: the name must be normalized
    const name = 'yves_default';

    // get namespace config
    const namespaceJson = require(pathToConfig);

    // get public url path according to pattern from config
    const getPublicUrl = () => (
        namespaceJson.path
            .replace(/%namespace%/gi, namespaceConfig.namespace)
            .replace(/%theme%/gi, theme)
    );

    const getAllModuleSuffixes = () => namespaceJson.namespaces.map(namespace => namespace.moduleSuffix);

    const ignoreModulesCollection = () => {
        return getAllModuleSuffixes()
                    .filter(suffix => suffix !== namespaceConfig.moduleSuffix)
                    .map(suffix => `!**/*${suffix}/Theme/**`);
    };

    const ignoreFiles = [
        '!config',
        '!data',
        '!deploy',
        '!node_modules',
        '!public',
        '!test',
        ...ignoreModulesCollection()
    ];

    // define relative urls to site host (/)
    const urls = {
        // assets base url
        assets: getPublicUrl()
    };

    // define project relative paths to context
    const paths = {
        // locate the typescript configuration json file
        tsConfig: globalSettings.paths.tsConfig,

        // getting assets paths collection
        assets: {
            // global assets folder
            globalAssets: `./frontend/assets/global/${theme}`,

            // assets folder for current theme into namespace
            currentAssets: join('./frontend/assets', namespaceConfig.namespace, theme)
        },

        // current namespace and theme public assets folder
        public: join('./public/Yves', urls.assets),

        // core folders
        core: globalSettings.paths.core,

        // eco folders
        eco: globalSettings.paths.eco,

        // project folders
        project: globalSettings.paths.project
    };

    // define if current theme is empty
    const isDefaultTheme = theme === namespaceConfig.defaultTheme;
    const getThemeName = isFallbackPattern => isFallbackPattern ? namespaceConfig.defaultTheme : theme;
    const isFallbackPatternAndDefaultTheme = isFallbackPattern => (isFallbackPattern && isDefaultTheme);

    // define entry point patterns for current theme, if current theme is defined
    const customThemeEntryPointPatterns = (isFallbackPattern = false) => {
        return isFallbackPatternAndDefaultTheme(isFallbackPattern) ? [] : [
            ...entryPointsCollection(`**/Theme/${getThemeName(isFallbackPattern)}`),
            ...entryPointsCollection(`**/*${namespaceConfig.moduleSuffix}/Theme/${getThemeName(isFallbackPattern)}`),
            ...ignoreFiles
        ]
    };

    const shopUiEntryPointsPattern = (isFallbackPattern = false) => (
        isFallbackPatternAndDefaultTheme(isFallbackPattern) ? [] : [
            `./ShopUi/Theme/${getThemeName(isFallbackPattern)}`,
            `./ShopUi${namespaceConfig.moduleSuffix}/Theme/${getThemeName(isFallbackPattern)}`
        ]
    );

    // define if current mode is production
    const isProductionMode = () => {
        const currentMode = process.argv.slice(2)[0];
        return currentMode === globalSettings.modes.prod;
    };

    // return settings
    return {
        name,
        namespaceConfig,
        theme,
        paths,
        urls,

        context: globalSettings.context,

        isProductionMode: isProductionMode(),

        // define settings for suite-frontend-builder finder
        find: {
            // webpack entry points (components) finder settings
            componentEntryPoints: {
                // absolute dirs in which look for
                dirs: [
                    join(globalSettings.context, paths.core),
                    join(globalSettings.context, paths.eco),
                    join(globalSettings.context, paths.project)
                ],
                // files/dirs patterns
                patterns: customThemeEntryPointPatterns(),
                fallbackPatterns: customThemeEntryPointPatterns(true)
            },

            // core component styles finder settings
            // important: this part is used in shared scss environment
            // do not change unless necessary
            componentStyles: {
                // absolute dirs in which look for
                dirs: [
                    join(globalSettings.context, paths.core)
                ],
                // files/dirs patterns
                patterns: [
                    `**/Theme/${namespaceConfig.defaultTheme}/components/atoms/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/components/molecules/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/components/organisms/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/templates/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/views/*/*.scss`,
                    `!**/Theme/${namespaceConfig.defaultTheme}/**/style.scss`,
                    ...ignoreFiles
                ]
            },

            shopUiEntryPoints: {
                dirs: [
                    join(globalSettings.context, paths.project)
                ],
                patterns: [
                    ...shopUiEntryPointsPattern()
                ],
                fallbackPatterns: [
                    ...shopUiEntryPointsPattern(true)
                ]
            }
        }
    }
};

const getAppSettings = (namespaceConfigList, pathToConfig) => {
    let appSettings = [];
    namespaceConfigList.forEach(namespaceConfig => {
        namespaceConfig.themes.forEach(theme => {
            appSettings.push(getAppSettingsByTheme(namespaceConfig, theme, pathToConfig));
        })
    });
    return appSettings;
};

module.exports = {
    globalSettings,
    getAppSettings
};
