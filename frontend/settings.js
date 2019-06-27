const { join } = require('path');

// define global settings
const globalSettings = {
    // define the current context (root)
    context: process.cwd(),

    paths: {
        // locate the typescript configuration json file
        tsConfig: './tsconfig.json',

        // core folders
        core: './vendor/spryker-shop',

        // eco folders
        eco: './vendor/spryker-eco',

        // project folders
        project: './src/Pyz/Yves',

        publicAssets: './public/Yves/assets'
    }
};

const getAppSettingsByStore = store => {
    const entryPointsParts = [
        'components/atoms/*/index.ts',
        'components/molecules/*/index.ts',
        'components/organisms/*/index.ts',
        'templates/*/index.ts',
        'views/*/index.ts'
    ];

    const ignoreFiles = [
        '!config',
        '!data',
        '!deploy',
        '!node_modules',
        '!public',
        '!test'
    ];

    // getting collection of entry points by pattern
    const entryPointsCollection = (pathPattern) => entryPointsParts.map((element) => `${pathPattern}/${element}`);

    // define current theme
    const currentTheme = store.currentTheme || store.defaultTheme;

    // define if current theme is empty
    const isCurrentThemeEmpty = currentTheme !== store.currentTheme;

    // define the applicatin name
    // important: the name must be normalized
    const name = 'yves_default';

    // define relative urls to site host (/)
    const urls = {
        // assets base url
        defaultAssets: join('/assets', store.name, store.defaultTheme),
        currentAssets: join('/assets', store.name, currentTheme)
    };

    // getting assets paths collection
    const assetPaths = () => {
        const assetPathsCollection = {
            // global assets folder
            globalAssets: `./frontend/assets/global/${isCurrentThemeEmpty ? store.defaultTheme : currentTheme}`,

            // assets folder for current theme in store
            defaultAssets: join('./frontend', urls.defaultAssets),
        };

        if (!isCurrentThemeEmpty) {
            // assets folder for current theme in store
            assetPathsCollection.currentAssets = join('./frontend', urls.currentAssets);
        }

        return assetPathsCollection;
    };

    // define project relative paths to context
    const paths = {
        // locate the typescript configuration json file
        tsConfig: globalSettings.paths.tsConfig,

        assets: assetPaths(),

        // public folder with all assets
        publicAll: globalSettings.paths.publicAll,

        // current store and theme public assets folder
        public: join('./public/Yves', urls.currentAssets),

        // core folders
        core: globalSettings.paths.core,

        // eco folders
        eco: globalSettings.paths.eco,

        // project folders
        project: globalSettings.paths.project
    };

    const isThemeCurrentAndNotEmpty = isThemeCurrent => isThemeCurrent && isCurrentThemeEmpty;
    const getThemeName = isThemeCurrent => isThemeCurrent ? currentTheme : store.defaultTheme;

    // define entry point patterns for current theme, if current theme is defined
    const customThemeEntryPointPatterns = (isThemeCurrent = false) => (
        isThemeCurrentAndNotEmpty(isThemeCurrent) ? [] : [
            ...entryPointsCollection(`**/Theme/${getThemeName(isThemeCurrent)}`),
            ...entryPointsCollection(`**/*${store.name}/Theme/${getThemeName(isThemeCurrent)}`),
            ...ignoreFiles
        ]
    );

    const shopUiEntryPointsPattern = (isThemeCurrent = false) => (
        isThemeCurrentAndNotEmpty(isThemeCurrent) ? [] : [
            `./ShopUi/Theme/${getThemeName(isThemeCurrent)}`,
            `./ShopUi${store.name}/Theme/${getThemeName(isThemeCurrent)}`
        ]
    );

    // return settings
    return {
        name,
        store,
        paths,
        urls,

        context: globalSettings.context,

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
                patterns: customThemeEntryPointPatterns(true),
                fallbackPatterns: customThemeEntryPointPatterns()
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
                    `**/Theme/${store.defaultTheme}/components/atoms/*/*.scss`,
                    `**/Theme/${store.defaultTheme}/components/molecules/*/*.scss`,
                    `**/Theme/${store.defaultTheme}/components/organisms/*/*.scss`,
                    `**/Theme/${store.defaultTheme}/templates/*/*.scss`,
                    `**/Theme/${store.defaultTheme}/views/*/*.scss`,
                    `!**/Theme/${store.defaultTheme}/**/style.scss`,
                    ...ignoreFiles
                ]
            },

            shopUiEntryPoints: {
                dirs: [
                    join(globalSettings.context, paths.project)
                ],
                patterns: [
                    ...shopUiEntryPointsPattern(true)

                ],
                fallbackPatterns: [
                    ...shopUiEntryPointsPattern()
                ]
            }
        }
    }
};

module.exports = {
    globalSettings,
    getAppSettingsByStore
};
