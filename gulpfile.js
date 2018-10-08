var gulp = require('gulp'),
    less = require('gulp-less'),
    minify = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    del = require('del'),
    modifyCssUrls = require('gulp-modify-css-urls'),
    streamqueue = require('streamqueue'),
    file = require('gulp-file'),
    merge = require('merge-stream');

var paths = {
    'dev': './node_modules/',
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
        paths.dev + 'jquery-ui-dist/jquery-ui.js',
        paths.dev + 'nette.ajax.js/nette.ajax.js',
        paths.dev + 'nette.ajax.js/extensions/confirm.ajax.js',
        paths.dev + 'jquery-ui-touch-punch/jquery.ui.touch-punch.js',
        paths.dev + 'live-form-validation/live-form-validation.js',
        paths.dev + 'nattreid-utils/assets/utils.js',
        paths.dev + 'history.nette.ajax.js/client-side/history.ajax.js',
        paths.dev + 'nattreid-cookie-policy/assets/cookiePolicy.js',
        paths.dev + 'lightbox2/dist/js/lightbox.js'
    ])
        .pipe(concat('front.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(paths.production.js));
});

gulp.task('jsFrontLocale', function () {
    var streams = [];
    for (var lang in locale) {
        var stream = gulp.src(locale[lang])
            .pipe(concat('front.' + lang + '.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest(paths.production.lang));
        streams.push(stream);
    }
    return merge.apply(this, streams);
});

// *****************************************************************************
// ************************************  CSS  **********************************

gulp.task('cssFront', function () {
    return streamqueue({objectMode: true},
        gulp.src(paths.dev + 'font-awesome/css/font-awesome.css')
            .pipe(modifyCssUrls({
                modify: function (url, filePath) {
                    return url.replace('../fonts/', '/fonts/font-awesome/');
                }
            })),
        gulp.src(paths.dev + 'lightbox2/dist/css/lightbox.css')
            .pipe(modifyCssUrls({
                modify: function (url, filePath) {
                    return url.replace('../images/', '/images/lightbox/');
                }
            })),
        gulp.src([
            paths.dev + 'jquery-ui-dist/jquery-ui.theme.css',
            paths.dev + 'nattreid-cookie-policy/assets/cookiePolicy.min.css'
        ]))
        .pipe(concat('front.min.css'))
        .pipe(minify({keepSpecialComments: 0}))
        .pipe(gulp.dest(paths.production.css));
});

// *****************************************************************************
// **********************************  Fonts  **********************************

gulp.task('fonts', function () {
    var streams = [];
    streams.push(gulp.src(paths.dev + 'font-awesome/fonts/*')
        .pipe(gulp.dest(paths.production.fonts + 'font-awesome')));
    streams.push(gulp.src(paths.dev + 'bootstrap/fonts/*')
        .pipe(gulp.dest(paths.production.fonts + 'bootstrap')));
    return merge.apply(this, streams);
});

// *****************************************************************************
// *********************************  Images  **********************************

gulp.task('images', function () {
    var streams = [];
    streams.push(gulp.src(paths.dev + 'nattreid-file-manager/assets/images/icons.png')
        .pipe(gulp.dest(paths.production.images + 'fileManager')));
    streams.push(gulp.src(paths.dev + 'jquery-ui/themes/smoothness/images/*.png')
        .pipe(gulp.dest(paths.production.images + 'cms/jquery-ui')));
    streams.push(gulp.src(paths.dev + 'lightbox2/dist/images/*.*')
        .pipe(gulp.dest(paths.production.images + 'lightbox')));
    return merge.apply(this, streams);
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
    return gulp.src([
        paths.dev + 'ckeditor-full/**/*',
        '!' + paths.dev + 'ckeditor-full/config.js'
    ])
        .pipe(gulp.dest(paths.production.ckeditor));
});

// *****************************************************************************
// ********************************  KC Finder  ********************************

gulp.task('kcfinder', function () {
    return gulp.src([
        paths.dev + 'kcfinder/**/*',
        '!' + paths.dev + 'kcfinder/conf/config.php'
    ])
        .pipe(gulp.dest(paths.production.kcfinder));
});

// *****************************************************************************
// *******************************  Maintenance  *******************************

gulp.task('on', function (cb) {
    return del(paths.production.temp + 'maintenance', cb);
});

gulp.task('off', function (cb) {
    return file('maintenance', '', {src: true})
        .pipe(gulp.dest(paths.production.temp));
});

// *****************************************************************************
// **********************************  Clean  **********************************

gulp.task('cache', function (cb) {
    return del(paths.production.cache, cb);
});

gulp.task('clean', function (cb) {
    return del([
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

gulp.task('default', gulp.series('cache', 'jsFront', 'jsFrontLocale', 'cssFront', 'fonts', 'images', 'tracking', 'ckeditor', 'kcfinder'));

