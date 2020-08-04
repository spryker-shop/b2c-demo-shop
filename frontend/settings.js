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

    // build modules
    buildVariants: {
        esm: 'esm',
        legacy: 'legacy',
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
        project: './src/Pyz/Yves',
    },

    expectedModeArgument: 2,
};

const imageOptimizationOptions = {
    enabledInModes: {
        'development': false,
        'development-watch': false,
        'production': false,
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

const buildVariantArray = process.argv.filter(argv => argv.includes('module'));
const buildVariant = buildVariantArray.length ? buildVariantArray[0].replace('module:', '') : '';

const buildVariantSettings = {
    buildVariant,
    isES6Module: buildVariant === globalSettings.buildVariants.esm,
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
            .replace(/%SPRYKER_BUILD_HASH%/gi, process.env.SPRYKER_BUILD_HASH || 'current')
            .replace(/%namespace%/gi, namespaceConfig.namespace)
            .replace(/%theme%/gi, theme)
    );

    const getPublicStaticUrl = () => namespaceJson.staticPath;

    const getAllCodeBuckets = () => namespaceJson.namespaces.map(namespace => namespace.codeBucket);

    const ignoreModulesCollection = () => {
        return getAllCodeBuckets()
                    .filter(suffix => suffix !== namespaceConfig.codeBucket)
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
            currentAssets: join('./frontend/assets', namespaceConfig.namespace, theme)
        },

        // public folder with all assets
        publicAll: globalSettings.paths.publicAll,

        // current namespace and theme public assets folder
        public: join('./public/Yves', urls.assets),

        publicStatic: resolve('./public/Yves', urls.staticAssets),

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
            ...entryPointsCollection(`**/*${namespaceConfig.codeBucket}/Theme/${getThemeName(isFallbackPattern)}`),
            ...ignoreFiles
        ]
    };

    const shopUiEntryPointsPattern = (isFallbackPattern = false) => (
        isFallbackPatternAndDefaultTheme(isFallbackPattern) ? [] : [
            `./ShopUi/Theme/${getThemeName(isFallbackPattern)}`,
            `./ShopUi${namespaceConfig.codeBucket}/Theme/${getThemeName(isFallbackPattern)}`
        ]
    );

    // define if current mode is production
    const isProductionMode = () => {
        const currentMode = process.argv.slice(globalSettings.expectedModeArgument)[0];
        return currentMode === globalSettings.modes.prod;
    };

    // return settings
    return {
        name,
        namespaceConfig,
        theme,
        paths,
        urls,
        imageOptimizationOptions,

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
    getAppSettings,
    buildVariantSettings,
};
