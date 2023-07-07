const oryx = require("@spryker/oryx");
const oryxForZed = require("@spryker/oryx-for-zed");
const path = require('path');
const merge = require('webpack-merge');
const mergeWithStrategy = merge.smartStrategy({
    plugins: 'prepend'
});

const myCustomZedSettings = mergeWithStrategy(oryxForZed.settings, {
    entry: {
        dirs: [path.resolve('./src/Pyz/Zed/')]
    }
});

oryxForZed.getConfiguration(myCustomZedSettings).then(configuration => oryx.build(configuration));
