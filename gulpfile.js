"use strict";

var gulp = require('gulp'),
    util = require('gulp-util'),
    jshint = require('gulp-jshint'),
    jsonlint = require('gulp-jsonlint'),
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

gulp.task('zip', ['clean', 'jslint', 'jsonlint'], function(){
   return gulp.src(path.src+'**')
            .pipe(zip(zipFileName))
            .pipe(gulp.dest(path.dist))
});

gulp.task('build', ['zip'], function(){
    util.log(util.colors.green('Successfull build: '), util.colors.cyan(path.dist+zipFileName));
});

gulp.task('default', ["build"]);