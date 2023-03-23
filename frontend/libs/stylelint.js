const stylelint = require('stylelint');
const { globalSettings } = require('../settings');
const commandLineParser = require('commander');

commandLineParser
    .option('-f, --fix', 'execute stylelint in the fix mode.')
    .option('-p, --file-path <path>', 'execute stylelint only for this file.')
    .parse(process.argv);

const isFixMode = !!commandLineParser.fix;
const defaultFilePaths = [`${globalSettings.paths.project}/**/*.scss`];
const filePaths = commandLineParser.filePath ? [commandLineParser.filePath] : defaultFilePaths;

stylelint
    .lint({
        configFile: `${globalSettings.context}/node_modules/@spryker/frontend-config.stylelint/.stylelintrc.json`,
        files: filePaths,
        syntax: 'scss',
        formatter: 'string',
        fix: isFixMode,
    })
    .then(function (data) {
        if (data.errored) {
            const messages = JSON.parse(JSON.stringify(data.output));
            process.stdout.write(messages);
            process.exit(1);
        }
    })
    .catch(function (error) {
        console.error(error.stack);
        process.exit(1);
    });
