const imagemin = require('imagemin');
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminPngquant = require('imagemin-pngquant');
const imageminSvgo = require('imagemin-svgo');
const imageminGifsicle = require('imagemin-gifsicle');

const { lstatSync, readdir, existsSync } = require('fs');
const util = require('util');
const readdirAsync = util.promisify(readdir);

const { join, normalize } = require('path');
const { globalSettings } = require('../settings');

let isGlobalImagesOptimized = false;

async function asyncForEach(array, callback) {
    for (let index = 0; index < array.length; index++) {
        await callback(array[index], index, array);
    }
}

const imagesOptimization = (appSettings, requestedArguments) => {
    let isPublicOutput = false;
    let shouldOptimize = true;
    const shouldReplaceImages = requestedArguments ? requestedArguments.replaceOptimizedImages : false;

    const currentMode = process.argv.slice(globalSettings.expectedModeArgument)[0];

    if (Object.keys(appSettings.imageOptimizationOptions.enabledInModes).includes(currentMode)) {
        isPublicOutput = true;
        shouldOptimize = appSettings.imageOptimizationOptions.enabledInModes[currentMode];
    }

    if (!shouldOptimize) {
        return;
    }

    try {
        Object.values(appSettings.paths.assets).map(async assetsPath => {
            const assetsImagePath = normalize(join(assetsPath, '/images/'));
            const assetsImagePattern = '/*.{jpg,png,svg,gif}';
            const outputPattern = shouldReplaceImages ?
                '/images/' :
                '/images/optimized-images/';
            const outputPath = isPublicOutput ?
                normalize(join(appSettings.paths.public, '/images/')) :
                normalize(join(assetsPath, outputPattern));

            const isGlobalImages = assetsPath === appSettings.paths.assets.globalAssets;

            if (!existsSync(assetsImagePath) || isGlobalImages && isGlobalImagesOptimized && !isPublicOutput) {
                return;
            }

            const isDirectory = source => lstatSync(source).isDirectory();

            const getDirectories = async source => {
                const innerFolders = await readdirAsync(source);
                return innerFolders
                    .map(name => join(source, name))
                    .filter(isDirectory);
            };

            const getDirectoriesRecursive = async source => {
                const foundFolders = await getDirectories(source);
                const foundFoldersPromises = foundFolders.map(async (dir) => await getDirectoriesRecursive(dir));
                const allFolders = await Promise.all(foundFoldersPromises);
                return [
                    source,
                    ...allFolders.reduce((a, b) => a.concat(b), [])
                ];
            };

            const assetsImageFolders = await getDirectoriesRecursive(assetsImagePath);

            const outputImageFolders = assetsImageFolders
                .map(imagePath => imagePath.replace(assetsImagePath,''))
                .map(imageInnerFolder => join(outputPath, imageInnerFolder));


            await asyncForEach(assetsImageFolders, async (dir, index) => {
                imagemin([`${dir}${assetsImagePattern}`], {
                    destination: outputImageFolders[index],
                    plugins: [
                        imageminMozjpeg(appSettings.imageOptimizationOptions.jpg),
                        imageminPngquant(appSettings.imageOptimizationOptions.png),
                        imageminSvgo({
                            plugins: [appSettings.imageOptimizationOptions.svg],
                        }),
                        imageminGifsicle(appSettings.imageOptimizationOptions.gif),
                    ]
                });
            });

            if (isGlobalImages) {
                isGlobalImagesOptimized = true;
            }
        }, []);

        console.info(`${appSettings.namespaceConfig.namespace} (${appSettings.theme} theme) --> images successfully compressed!`);
    } catch ({message}) {
        console.error('Images compression has been interrupted with error: ', message);
    }
};

module.exports = imagesOptimization;
