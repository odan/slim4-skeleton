const path = require('path');
//const webpack = require('webpack');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

module.exports = (env, argv) => ({
    entry: function loadEntries(pattern) {
        const glob = require('glob');
        const path = require('path');
        const object = {};

        glob.sync(pattern).forEach(function (match) {
            const ext = path.extname(match);

            const extensions = ['.js', '.ts', '.css'];
            if (!extensions.includes(ext)) {
                return;
            }

            const basename = path.basename(match, ext);
            const onlyPath = path.dirname(match);
            const key = onlyPath.replace('\.\/templates\/', '');

            object[key + '/' + basename] = match;
        });

        //console.log(object);

        return object;
    }('./templates/**'),

    /* entry: {
          'layout/layout': './templates/layout/layout',
          'layout/datatables': './templates/layout/datatables',
          'home/home': './templates/home/home',
          'user/user-list': './templates/user/user-list',
          'user/greeter': './templates/user/greeter',
      },*/

    output: {
        path: path.resolve(__dirname, 'public/assets'),
    },

    mode: 'development',

    //devtool: argv.mode === 'production' ? 'source-map' : '',

    optimization: {
        minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
    },

    performance: {
        maxEntrypointSize: 1024000,
        maxAssetSize: 1024000
    },

    resolve: {
        extensions: ['.js', '.ts', '.tsx']
    },

    module: {
        rules: [
            {
                test: /\.ts$/,
                use: 'ts-loader',
                exclude: /node_modules/
            },
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader']
            },
            {
                test: /\.(ttf|eot|svg|woff|woff2)(\?[\s\S]+)?$/,
                include: path.resolve(__dirname, './node_modules/@fortawesome/fontawesome-free/webfonts'),
                use: {
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'webfonts',
                        publicPath: '../webfonts',
                    },
                }
            },
        ],
    },

    plugins: [
        new CleanWebpackPlugin(),
        new ManifestPlugin(),
        new MiniCssExtractPlugin({
            ignoreOrder: false
        }),
    ],

    watchOptions: {
        ignored: ['./node_modules/']
    },

});
