const gulp = require('gulp'),
      sass = require('gulp-sass'),
      autoprefixer = require('gulp-autoprefixer'),
      csso = require('gulp-csso');

gulp.task('default', ['sass', 'css', 'js']);

gulp.task('sass', () => {
    return gulp.src('./resources/sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(csso())
        .pipe(gulp.dest('./web/'));
});

gulp.task('sass:watch', () => {
    gulp.watch('./resources/sass/**/*.scss', ['sass']);
});

gulp.task('css', () => {
    return gulp.src([
        './node_modules/highlightjs/styles/mono-blue.css'
    ])
        .pipe(csso())
        .pipe(gulp.dest('./web/'));
});

gulp.task('js', () => {
    return gulp.src([
        './node_modules/timeago.js/dist/timeago.min.js',
        './node_modules/timeago.js/dist/timeago.locales.min.js',
        './node_modules/highlightjs/highlight.pack.min.js'
    ])
        .pipe(gulp.dest('./web/'));
});
