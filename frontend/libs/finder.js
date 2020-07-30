const path = require('path');
const glob = require('fast-glob');

// define the default glob settings for fast-glob
const defaultGlobSettings = {
    followSymlinkedDirectories: false,
    absolute: true,
    onlyFiles: true,
    onlyDirectories: false
};

// perform a search in a list of directories
// matching provided patterns
// using provided glob settings
const globAsync = async (patterns, rootConfiguration) => {
    try {
        return await glob(patterns, rootConfiguration);
    } catch(error) {
        console.error('An error occurred while globbing the system for entry points.', error);
    }
};

const findFiles = (globDirs, globPatterns, globSettings) => (
    globDirs.reduce(async (resultsPromise, dir) => {
        const rootConfiguration = {
            ...defaultGlobSettings,
            ...globSettings,
            cwd: dir
        };

        const results = await resultsPromise;
        const globPath = await globAsync(globPatterns, rootConfiguration);

        return results.concat(globPath);
    }, Promise.resolve([]))
);

const find = async (globDirs, globPatterns, globFallbackPatterns, globSettings = {}) => {
    const customThemeFiles = await findFiles(globDirs, globPatterns, globSettings);
    const defaultThemeFiles = globFallbackPatterns.length ?
        await findFiles(globDirs, globFallbackPatterns, globSettings) : [];

    return defaultThemeFiles.concat(customThemeFiles);
};

// find entry points
const findEntryPoints = async settings => {
    const files = await find(settings.dirs, settings.patterns,  settings.fallbackPatterns, settings.globSettings);

    return Object.values(files.reduce((map, file) => {
        const dir = path.dirname(file);
        const name = path.basename(dir);
        const type = path.basename(path.dirname(dir));
        map[`${type}/${name}`] = file;
        return map;
    }, {}));
};

// find components entry points
const findComponentEntryPoints = async settings => await findEntryPoints(settings);

// find component styles
const findComponentStyles = async settings =>
    await find(settings.dirs, settings.patterns, [], settings.globSettings);

const findAppEntryPoint = async (settings, file) => {
    const config = Object.assign({}, settings);
    const updatePatterns = patternCollection => patternCollection.map(pattern => path.join(pattern, file));

    config.patterns = updatePatterns(config.patterns);
    config.fallbackPatterns = updatePatterns(config.fallbackPatterns);

    const entryPoint = await findEntryPoints(config);
    return entryPoint[entryPoint.length - 1];
};

module.exports = {
    findComponentEntryPoints,
    findComponentStyles,
    findAppEntryPoint,
};
