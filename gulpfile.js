/*
 * GULP CONFIG
 *
 * Desciption:  Clean gulpfile for web development workflow containing
 *
*/


/* SETTINGS
/===================================================== */
// local domain used by browsersync
var browsersync_proxy = "localhost:8888/gloss";

// default asset paths
var assets = {
  css: ['assets/styles/bundle.scss'],
  css_watch: ['assets/styles/*.scss'],
  javascript: ['assets/scripts/*.js'],
  images: ['assets/images/*.*'],
  fonts: ['assets/fonts/*.*']
}

// vendors are loaded from gulp-vendors.json
var vendors = require('./gulp-vendors.json');


/* DEPENDENCIES
/===================================================== */
// general
var gulp = require('gulp');
var concat = require('gulp-concat');
var rename = require("gulp-rename");
var order = require("gulp-order");
var browserSync = require('browser-sync').create();
// css
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');
var rtlcss = require('gulp-rtlcss');
// cache busting
var rev = require('gulp-rev');
// js
var uglify = require('gulp-uglify');
// images
var imagemin = require('gulp-imagemin');
// error handling with notify & plumber
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
// watch
var watch = require('gulp-watch');
// delete
var del = require('del');
// babel
var babel = require('gulp-babel');
var browserify = require('gulp-browserify');

/* TASKS
/===================================================== */

/* CLEAN
/––––––––––––––––––––––––*/
// delete compiled files/folders (before running the build)
// css
gulp.task('clean:css', function() { return del(['style.css', 'dist/*.css', 'dist/rev-manifest.json'])});
gulp.task('clean:rtl', function() { return del(['style-rtl.css'])});
gulp.task('clean:cachebust', function() { return del(['dist/style-*.min.css'])});
gulp.task('clean:javascript', function() { return del(['dist/*.js'])});
gulp.task('clean:images', function() { return del(['dist/images'])});
gulp.task('clean:fonts', function() { return del(['dist/fonts'])});

/* BROWSERSYNC
/––––––––––––––––––––––––*/
// initialize Browser Sync
gulp.task('browsersync', function() {
  browserSync.init({
    proxy: browsersync_proxy,
    notify: false,
    open: false,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
});


/* CSS
/––––––––––––––––––––––––*/
gulp.task('css', gulp.series('clean:css', function() {

  return gulp
    .src(assets['css'].concat(vendors['css']))
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('style.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(cleanCSS())
    .pipe(rename('style.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
}));

// rtl
gulp.task('css-rtl', gulp.series('clean:rtl', function() {

  return gulp
    .src(assets['css'].concat(vendors['css']))
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('style.css'))
    .pipe(sass())
    .pipe(autoprefixer('last 2 version', { cascade: false }))
    .pipe(rtlcss())
    .pipe(cleanCSS())
    .pipe(rename('style-rtl.css'))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream());
}));


/* CSS CACHE BUSTING
/––––––––––––––––––––––––*/
gulp.task('cachebust', gulp.series('clean:cachebust', 'css', function() {
  return gulp
    .src('style.css')
    .pipe(rev())
    .pipe(gulp.dest('dist'))
    .pipe(rev.manifest({merge: true}))
    .pipe(gulp.dest('dist'))
}));


/* JAVASCRIPT
/––––––––––––––––––––––––*/
// from:    assets/scripts/
// actions: concatinate, minify, rename
// to:      dist/script.min.css
// gulp.task('javascript', gulp.series('clean:javascript', function() {
//   return gulp
//     .src(assets['javascript'].concat(vendors['javascript']))
//     .pipe(order([
//       'assets/scripts/*.js'
//     ], { base: './' }))
//     .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
//     .pipe(concat('script.min.js'))
//     .pipe(uglify())
//     .pipe(rename('dist/script.min.js'))
//     .pipe(gulp.dest('./'))
//     .pipe(browserSync.stream());
// }));

gulp.task('javascript', gulp.series('clean:javascript', function() {
  return gulp.src(
    assets['javascript'],
    [
    'node_modules/babel-polyfill/dist/polyfill.js'
    ])
    .pipe(order([
      'assets/scripts/*.js'
    ], { base: './' }))
    .pipe(babel({
      presets: ['@babel/preset-env']
    }))
    .pipe(plumber({errorHandler: notify.onError("<%= error.message %>")}))
    .pipe(concat('functions.js'))
    .pipe(browserify())
    .pipe(uglify())
    .pipe(rename('dist/functions.js'))
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Javascript task complete...'}))
    .pipe(browserSync.stream());
}));

/* IMAGES
/––––––––––––––––––––––––*/
gulp.task('images', gulp.series('clean:images', function() {
  return gulp
    .src(assets['images'].concat(vendors['images']))
    .pipe(imagemin())
    .pipe(gulp.dest('dist/images'))
}));


/* FONTS
/––––––––––––––––––––––––*/
gulp.task('fonts', gulp.series('clean:fonts', function() {
  return gulp
    .src(assets['fonts'])
    .pipe(gulp.dest('dist/fonts'))
}));


/* WATCH
/––––––––––––––––––––––––*/
gulp.task('watch', gulp.parallel('browsersync', function() {
  watch(assets['css_watch'], gulp.series('css', 'cachebust'));
  watch(assets['javascript'], gulp.series('javascript'));
  watch(assets['images'], gulp.series('images'));
  watch(assets['fonts'], gulp.series('fonts'));
  watch('*.php', browserSync.reload);
  watch('template-parts/*.php', browserSync.reload);
  watch('inc/*.php', browserSync.reload);
}));



/* DEFAULT
/––––––––––––––––––––––––*/
// default gulp tasks executed with `gulp`
gulp.task('default', gulp.series('css', 'css-rtl', 'cachebust', 'javascript', 'images', 'fonts'));
