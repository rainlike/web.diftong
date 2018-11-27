module.exports = {
    parser: 'sugarss',
    plugins: {
        'postcss-import': {},
        'postcss-cssnext': {},
        'cssnano': {
            comments: { removeAll: true }
        },
        'stylelint': {}
    }
};

module.exports = {
    plugins: [
        require('precss'),
        require('autoprefixer')
    ]
};
