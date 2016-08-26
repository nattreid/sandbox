var gulp = require('gulp'),
        less = require('gulp-less'),
        minify = require('gulp-clean-css'),
        concat = require('gulp-concat'),
        uglify = require('gulp-uglify'),
        rename = require('gulp-rename'),
        del = require('del');

var paths = {
    'dev': './bower_components/',
    'production': {
        'js': './www/js/',
        'css': './www/css/',
        'lang': './www/js/i18n/',
        'fonts': './www/fonts/',
        'images': './www/images/',
        'ckeditor': './www/ckeditor/',
        'kcfinder': './www/kcfinder/'
    }
};

// *****************************************************************************
// ************************************  JS  ***********************************

gulp.task('jsFront', function () {
    return gulp.src([
        paths.dev + 'jquery/dist/jquery.js',
        paths.dev + 'jquery-ui/jquery-ui.js',
        paths.dev + 'nette-forms/src/assets/netteForms.js',
        paths.dev + 'nette.ajax.js/nette.ajax.js',
        paths.dev + 'nette.ajax.js/extensions/confirm.ajax.js',
        paths.dev + 'jquery-ui-touch-punch/jquery.ui.touch-punch.js',
        paths.dev + 'nette-live-form-validation/live-form-validation.js',
        paths.dev + 'utils/assets/utils.js',
        paths.dev + 'history.nette.ajax.js/client-side/history.ajax.js'
    ])
            .pipe(concat('front.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest(paths.production.js));
});

gulp.task('jsFrontCs', function () {
    return gulp.src([
        paths.dev + 'jquery-ui/ui/i18n/datepicker-cs.js'
    ])
            .pipe(concat('frontCs.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest(paths.production.lang));
});

gulp.task('cssFront', function () {
    return gulp.src([
        paths.dev + 'jquery-ui/themes/base/jquery-ui.css',
        paths.dev + 'cookiepolicy/assets/cookiePolicy.less'
    ])
            .pipe(less())
            .pipe(concat('front.min.css'))
            .pipe(minify({keepSpecialComments: 0}))
            .pipe(gulp.dest(paths.production.css));
});

gulp.task('fonts', function () {
    return gulp.src([
        paths.dev + 'font-awesome/fonts/*',
        paths.dev + 'bootstrap/fonts/*'
    ])
            .pipe(gulp.dest(paths.production.fonts));
});

gulp.task('images', function () {
    return gulp.src([
        paths.dev + 'filemanager/client-side/images/fileIcons.png'
    ])
            .pipe(gulp.dest(paths.production.images));
});

gulp.task('tracking', function () {
    return gulp.src([
        paths.dev + 'tracking/assets/nTracker.min.js'
    ])
            .pipe(gulp.dest(paths.production.js));
});

gulp.task('ckeditor', function () {
    gulp.src([
        paths.dev + 'ckeditor/**/*',
        '!' + paths.dev + 'ckeditor/config.js'
    ])
            .pipe(gulp.dest(paths.production.ckeditor));
});

gulp.task('kcfinder', function () {
    gulp.src([
        paths.dev + 'kcfinder/**/*',
        '!' + paths.dev + 'kcfinder/conf/config.php'
    ])
            .pipe(gulp.dest(paths.production.kcfinder));
});

gulp.task('clean', function (cb) {
    del([
        paths.production.js,
        paths.production.css,
        paths.production.lang,
        paths.production.fonts,
        paths.production.images,
        paths.production.ckeditor + '**/*',
        '!' + paths.production.ckeditor + 'config.js',
        paths.production.kcfinder + '**/*',
        '!' + paths.production.kcfinder + '/conf',
        '!' + paths.production.kcfinder + '/conf/config.php'
    ], cb);
});

gulp.task('default', ['jsFront', 'jsFrontCs', 'cssFront', 'fonts', 'images', 'tracking', 'ckeditor', 'kcfinder']);
