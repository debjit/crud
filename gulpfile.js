var gulp = require('gulp');

var bowerBase = 'resources/bower/startbootstrap-sb-admin-2-sass/dist';

gulp.task('styles:copy', function() {
  return gulp.src( bowerBase + '/css/*.css')
      .pipe(gulp.dest('public/styles'));
});

gulp.task('scripts:copy', function() {
  return gulp.src(bowerBase + '/js/*.js')
      .pipe(gulp.dest('public/scripts'));
});

gulp.task('fonts:copy', function() {
  return gulp.src(bowerBase + '/fonts/*')
      .pipe(gulp.dest('public/fonts'));
});

gulp.task('images:copy', function () {
  return gulp.src(bowerBase + '/images/*')
      .pipe(gulp.dest('public/images'));
});


gulp.task('default', ['styles:copy', 'scripts:copy', 'fonts:copy','images:copy'], function () {
    // place code for your default task here
});
