/* eslint-disable */

const webpack = require('webpack');
const extractPlugin = require('extract-text-webpack-plugin');
const uglifyJsPlugin = require('uglifyjs-webpack-plugin');
const manifestPlugin = require('webpack-manifest-plugin');
const cleanPlugin = require('webpack-cleanup-plugin');
const chunkHashPlugin = require('webpack-chunk-hash');

const path = require('path');
const dotenv = require('dotenv').config();

const library = require('./assets/library');
const env_configs = require('./config/env_configs');

module.exports = (env = process.env.APP_ENV) => {
    let configs = new env_configs.get(env);

    return {
        context: __dirname + '/assets',
        entry: {
            app: './app'
        },
        output: {
            path: __dirname + '/public/web',
            publicPath: '/web/',
            filename: 'js/[name].[chunkhash].js',
            library: configs.prefix + '_[name]',
        },
        target: 'web',
        node: {
            fs: 'empty'
        },
        module:{
            rules: [
                {
                    test: /\.ts$/,
                    enforce: 'pre',
                    loader: 'tslint',
                    options: {
                        failOnHint: true,
                        fix: false,
                        formatter: 'codeFrame',
                    }
                },
                {
                    test: /\.ts$/,
                    exclude: /node_modules/,
                    use: [
                        {
                            loader: 'babel',
                            options: {
                                presets: ['@babel/preset-env'],
                                plugins: ['@babel/transform-runtime']
                            }
                        },
                        { loader: 'ts' }
                    ]
                },
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    enforce: 'pre',
                    loader: 'eslint',
                    options: {
                        outputReport: {
                            filePath: '../../var/log/eslint.log',
                            formatter: require('eslint/lib/formatters/codeframe')
                        }
                    }
                },
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: [
                        {
                            loader: 'babel',
                            options: {
                                presets: ['@babel/preset-env'],
                                plugins: ['@babel/transform-runtime']
                            }
                        }
                    ]
                },
                {
                    test: /\.scss$/,
                    exclude: /node_modules/,
                    use: extractPlugin.extract({
                        use: [
                            {
                                loader: 'css',
                                options: {
                                    importLoaders: 1,
                                    minimize: true
                                }
                            },
                            { loader: 'postcss' },
                            { loader: 'resolve-url' },
                            {
                                loader: 'sass',
                                options: {
                                    data: "$APP_PREFIX: " + JSON.stringify(process.env.APP_PREFIX) + ";"
                                }
                            }
                        ]
                    })
                },
                {
                    test: /\.(jpe?g|png|gif|svg|eot|woff|ttf|woff2)$/,
                    include: /node_modules/,
                    loader: 'file',
                    options: {
                        name: '[1].[ext]',
                        regExp: /node_modules\/(.*)$/
                    }
                },
                {
                    test: /\.(jpe?g|png|gif|svg|eot|woff|ttf|woff2)$/,
                    exclude: /node_modules/,
                    loader: 'file',
                    options: {
                        name: '[path][name].[ext]'
                    }
                }
            ]
        },
        plugins: [
            new webpack.DefinePlugin({
                'APP_PREFIX': JSON.stringify(process.env.APP_PREFIX),
                'APP_ENV': JSON.stringify(process.env.APP_ENV)
            }),
            new cleanPlugin({
                exclude: ['mdi/**/*'],
            }),
            new uglifyJsPlugin({
                sourceMap: true
            }),
            new manifestPlugin({
                fileName: '../manifest.json',
                publicPath: 'web/',
                filter: (file) => {
                    if (library.file.hasExt(file.name, ['css', 'js'])) {
                        return file;
                    }
                },
                map: (file) => {
                    let ext = library.file.getExt(file.name);

                    file.name = 'web/' + ext + '/' + file.name;

                    return file;
                }
            }),
            new extractPlugin('css/[name].[chunkhash].css'),
            new webpack.ProvidePlugin({
                APP_PREFIX: process.env.APP_PREFIX
            })
        ],
        resolve: {
            modules: [path.resolve(__dirname, 'assets'), 'node_modules'],
            extensions: ['.ts', '.js', '.json', '.scss'],
            mainFiles: ['index']
        },
        resolveLoader: {
            modules: ['node_modules'],
            extensions: ['.js', '.json'],
            mainFields: ['loader', 'main'],
            moduleExtensions: ['-loader', '*']
        },
        devtool: configs.source_maps,
        watchOptions: {
            aggregateTimeout: 100,
            poll: 1000
        },
        devServer: {
            host: 'localhost',
            port: 8080,
            inline: true
        }
    }
};
