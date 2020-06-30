const commandLineParser = require('commander');
const { join } = require('path');
const { globalSettings } = require('../settings');
const { scripts } = require('../../package.json');
let mode = null;

const collectArguments = (argument, argumentCollection) => {
    argumentCollection.push(argument);
    return argumentCollection;
};

const validateMode = requestedMode => {
    const { modes } = globalSettings;
    const isValidMode = Object.values(modes).find(mode => mode === requestedMode);

    if (!isValidMode) {
        throw new Error(`Mode "${requestedMode}" is not available`);
    }
};

const getAllowedFlagsData = (commandLineParserInfo, configData) => {
    const allowedFlagsData = {};

    commandLineParserInfo.options.forEach(option => {
        const {
            short: shortFlagName,
            long: longFlagName,
            required: isFlagValueRequired
        } = option;

        allowedFlagsData[shortFlagName] = {
            required: isFlagValueRequired,
        };

        allowedFlagsData[longFlagName] = {
            required: isFlagValueRequired,
        };
    });

    Object.values(configData).forEach(value => {
        const flagsData = value.match(/--[a-z]{1,}/g);

        if (flagsData) {
            flagsData.forEach(flag => {
                allowedFlagsData[flag] = {
                    required: false,
                };
            })
        }
    });

    return allowedFlagsData;
};

const validateFlag = (flag, allowedFlagsData) => {
    if (!flag.indexOf('-') && !allowedFlagsData[flag]) {
        throw new Error(`Flag "${flag}" is not available`);
    }
};

const isCommand = (allowedFlagsData, args, index) => {
    const previousParameter = args[index - 1];
    const currentParameter = args[index];
    const isFlag = !currentParameter.indexOf('-');
    const isFlagValue = !previousParameter.indexOf('-') && allowedFlagsData[previousParameter].required;
    const isValidCommand = !!scripts[currentParameter] || currentParameter === 'node';

    if (isFlag || isFlagValue) {
        return false;
    }

    if (isValidCommand) {
        return true;
    }

    throw new Error(`Command "${args[index]}" is not available`);
};

const validateParameters = env => {
    if (!env || !env.npm_config_argv) {
        return;
    }

    const originalArgumentsString = env.npm_config_argv;
    const { original: originalArguments } = JSON.parse(originalArgumentsString);

    originalArguments.forEach(argument => {
        if (!argument.indexOf('-') && !originalArguments.includes('--')) {
            throw new Error('It is impossible to use flags without "--" indentifier if you use "npm" script.');
        }
    });
};

const parseCommandLine = () => (
    commandLineParser
        .option('-n, --namespace <namespace name>', 'build the requested namespace. Multiple arguments are allowed.', collectArguments, [])
        .option('-t, --theme <theme name>', 'build the requested theme. Multiple arguments are allowed.', collectArguments, [])
        .option('-i, --info', 'information about all namespaces and available themes')
        .option('-c, --config <path>', 'path to JSON file with namespace config', globalSettings.paths.namespaceConfig)
        .option('-r, --replace', 'replace optimized images')
        .option('-m, --module <module>', 'build determined module version', globalSettings.buildVariants)
        .arguments('<mode>')
        .action(function (modeValue) {
            const { argv, env } = process;
            const modeIndexInArgs = argv.findIndex(element => element === modeValue);
            const allowedFlagsData = getAllowedFlagsData(this, scripts);

            validateParameters(env);

            argv.forEach((arg, index) => {
                if (index <= modeIndexInArgs) {
                    return;
                }

                validateMode(modeValue);
                validateFlag(arg, allowedFlagsData);

                if (isCommand(allowedFlagsData, argv, index)) {
                    console.warn('It is impossible to use several commands. All commands and parameters entered after the second command are ignored.');
                }
            });

            mode = modeValue;
        })
        .parse(process.argv)
);

const printAvailableNamespacesAndThemes = (commandLineParameters, pathToConfig) => {
    const namespaceJson = require(pathToConfig);

    if (!commandLineParameters.info) {
        return;
    }

    console.log('Namespaces with available themes:');
    namespaceJson.namespaces.forEach(namespaceConfig => {
        console.log(`- ${namespaceConfig.namespace}`);
        console.log(`  ${namespaceConfig.defaultTheme}`);
        if (namespaceConfig.themes.length) {
            namespaceConfig.themes.forEach(theme => console.log(`  ${theme}`));
        }
    });
    console.log('');
    process.exit();
};

const getAttributes = () => {
    const commandLineParameters = parseCommandLine();
    const pathToConfig = join(globalSettings.context, commandLineParameters.config);

    printAvailableNamespacesAndThemes(commandLineParameters, pathToConfig);

    return {
        mode: mode,
        namespaces: commandLineParameters.namespace,
        themes: commandLineParameters.theme,
        pathToConfig: pathToConfig,
        replaceOptimizedImages: commandLineParameters.replace,
    };
};

module.exports = getAttributes;
