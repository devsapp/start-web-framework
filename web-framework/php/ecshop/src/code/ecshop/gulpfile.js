const gulp = require('gulp');
const del = require('del');
const plugins = require('gulp-load-plugins')();
const config = require('./config')();

plugins.stats(gulp);

// ------ process css
gulp.task(`clean-css`, cb => del([`${ config.css }**/*.css`]));

gulp.task(`scss`, cb => gulp.src([`${ config.scss }**/*.scss`])
  .pipe(plugins.plumber())
  .pipe(plugins.sass({
    outputStyle: 'expanded',
  }))
  .pipe(plugins.postcss())
  .pipe(gulp.dest(config.css))
);

gulp.task(`watch`, cb => gulp.watch([`${ config.scss }**/*.scss`], [`scss`]));

gulp.task(`dev`, cb => gulp.start(`watch`));
