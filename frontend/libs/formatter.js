const { spawn } = require('child_process');
const { globalSettings } = require('../settings');
const commandLineParser = require('commander');
const configPath = 'node_modules/@spryker/frontend-config.prettier/.prettierrc.json';

commandLineParser
    .option('-f, --fix', 'execute stylelint in the fix mode.')
    .option('-p, --file-path <path>', 'execute stylelint only for this file.')
    .option('-i, --ignore-path <path>', 'path to prettier ignore file.')
    .parse(process.argv);

const mode = commandLineParser.fix ? '--write' : '--check';
const filePaths = commandLineParser.filePath ? [commandLineParser.filePath] : globalSettings.formatter;
const ignorePath = commandLineParser.ignorePath ? commandLineParser.ignorePath : './.prettierignore';

spawn(
    'npx',
    ['prettier', '--config', configPath, '--ignore-path', ignorePath, mode, ...filePaths],
    { stdio: 'inherit' }
);
