const path = require('path');

// define the applicatin name
// important: the name must be normalized
const name = 'yves_default';

// define the current theme
const theme = 'default';

// define the current context (root)
const context = process.cwd();

// define project relative paths to context
const paths = {
    // locate the typescript configuration json file
    tsConfig: './tsconfig.json',

    // assets folder
    assets: './frontend/assets',

    // public folder
    public: './public/Yves/assets',

    // core folders
    core: {
        // all modules
        modules: './vendor/spryker-shop',
        // ShopUi source folder
        shopUiModule: `./vendor/spryker-shop/shop-ui/src/SprykerShop/Yves/ShopUi/Theme/${theme}`
    },

    // eco folders
    eco: {
        // all modules
        modules: './vendor/spryker-eco'
    },

    // project folders
    project: {
        // all modules
        modules: './src/Pyz/Yves',
        // ShopUi source folder
        shopUiModule: `./src/Pyz/Yves/ShopUi/Theme/${theme}`
    }
};

// define relative urls to site host (/)
const urls = {
    // assets base url
    assets: '/assets'
};

// define components directories patterns
const componentDirsPattern = {
    atoms: `**/Theme/${theme}/components/atoms`,
    molecules: `**/Theme/${theme}/components/molecules`,
    organisms: `**/Theme/${theme}/components/organisms`,
    templates: `**/Theme/${theme}/templates`,
    views: `**/Theme/${theme}/views`,
};

// define ignore dirs for entry points
const ignoreDirs = [
    '!config',
    '!data',
    '!deploy',
    '!node_modules',
    '!public',
    '!test'
];

// export settings
module.exports = {
    name,
    theme,
    context,
    paths,
    urls,
    componentDirsPattern,
    ignoreDirs,

    // define settings for suite-frontend-builder finder
    find: {
        // webpack entry points (components) finder settings
        componentEntryPoints: {
            // absolute dirs in which look for
            dirs: [
                path.join(context, paths.core.modules),
                path.join(context, paths.eco.modules),
                path.join(context, paths.project.modules)
            ],
            // files/dirs patterns
            patterns: [
                `${componentDirsPattern.atoms}/*/index.ts`,
                `${componentDirsPattern.molecules}/*/index.ts`,
                `${componentDirsPattern.organisms}/*/index.ts`,
                `${componentDirsPattern.templates}/*/index.ts`,
                `${componentDirsPattern.views}/*/index.ts`,
                ...ignoreDirs
            ]
        },

        // core component styles finder settings
        // important: this part is used in shared scss environment
        // do not change unless necessary
        componentStyles: {
            // absolute dirs in which look for
            dirs: [
                path.join(context, paths.core.modules)
            ],
            // files/dirs patterns
            patterns: [
                `${componentDirsPattern.atoms}/*/*.scss`,
                `${componentDirsPattern.molecules}/*/*.scss`,
                `${componentDirsPattern.organisms}/*/*.scss`,
                `${componentDirsPattern.templates}/*/*.scss`,
                `${componentDirsPattern.views}/*/*.scss`,
                `!**/Theme/${theme}/**/style.scss`,
                ...ignoreDirs
            ]
        }
    }
}
