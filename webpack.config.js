const path = require('path');
const webpack = require('webpack');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

module.exports = {
    entry: {
        'layout/layout': './templates/layout/layout.js',
        'layout/datatables': './templates/layout/datatables.js',
        'home/home-index': './templates/home/home-index.js',
        'user/user-index': './templates/user/user-index.js',
    },
    output: {
        path: path.resolve(__dirname, 'public/assets'),
    },
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
            }
        ],
    },
    plugins: [
        new CleanWebpackPlugin(),
        new ManifestPlugin(),
        new MiniCssExtractPlugin({
            ignoreOrder: false
        }),
        new CopyPlugin([
            // Fontawesome
            {from: './node_modules/@fortawesome/fontawesome-free/webfonts/', to: 'webfonts/'},
        ]),
    ],
    watchOptions: {
        ignored: ['./node_modules/']
    },
    mode: "development"
};
