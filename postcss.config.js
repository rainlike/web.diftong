module.exports = {
    parser: 'sugarss',
    plugins: {
        'postcss-import': {},
        'postcss-cssnext': {},
        'cssnano': {},
        'stylelint': {}
    }
};


module.exports = {
    plugins: [
        require('precss'),
        require('autoprefixer')
    ]
};
