/*
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemap = require('gulp-sourcemaps'),
    postcss = require('gulp-postcss'),
    concat = require('gulp-concat'),
    flatten = require('gulp-flatten'),
    rename = require('gulp-rename'),
    uglify = require('gulp-uglify'),
    gutil = require('gulp-util'),
    jshint = require('gulp-jshint'),
    cssnano = require('gulp-cssnano');

var bowerBase = 'resources/bower/';

var paths = {
    styles: [
        'resources/sass/**/*.scss'
    ],
    scripts: [
        bowerBase + 'jquery/dist/jquery.js',
        bowerBase + 'bootstrap/dist/js/bootstrap.js',/*
        bowerBase + 'datatables/media/js/jquery.dataTables.js',
        bowerBase + 'datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js',
        */
        bowerBase + 'jquery-slimscroll/jquery.slimscroll.js',
        bowerBase + 'fastclick/lib/fastclick.js',
        bowerBase + 'iCheck/icheck.js',
        bowerBase + 'simplemde/dist/simplemde.min.js',
        bowerBase + 'select2/dist/js/select2.full.js',
        /*
        bowerBase + '',
        */
        bowerBase + 'admin-lte.scss/javascripts/app.js',
        'resources/scripts/*.js'
    ],
    scriptsCustom: [
        'resources/scripts/*.js'
    ]
};

gulp.task('styles:sass', function() {
  return gulp.src( paths.styles)
      .pipe(sourcemap.init())
      .pipe(sass({
          outputStyle: 'nested', // libsass doesn't support expanded yet
          precision: 10,
          includePaths: ['.'],
          onError: console.error.bind(console, 'Sass error:')
      })).on('error', errorHandler)
      .pipe(postcss([
          require('autoprefixer-core')({browsers: ['last 1 version']})
      ]))
      .pipe(cssnano())
      .pipe(sourcemap.write('.'))
      .pipe(gulp.dest('public/styles'));
});

gulp.task('scripts:hint', function() {
    return gulp.src(paths.scriptsCustom)
        .pipe(jshint('.jshintrc'))
        .pipe(jshint.reporter('jshint-stylish'));
});

gulp.task('scripts:concat', ['scripts:hint'], function() {
  return gulp.src(paths.scripts)
      .pipe(concat('crud.js')).on('error', errorHandler)
      .pipe(gulp.dest('public/scripts'));
});

gulp.task('scripts:uglify', ['scripts:concat'], function() {
    return gulp.src('public/scripts/crud.js')
        .pipe(rename({ extname: '.min.js' }))
        .pipe(uglify())
        .pipe(gulp.dest('public/scripts'));
});

gulp.task('fonts:copy', function() {
  return gulp.src(bowerBase + '/**/{fonts,font}/*.{ttf,woff,woff2,eof,svg}')
      .pipe(flatten())
      .pipe(gulp.dest('public/fonts'));
});

gulp.task('images:copy', function () {
  return gulp.src(bowerBase + '/**/*.{jpg,png}')
      .pipe(flatten())
      .pipe(gulp.dest('public/images'));
});


gulp.task('default', ['scripts:uglify', 'styles:sass', 'fonts:copy','images:copy'], function () {
    // place code for your default task here
});

function errorHandler(err) {
    var displayErr = gutil.colors.red(err);
    gutil.log(displayErr);
    gutil.beep();
    this.emit('end');
}
