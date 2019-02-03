/* eslint-disable */

const webpack = require('webpack');
const ExtractPlugin = require('extract-text-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const CleanPlugin = require('webpack-cleanup-plugin');
const ChunkHashPlugin = require('webpack-chunk-hash');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
// const { VueLoaderPlugin } = require('vue-loader');

const path = require('path');
const dotenv = require('dotenv').config();

const library = require('./assets/library');
const env_configs = require('./config/env_configs');

module.exports = (env = process.env.APP_ENV) => {
    const configs = new env_configs.get(env);

    let toExport = {
        mode: configs.mode,
        context: __dirname + '/assets',
        entry: {
            common: './modules/common/common',
            homepage: './modules/homepage/homepage',
            portal: './modules/portal/portal',
            backoffice: './modules/backoffice/backoffice'
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
                    test: /\.vue$/,
                    loader: 'vue-loader'
                },
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
                    test: /\.(js|vue)$/,
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
                    use: ExtractPlugin.extract({
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
                        name: '[1]',
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
            new CleanPlugin({
                exclude: ['mdi/**/*'],
            }),
            new ManifestPlugin({
                fileName: '../manifest.json',
                publicPath: 'web/',
                filter: (file) => {
                    if (library.file.hasExt(file.name, ['css', 'js'])) {
                        return file;
                    }
                },
                map: (file) => {
                    const ext = library.file.getExt(file.name);
                    file.name = 'web/' + ext + '/' + file.name;
                    return file;
                }
            }),
            new StyleLintPlugin({
                files: '/styles',
                failOnError: false
            }),
            new ExtractPlugin('css/[name].[chunkhash].css'),
            new webpack.ProvidePlugin({
                APP_PREFIX: process.env.APP_PREFIX
            }),
            new VueLoaderPlugin()
        ],
        resolve: {
            modules: [path.resolve(__dirname, 'assets'), 'node_modules'],
            extensions: ['.ts', '.js', '.vue', '.json', '.scss'],
            mainFiles: ['index', 'main', 'base'],
            alias: {
                vue$: 'vue/dist/vue.esm.js'
            }
        },
        resolveLoader: {
            modules: ['node_modules'],
            extensions: ['.js', '.json'],
            mainFields: ['loader', 'main'],
            moduleExtensions: ['-loader', '*']
        },
        optimization: {
            splitChunks: {
                chunks: 'all',
                name: 'chunks'
            }
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
    };

    if (configs.uglify_js) {
        toExport.optimization.minimizer = [new UglifyJsPlugin({
            sourceMap: true
        })];
    }

    return toExport;
};
