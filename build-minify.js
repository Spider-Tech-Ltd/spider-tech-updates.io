const fs = require('fs');
const path = require('path');
const CleanCSS = require('clean-css');
const { minify } = require('terser');

const cleanCssInstance = new CleanCSS({
    level: {
        1: {
            all: true,
            normalizeUrls: false
        }
    },
    compatibility: '*'
});

async function minifyFiles() {
    console.log('=== Starting Production Minification ===\n');
    let totalCssOriginal = 0;
    let totalCssMinified = 0;
    let totalJsOriginal = 0;
    let totalJsMinified = 0;

    // 1. Minify CSS directory
    const cssDir = path.join(__dirname, 'css');
    const cssFiles = fs.readdirSync(cssDir).filter(f => f.endsWith('.css'));
    console.log(`Processing ${cssFiles.length} CSS files in css/...`);

    for (const file of cssFiles) {
        const filePath = path.join(cssDir, file);
        const originalContent = fs.readFileSync(filePath, 'utf8');
        const origSize = Buffer.byteLength(originalContent, 'utf8');
        totalCssOriginal += origSize;

        const output = cleanCssInstance.minify(originalContent);
        if (output.errors && output.errors.length > 0) {
            console.error(`  ✕ Error minifying ${file}:`, output.errors);
            totalCssMinified += origSize;
            continue;
        }

        fs.writeFileSync(filePath, output.styles, 'utf8');
        const minSize = Buffer.byteLength(output.styles, 'utf8');
        totalCssMinified += minSize;
        const savings = origSize > 0 ? ((origSize - minSize) / origSize * 100).toFixed(1) : 0;
        console.log(`  ✓ ${file}: ${(origSize/1024).toFixed(1)} KB -> ${(minSize/1024).toFixed(1)} KB (${savings}% saved)`);
    }

    // 2. Minify JS directory
    const jsDir = path.join(__dirname, 'js');
    const jsFiles = fs.readdirSync(jsDir).filter(f => f.endsWith('.js'));
    console.log(`\nProcessing ${jsFiles.length} JS files in js/...`);

    for (const file of jsFiles) {
        const filePath = path.join(jsDir, file);
        const originalContent = fs.readFileSync(filePath, 'utf8');
        const origSize = Buffer.byteLength(originalContent, 'utf8');
        totalJsOriginal += origSize;

        try {
            const minified = await minify(originalContent, {
                compress: {
                    dead_code: true
                },
                mangle: false,
                format: {
                    comments: /^!/
                }
            });

            if (minified.code) {
                fs.writeFileSync(filePath, minified.code, 'utf8');
                const minSize = Buffer.byteLength(minified.code, 'utf8');
                totalJsMinified += minSize;
                const savings = origSize > 0 ? ((origSize - minSize) / origSize * 100).toFixed(1) : 0;
                console.log(`  ✓ ${file}: ${(origSize/1024).toFixed(1)} KB -> ${(minSize/1024).toFixed(1)} KB (${savings}% saved)`);
            } else {
                totalJsMinified += origSize;
            }
        } catch (err) {
            console.warn(`  ! Skipping ${file} (terser: ${err.message})`);
            totalJsMinified += origSize;
        }
    }

    // 3. Minify datatables JS if present
    const dtTableData = path.join(__dirname, 'datatables', 'table_data.js');
    if (fs.existsSync(dtTableData)) {
        const originalContent = fs.readFileSync(dtTableData, 'utf8');
        const origSize = Buffer.byteLength(originalContent, 'utf8');
        try {
            const minified = await minify(originalContent, { compress: true, mangle: false });
            if (minified.code) {
                fs.writeFileSync(dtTableData, minified.code, 'utf8');
                console.log(`  ✓ datatables/table_data.js minified`);
            }
        } catch (e) {}
    }

    console.log('\n=== Minification Summary ===');
    console.log(`CSS: ${(totalCssOriginal/1024).toFixed(1)} KB -> ${(totalCssMinified/1024).toFixed(1)} KB (${(((totalCssOriginal - totalCssMinified)/totalCssOriginal)*100).toFixed(1)}% saved)`);
    console.log(`JS:  ${(totalJsOriginal/1024).toFixed(1)} KB -> ${(totalJsMinified/1024).toFixed(1)} KB (${(((totalJsOriginal - totalJsMinified)/totalJsOriginal)*100).toFixed(1)}% saved)`);
    const totalOrig = totalCssOriginal + totalJsOriginal;
    const totalMin = totalCssMinified + totalJsMinified;
    console.log(`Total assets size: ${(totalOrig/1024).toFixed(1)} KB -> ${(totalMin/1024).toFixed(1)} KB (${(((totalOrig - totalMin)/totalOrig)*100).toFixed(1)}% saved)`);
}

minifyFiles().catch(console.error);
