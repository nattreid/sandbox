var gulp = require('gulp'),
    less = require('gulp-less'),
    minify = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    del = require('del'),
    modifyCssUrls = require('gulp-modify-css-urls'),
    streamqueue = require('streamqueue'),
    file = require('gulp-file');

var paths = {
    'dev': './bower_components/',
    'production': {
        'js': './www/js/',
        'css': './www/css/',
        'lang': './www/js/i18n/',
        'fonts': './www/fonts/',
        'images': './www/images/',
        'ckeditor': './www/ckeditor/',
        'kcfinder': './www/kcfinder/',
        'cache': ['./temp/cache/', './www/webtemp/**.*', '!./www/webtemp/.htaccess'],
        'temp': './temp/'
    }
};

// *****************************************************************************
// ************************************  JS  ***********************************

var locale = {
    'cs': [
        paths.dev + 'jquery-ui/ui/i18n/datepicker-cs.js'
    ],
    'en': [
        paths.dev + 'jquery-ui/ui/i18n/datepicker-en-GB.js'
    ]
};

gulp.task('jsFront', function () {
    return gulp.src([
        paths.dev + 'jquery/dist/jquery.js',
        paths.dev + 'jquery-ui/jquery-ui.js',
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

gulp.task('jsFrontLocale', function () {
    for (var lang in locale) gulp.src(locale[lang])
        .pipe(concat('front.' + lang + '.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(paths.production.lang));
});

// *****************************************************************************
// ************************************  CSS  **********************************

gulp.task('cssFront', function () {
    return gulp.src([
        paths.dev + 'jquery-ui/themes/base/jquery-ui.css',
        paths.dev + 'nattreid-cookie-policy/assets/cookiePolicy.less'
    ])
        .pipe(less())
        .pipe(concat('front.min.css'))
        .pipe(minify({keepSpecialComments: 0}))
        .pipe(gulp.dest(paths.production.css));
});

// *****************************************************************************
// **********************************  Fonts  **********************************

gulp.task('fonts', function () {
    gulp.src(paths.dev + 'font-awesome/fonts/*')
        .pipe(gulp.dest(paths.production.fonts + 'font-awesome'));
    gulp.src(paths.dev + 'bootstrap/fonts/*')
        .pipe(gulp.dest(paths.production.fonts + 'bootstrap'));
});

// *****************************************************************************
// *********************************  Images  **********************************

gulp.task('images', function () {
    gulp.src(paths.dev + 'nattreid-file-manager/assets/images/icons.png')
        .pipe(gulp.dest(paths.production.images + 'fileManager'));
    gulp.src(paths.dev + 'jquery-ui/themes/smoothness/images/*.png')
        .pipe(gulp.dest(paths.production.images + 'cms/jquery-ui'));
});

// *****************************************************************************
// ********************************  Tracking  *********************************

gulp.task('tracking', function () {
    return gulp.src([
        paths.dev + 'nattreid-tracking/assets/nTracker.min.js'
    ])
        .pipe(gulp.dest(paths.production.js));
});

// *****************************************************************************
// ********************************  CK Editor  ********************************

gulp.task('ckeditor', function () {
    gulp.src([
        paths.dev + 'ckeditor/**/*',
        '!' + paths.dev + 'ckeditor/config.js'
    ])
        .pipe(gulp.dest(paths.production.ckeditor));
});

// *****************************************************************************
// ********************************  KC Finder  ********************************

gulp.task('kcfinder', function () {
    gulp.src([
        paths.dev + 'attreid-kcfinder/**/*',
        '!' + paths.dev + 'attreid-kcfinder/conf/config.php'
    ])
        .pipe(gulp.dest(paths.production.kcfinder));
});

// *****************************************************************************
// *******************************  Maintenance  *******************************

gulp.task('on', function (cb) {
    del(paths.production.temp + 'maintenance', cb);
});

gulp.task('off', function (cb) {
    return file('maintenance', '', {src: true})
        .pipe(gulp.dest(paths.production.temp));
});

// *****************************************************************************
// **********************************  Clean  **********************************

gulp.task('cache', function (cb) {
    del(paths.production.cache, cb);
});

gulp.task('clean', function (cb) {
    del([
        paths.production.js,
        paths.production.css,
        paths.production.lang,
        paths.production.fonts,
        paths.production.images + '**/*',
        '!' + paths.production.images + '/front',
        '!' + paths.production.images + '/front/**/*',
        paths.production.ckeditor + '**/*',
        '!' + paths.production.ckeditor + 'config.js',
        paths.production.kcfinder + '**/*',
        '!' + paths.production.kcfinder + '/conf',
        '!' + paths.production.kcfinder + '/conf/config.php'
    ], cb);
});

// *****************************************************************************

gulp.task('default', ['cache', 'jsFront', 'jsFrontLocale', 'cssFront', 'fonts', 'images', 'tracking', 'ckeditor', 'kcfinder']);

