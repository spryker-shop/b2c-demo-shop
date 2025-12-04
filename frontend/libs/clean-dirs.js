const fs = require('fs');

module.exports = function cleanDirs(dirs) {
    for (const dir of dirs) {
        if (!fs.existsSync(dir)) {
            return;
        }

        fs.rmSync(dir, { recursive: true, force: true });
        console.log(`🧹 Cleaned: ${dir}`);
    }
};
