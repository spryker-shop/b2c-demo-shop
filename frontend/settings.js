const { join, resolve } = require('path');

// define global settings
const globalSettings = {
    // define the current context (root)
    context: process.cwd(),

    // build modes
    modes: {
        dev: 'development',
        watch: 'development-watch',
        prod: 'production',
    },

    paths: {
        // locate the typescript configuration json file
        tsConfig: './tsconfig.json',

        // path to frontend build config json file
        namespaceConfig: './config/Yves/frontend-build-config.json',

        // sprykerShop core folders
        core: './vendor/spryker-shop',

        // spryker core folders
        sprykerCore: './vendor/spryker',

        // eco folders
        eco: './vendor/spryker-eco',

        // project folders
        project: './src/Pyz/Yves',

        // paths for icon sprite
        iconSprite: {
            sources: [
                './src/Pyz/Yves/ShopUi/Theme/default/components/atoms/icon-sprite/icon-sprite.twig',
                './vendor/spryker-shop/shop-ui/src/SprykerShop/Yves/ShopUi/Theme/default/components/atoms/icon-sprite/icon-sprite.twig',
            ],
            target: './frontend/assets/global/default/icons/sprite.svg',
        },
    },

    expectedModeArgument: 2,
};

const imageOptimizationOptions = {
    enabledInModes: {
        development: false,
        'development-watch': false,
        production: false,
    },

    // available options https://github.com/imagemin/imagemin-mozjpeg#api
    jpg: {
        quality: 60,
    },

    // available options https://github.com/imagemin/imagemin-pngquant#api
    png: {
        quality: [0.6, 0.7],
    },

    // available options https://github.com/svg/svgo#what-it-can-do
    svg: {
        removeViewBox: false,
    },

    // available options https://github.com/imagemin/imagemin-gifsicle#api
    gif: {
        optimizationLevel: 2,
    },
};

const getAppSettingsByTheme = (namespaceConfig, theme, pathToConfig) => {
    const entryPointsParts = [
        'components/atoms/*/index.ts',
        'components/molecules/*/index.ts',
        'components/organisms/*/index.ts',
        'templates/*/index.ts',
        'views/*/index.ts',
    ];

    // getting collection of entry points by pattern
    const entryPointsCollection = (pathPattern) => entryPointsParts.map((element) => `${pathPattern}/${element}`);

    // define the application name
    const name = 'yves_default';

    // get namespace config
    const namespaceJson = require(pathToConfig);

    // get public url path according to pattern from config
    const getPublicUrl = () =>
        namespaceJson.path
            .replace(/%SPRYKER_BUILD_HASH%/gi, process.env.SPRYKER_BUILD_HASH || 'current')
            .replace(/%namespace%/gi, namespaceConfig.namespace)
            .replace(/%theme%/gi, theme);

    const getPublicStaticUrl = () => namespaceJson.staticPath;

    // get array of available module suffixes
    const getAllCodeBuckets = () => namespaceJson.namespaces.map((namespace) => namespace.codeBucket);

    // get array of ignored modules
    const ignoreModulesCollection = () =>
        getAllCodeBuckets()
            .filter((suffix) => suffix !== namespaceConfig.codeBucket)
            .map((suffix) => `!**/*${suffix}/Theme/**`);

    // define ignore patterns
    const ignoreFiles = [
        '!config',
        '!data',
        '!deploy',
        '!node_modules',
        '!public',
        '!test',
        ...ignoreModulesCollection(),
    ];

    // define relative urls to site host (/)
    const urls = {
        // assets base url
        assets: getPublicUrl(),
        // static assets base url
        staticAssets: getPublicStaticUrl(),
    };

    // define project relative paths to context
    const paths = {
        // locate the typescript configuration json file
        tsConfig: globalSettings.paths.tsConfig,

        // getting assets paths collection
        assets: {
            // global assets folder
            globalAssets: `./frontend/assets/global/${theme}`,

            // static assets source folder
            staticAssets: `./frontend/static`,

            // assets folder for current theme into namespace
            currentAssets: join('./frontend/assets', namespaceConfig.namespace, theme),
        },

        // public folder with all assets
        publicAll: globalSettings.paths.publicAll,

        // current namespace and theme public assets folder
        public: join('./public/Yves', urls.assets),

        publicStatic: resolve('./public/Yves', urls.staticAssets),

        // core folders
        core: globalSettings.paths.core,

        sprykerCore: globalSettings.paths.sprykerCore,

        // eco folders
        eco: globalSettings.paths.eco,

        // project folders
        project: globalSettings.paths.project,

        iconSprite: globalSettings.paths.iconSprite,
    };

    // define if current theme is empty
    const isDefaultTheme = theme === namespaceConfig.defaultTheme;
    const getThemeName = (isFallbackPattern) => (isFallbackPattern ? namespaceConfig.defaultTheme : theme);
    const isFallbackPatternAndDefaultTheme = (isFallbackPattern) => isFallbackPattern && isDefaultTheme;

    // define entry point patterns for current theme, if current theme is defined
    const customThemeEntryPointPatterns = (isFallbackPattern = false) => {
        return isFallbackPatternAndDefaultTheme(isFallbackPattern)
            ? []
            : [
                  ...entryPointsCollection(`**/Theme/${getThemeName(isFallbackPattern)}`),
                  ...entryPointsCollection(
                      `**/*${namespaceConfig.codeBucket}/Theme/${getThemeName(isFallbackPattern)}`,
                  ),
                  ...ignoreFiles,
              ];
    };

    const shopUiEntryPointsPattern = (isFallbackPattern = false) =>
        isFallbackPatternAndDefaultTheme(isFallbackPattern)
            ? []
            : [
                  `./ShopUi/Theme/${getThemeName(isFallbackPattern)}`,
                  `./ShopUi${namespaceConfig.codeBucket}/Theme/${getThemeName(isFallbackPattern)}`,
              ];

    // define if current mode is production
    const isProductionMode = () => {
        const currentMode = process.argv.slice(globalSettings.expectedModeArgument)[0];
        return currentMode === globalSettings.modes.prod;
    };

    // array of patterns for the critical components
    const criticalPatterns = ['**/ShopUi/**', '**/CatalogPage/**', '**/HomePage/**', '**/ProductDetailPage/**'];

    // return settings
    return {
        name,
        namespaceConfig,
        theme,
        paths,
        urls,
        imageOptimizationOptions,
        criticalPatterns,

        context: globalSettings.context,

        isProductionMode: isProductionMode(),

        // define settings for suite-frontend-builder finder
        find: {
            // entry point patterns (components)
            componentEntryPoints: {
                // absolute dirs in which look for
                dirs: [
                    join(globalSettings.context, paths.core),
                    join(globalSettings.context, paths.sprykerCore),
                    join(globalSettings.context, paths.eco),
                    join(globalSettings.context, paths.project),
                ],
                // files/dirs patterns
                patterns: customThemeEntryPointPatterns(),
                fallbackPatterns: customThemeEntryPointPatterns(true),
            },

            // core component styles finder settings
            // important: this part is used in shared scss environment
            // do not change unless necessary
            componentStyles: {
                // absolute dirs in which look for
                dirs: [join(globalSettings.context, paths.core), join(globalSettings.context, paths.sprykerCore)],
                // files/dirs patterns
                patterns: [
                    `**/Theme/${namespaceConfig.defaultTheme}/components/atoms/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/components/molecules/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/components/organisms/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/templates/*/*.scss`,
                    `**/Theme/${namespaceConfig.defaultTheme}/views/*/*.scss`,
                    `!**/Theme/${namespaceConfig.defaultTheme}/**/style.scss`,
                    ...ignoreFiles,
                ],
            },

            // entry point patterns (application files)
            shopUiEntryPoints: {
                dirs: [join(globalSettings.context, paths.project)],
                patterns: [...shopUiEntryPointsPattern()],
                fallbackPatterns: [...shopUiEntryPointsPattern(true)],
            },
        },
    };
};

const getAppSettings = (namespaceConfigList, pathToConfig) => {
    const appSettings = [];
    namespaceConfigList.forEach((namespaceConfig) => {
        namespaceConfig.themes.forEach((theme) => {
            appSettings.push(getAppSettingsByTheme(namespaceConfig, theme, pathToConfig));
        });
    });
    return appSettings;
};

module.exports = {
    globalSettings,
    getAppSettings,
};
