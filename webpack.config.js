const WrapperPlugin = require('webpack-prepend-append-wrapper');
const path          = require( 'path' );

module.exports = (env, argv) => {
    const mode = argv.mode || 'development';

    // Define the output filename extension based on the mode
    const outputFilenameExtension = mode === 'production' ? '.min.js' : '.js';

    const entries = {
		admin : './assets/source/js/admin/index.js',
		public: './assets/source/js/public/index.js',
    };

    return {
        devtool: false,
        entry  : entries,
        output : {
            path    : path.resolve( __dirname, 'assets' ),
            filename: () => {
                return  '[name]/js/[name]' + outputFilenameExtension;
            }
        },
        module : {
            rules:[
                {
                    // Look for any .js files.
                    test   : /\.js$/,
                    // Exclude the node_modules folder.
                    exclude: /node_modules/,
                    include: path.resolve(__dirname, 'src'),
                    use    :  {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                        },
                    }
                }
            ]
        },
        plugins: [
            new WrapperPlugin({
                test: /\.js$/, // only wrap output of bundle files with '.js' extension
                header:'"use strict";\n var $ = jQuery.noConflict();\n'
            })
        ],
    }
};