var gulp         = require('gulp');
var sass         = require('gulp-sass');
var shell        = require('gulp-shell');
var browserSync  = require('browser-sync');
var minifyCSS    = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('server', shell.task([
  'php -S 0.0.0.0:5703'
]));

gulp.task('browser-sync', function() {
  browserSync({
    proxy: "localhost:5703",
    notify: false
  });
});

gulp.task('sass', function () {
  gulp.src('./assets/scss/**/*.scss')
    .pipe(sass({
      errLogToConsole: true
    }))
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(gulp.dest('./assets/css'))
    .pipe(browserSync.reload({stream:true}));
});

gulp.task('reload', function () {
  browserSync.reload();
});

gulp.task('watch', function() {
  gulp.watch('./assets/scss/**/*.scss', ['sass']);
  gulp.watch("./*.php", ['reload']);
  gulp.watch("./assets/js/*.js", ['reload']);
});

gulp.task('default', ['server', 'browser-sync', 'sass', 'watch'], function() {});
