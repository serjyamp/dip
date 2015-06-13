"use strict";

var gulp = require('gulp'),
	connect = require('gulp-connect'),
	opn = require('opn'),
	sass = require('gulp-sass'),
	minifyCSS = require('gulp-minify-css'),
	rename = require('gulp-rename'),
	concat = require('gulp-concat');

gulp.task('connect', function() {
  connect.server({
    root: 'app',
    livereload: true
  });
  opn('http://localhost:8080/');
});

gulp.task('css', function(){
	gulp.src('app/assets/scss/*.scss')
		.pipe(sass())
		.pipe(concat('app.css'))
		.pipe(minifyCSS(''))
		.pipe(rename('app.min.css'))
		.pipe(gulp.dest('app'))
		.pipe(connect.reload());
});

gulp.task('html', function(){
	gulp.src('app/*.html')
		.pipe(connect.reload());
});

gulp.task('watch', function(){
	gulp.watch(['app/*.html'], ['html']);
	gulp.watch(['app/assets/scss/*.scss'], ['css']);
});

gulp.task('default', ['connect', 'watch']);