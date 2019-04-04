const stylelint = require('stylelint');
const appSettings = require('../settings');

stylelint.lint({
    files: [`${appSettings.paths.project.modules}/**/*.scss`],
    syntax: "scss",
    formatter: "string",
}).then(function(data) {
    if (data.errored) {
        const messages = JSON.parse(JSON.stringify(data.output));
        process.stdout.write(messages);
        if(process.env.NODE_ENV !== 'development') {
            process.exit(1);
        }
    }
}).catch(function(error) {
    console.error(error.stack);
});
