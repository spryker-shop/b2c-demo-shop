const path = require('path');
const { Linter, Configuration } = require('tslint');
const { globalSettings } = require('../settings');
const colors = require('colors');
const expectedFormatterArgument = 2;

/**
 * List of output formatters for the tslint.
 * https://palantir.github.io/tslint/formatters/
 */
const outputFormatter = () => {
    const formatterName = process.argv.slice(expectedFormatterArgument)[0];
    const defaultFormatter = 'codeFrame';
    return formatterName ? formatterName : defaultFormatter;
};

const linterOptions = {
    fix: false,
    formatter: outputFormatter(),
};

const runTSLint = () => {
    const program = Linter.createProgram('tsconfig.json', globalSettings.context);
    const configurationFilename = path.join(globalSettings.context, 'tslint.json');
    const linter = new Linter(linterOptions, program);
    const files = Linter.getFileNames(program);

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
    if (errorCount > 0 && process.env.NODE_ENV !== 'development') {
        process.exit(1);
    }
};

runTSLint();
