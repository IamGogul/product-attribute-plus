const fs = require('fs');
const path = require('path');

const sourceFile = path.join(__dirname, 'assets/public/css/style.css');
const targetFile = path.join(__dirname, 'assets/public/css/style.min.css');

// Read the contents of style.css
fs.readFile(sourceFile, 'utf8', (err, data) => {
    if (err) {
        console.error('Error reading file:', err);
        return;
    }

    // Write the contents to style.min.css
    fs.writeFile(targetFile, data, 'utf8', (err) => {
        if (err) {
            console.error('Error writing file:', err);
            return;
        }

        console.log('style.min.css has been created.');
    });
});