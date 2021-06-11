const path = require('path');
const { Linter, Configuration } = require('tslint');
const { globalSettings } = require('../settings');
const colors = require('colors');
const commandLineParser = require('commander');

commandLineParser
    .option('-t, --format <format>', 'output format.')
    .option('-f, --fix', 'execute tslint in the fix mode.')
    .option('-p, --file-path <path>', 'execute tslint only for this file.')
    .option('-c, --config <fileName>', 'define config file name.')
    .option('-l, --config-lint <fileName>', 'define config lint file name.')
    .parse(process.argv);

/**
 * List of output formatters for the tslint.
 * https://palantir.github.io/tslint/formatters/
 */
const defaultFormat = 'codeFrame';
const defaultConfigLintFile = 'tslint.json';
const formatter = commandLineParser.format ? commandLineParser.format : defaultFormat;
const isFixMode = !!commandLineParser.fix;
const filePath = commandLineParser.filePath;
const configFile = commandLineParser.config ? commandLineParser.config : globalSettings.paths.tsConfig;
const configLintFile = commandLineParser.configLint ? commandLineParser.configLint : defaultConfigLintFile;

const linterOptions = {
    fix: isFixMode,
    formatter,
};

const runTSLint = () => {
    const program = Linter.createProgram(configFile, globalSettings.context);
    const configurationFilename = path.join(globalSettings.context, configLintFile);
    const linter = new Linter(linterOptions, program);
    const files = filePath ? [filePath] : Linter.getFileNames(program);

    lintFiles(program, configurationFilename, linter, files);
};

const lintFiles = (program, configurationFilename, linter, files) => {
    files.forEach(file => {
        const fileContents = program.getSourceFile(file).getFullText();
        const configuration = Configuration.findConfiguration(configurationFilename, file).results;
        linter.lint(file, fileContents, configuration);
    });

    showLintOutput(linter);
};

const showLintOutput = linter => {
    const lintingResult = linter.getResult();

    console.log(
        lintingResult.output,
        `Errors count: ${colors.red.underline(lintingResult.errorCount)}\n`
    );

    exitProcess(lintingResult.errorCount);
};

const exitProcess = errorCount => {
    if (errorCount > 0) {
        process.exit(1);
    }
};

runTSLint();
