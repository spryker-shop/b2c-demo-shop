const fs = require('fs').promises;
const path = require('path');
const { existsSync } = require('fs');

/**
 * Extracts SVG sprites from the first available Twig file and saves them to the target location
 * @param {Object} options Configuration options
 * @param {string|string[]} options.sourcePath Path or paths to the source Twig file(s)
 * @param {string} options.targetPath Path where the SVG file should be saved
 * @returns {Promise<void>}
 */
const extractIconSprites = async ({ sourcePath, targetPath }) => {
    try {
        console.info('Extracting icon sprites...');

        const sourcePaths = Array.isArray(sourcePath) ? sourcePath : [sourcePath];
        let twigContent = null;
        let usedPath = null;

        for (const path of sourcePaths) {
            if (existsSync(path)) {
                twigContent = await fs.readFile(path, 'utf8');
                usedPath = path;
                console.info(`Using icon sprite from: ${path}`);
                break;
            }
        }

        if (!twigContent) {
            throw new Error('None of the provided icon sprite paths exist');
        }

        const spacelessRegex = /{% apply spaceless %}([\s\S]*?)(?:{% endapply %}|$)/;
        const match = twigContent.match(spacelessRegex);

        if (!match || !match[1]) {
            throw new Error(`Could not find content within spaceless block in the Twig file: ${usedPath}`);
        }

        const svgContent = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">\n${match[1]}\n</svg>`;

        const targetDir = path.dirname(targetPath);
        await fs.mkdir(targetDir, { recursive: true });

        await fs.writeFile(targetPath, svgContent, 'utf8');

        console.info('Icon sprites successfully extracted to', targetPath);
    } catch (error) {
        console.error('Error extracting icon sprites:', error.message);
    }
};

module.exports = extractIconSprites;
