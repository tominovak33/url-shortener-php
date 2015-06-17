/**
 * Created by tomi on 14/06/15.
 */

var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');

gulp.task('js', function() {
    gulp.src(['src/js/**/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('app.js'))
        .pipe(uglify())
        //.pipe(sourcemaps.write())
        .pipe(gulp.dest('assets'))
});

gulp.task('watch:js', ['js'], function () {
    gulp.watch('src/js/**/*.js', ['js'])
});

//Run gulp develop to watch js files
gulp.task('develop', ['watch:js'] ,  function () {
});