/** @type {Gulp} */
const gulp = require('gulp');
/** @type {*|exports|module.exports} */
const plugins = require('gulp-load-plugins')();
const library = require('./assets/library');

plugins.sass.compiler = require('node-sass');

gulp.task('nucleus', () => {
    const srcFile = './assets/nucleus.scss';
    const distFile = 'nucleus.css';
    const distPath = './docs/nucleus/';

    return gulp.src(srcFile)
        .pipe(plugins.sassVariables({
            $APP_PREFIX: library.prefix ? library.prefix : 'app'
        }))
        .pipe(plugins.sass().on('error', plugins.sass.logError))
        .pipe(plugins.rename(distFile))
        .pipe(gulp.dest(distPath));
});
