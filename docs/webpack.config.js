const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { WebpackManifestPlugin}  = require('webpack-manifest-plugin');
const isProduction = process.env.NODE_ENV === 'production';
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
    mode: isProduction ? 'production' : 'development',
    entry: {
        docs: path.resolve(__dirname, './assets/index.js'),
    },
    output: {
        path: path.resolve(__dirname, './dist/'),
        filename: isProduction ? '[name].[hash].js' : '[name].js',
        chunkFilename: isProduction ? '[id].[hash].js' : '[id].js',
    },
    module: {
        rules: [
            {
                test: /\.(png|jpg|gif|svg)$/i,
                type: 'asset/inline'
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'postcss-loader',
                ]
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: isProduction ? '[name].[hash].css' : '[name].css'
        }),
        new WebpackManifestPlugin({
            fileName: '../_data/manifest.yml',
            publicPath: '/dist/',
        }),
    ],
};
