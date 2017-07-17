"use strict";

var gulp = require('gulp'),
    gutil = require('gulp-util'),
    jshint = require('gulp-jshint'),
    jsonlint = require('gulp-jsonlint'),
    csslint = require('gulp-csslint'),
    zip = require('gulp-zip'),
    include = require('gulp-include'),
    autoprefixer = require('gulp-autoprefixer'),
    strip = require('gulp-strip-comments'),
    del = require('del'),
    pkg  = require('./package'),
    manifest  = require('./src/manifest'),
    jmodify = require("gulp-json-modify"),
    semver = require('semver');

var path = {
        src: './src/',
        dist: './dist/',
		publish: './publish/'
    },
    zipFileName = 'widget.zip';

gulp.task('clean', function(){
        return del([path.dist+'/**', path.publish+'/**'])
});

gulp.task('img', ['clean'], function(){
   return gulp.src(path.src+"images/**")
            .pipe(gulp.dest(path.dist+"images/"))
});

gulp.task('templates', ['clean'], function(){
   return gulp.src(path.src+"templates/**")
            .pipe(gulp.dest(path.dist+"templates/"))
});

gulp.task('jslint', ['clean'], function(){
   return gulp.src(path.src+"js/*.js")
            .pipe(jshint(pkg.jshintConfig))
            .pipe(jshint.reporter('jshint-stylish'))
});

gulp.task('js', ['jslint'], function(){
   return gulp.src(path.src+"js/script.js")
            .pipe(include())
                .on('error', console.log)
            .pipe(strip())
            .pipe(gulp.dest(path.dist))
});

gulp.task('i18n', ['clean'], function(){
   return gulp.src(path.src+'i18n/*.json')
            .pipe(jsonlint())
            .pipe(jsonlint.failOnError())
            .pipe(jsonlint.reporter())
            .pipe(gulp.dest(path.dist+'i18n/'))
});

gulp.task('css', ['clean'], function(){
   return gulp.src(path.src+'css/style.css')
            .pipe(csslint())
            .pipe(csslint.formatter("compact"))
            .pipe(autoprefixer())
            .pipe(gulp.dest(path.dist))
});

gulp.task('manifest', ['js', 'i18n', 'css', 'img', 'templates'], function(){
   return gulp.src(path.src+"manifest.json")
            .pipe(jsonlint())
            .pipe(jsonlint.failOnError())
            .pipe(jsonlint.reporter())
            .pipe(jmodify({
                key: 'widget.version', value: semver.inc(manifest.widget.version, 'patch', null)
            }))
            .pipe(gulp.dest(path.src))
            .pipe(gulp.dest(path.dist))
});

gulp.task('zip', ['manifest'], function(){
  return gulp.src(path.dist+'**/*.*')
            .pipe(zip(zipFileName))
            .pipe(gulp.dest(path.publish))
});

gulp.task('build', ['zip'], function(){
    gutil.log(gutil.colors.green('Successfull build: '), gutil.colors.cyan(path.publish+zipFileName));
});

gulp.task('default', ["build"]);