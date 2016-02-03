"use strict";

var gulp = require('gulp'),
    gutil = require('gulp-util'),
    jshint = require('gulp-jshint'),
    jsonlint = require('gulp-jsonlint'),
    csslint = require('gulp-csslint'),
    rimraf = require('gulp-rimraf'),
    zip = require('gulp-zip'),
    packageJSON  = require('./package');

var path = {
        src: './src/',
        dist: './dist/',
        clean: './dist/'
    },
    zipFileName = 'widget.zip';

gulp.task('clean', function(){
   return gulp.src(path.dist+'*.*', {read: false})
            .pipe(rimraf());
});

gulp.task('jslint', function(){
   return gulp.src(path.src+"**/*.js")
            .pipe(jshint(packageJSON.jshintConfig))
            .pipe(jshint.reporter('jshint-stylish'))
});

gulp.task('jsonlint', function(){
   return gulp.src(path.src+'**/*.json')
            .pipe(jsonlint())
            .pipe(jsonlint.failOnError())
            .pipe(jsonlint.reporter())
});

var cssLintReporter = function(file) {
  gutil.log(gutil.colors.red(file.csslint.errorCount+' errors in ')+gutil.colors.cyan(file.path));

  file.csslint.results.forEach(function(result) {
    gutil.log('line '+result.error.line+', col '+result.error.col+', Error - '+result.error.message);
  });
};

gulp.task('csslint', function(){
   return gulp.src(path.src+'**/*.css')
            .pipe(csslint())
            .pipe(csslint.reporter(cssLintReporter))
            .pipe(csslint.reporter('fail'))
});

gulp.task('zip', ['clean', 'jslint', 'jsonlint', 'csslint'], function(){
   return gulp.src(path.src+'**')
            .pipe(zip(zipFileName))
            .pipe(gulp.dest(path.dist))
});

gulp.task('build', ['zip'], function(){
    gutil.log(gutil.colors.green('Successfull build: '), gutil.colors.cyan(path.dist+zipFileName));
});

gulp.task('default', ["build"]);