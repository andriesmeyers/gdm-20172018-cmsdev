var gulp = require('gulp');
var livereload = require('gulp-livereload')
var uglify = require('gulp-uglifyjs');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');




gulp.task('imagemin', function () {
    return gulp.src('./themes/custom/grent/images/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('./themes/custom/grent/images'));
});


gulp.task('sass', function () {
  gulp.src('./themes/custom/grent/sass/**/*.scss')
    .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 7', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./themes/custom/grent/css'));
});


gulp.task('uglify', function() {
  gulp.src('./themes/custom/grent/lib/*.js')
    .pipe(uglify('main.js'))
    .pipe(gulp.dest('./themes/custom/grent/js'))
});

gulp.task('watch', function(){
    livereload.listen();

    gulp.watch('./themes/custom/grent/sass/**/*.scss', ['sass']);
    gulp.watch('./themes/custom/grent/lib/*.js', ['uglify']);
    gulp.watch(['./themes/custom/grent/css/style.css','./themes/custom/grent/css/style.map.css', './themes/custom/grent/**/*.twig', './themes/custom/grent/js/*.js'], function (files){
        livereload.changed(files)
    });
});