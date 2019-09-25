const path = require('path');
//const webpack = require('webpack');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

module.exports = (env, argv) => ({
    entry: {
        'layout/layout': './templates/layout/layout.js',
        'layout/datatables': './templates/layout/datatables.js',
        'home/home': './templates/home/home.js',
        'user/user-list': './templates/user/user-list.js',
    },

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

    module: {
        rules: [
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
            {
                test: /\.(png|jpg|gif|svg)$/,
                exclude: path.resolve(__dirname, './node_modules/@fortawesome/fontawesome-free/webfonts'),
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'images/'
                        }
                    }
                ]
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
