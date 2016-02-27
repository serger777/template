var
    gulp        = require('gulp'),
    compass     = require('gulp-compass'),
    jade        = require('gulp-jade'),
    browserSync = require('browser-sync').create(),
    wiredep = require('wiredep').stream,
    useref = require("gulp-useref"),
    uglify = require("gulp-uglify"),
    minifyCss = require("gulp-minify-css"),
    gulpif = require("gulp-if"),
    del = require("del"),
    filter = require("gulp-filter"),
    imagemin = require("gulp-imagemin"),
    size = require("gulp-size"),
    gutil = require("gulp-util"),
    concatCss = require("gulp-concat-css"),
    RS_CONF = require('./rs-conf.js'),
    plumber     = require('gulp-plumber');

/* --------- paths --------- */

var
    paths = {
        jade : {
            location    : 'markups/**/*.jade',
            compiled    : 'markups/_pages/*.jade',
            destination : 'app/'
        },

        scss : {
            location    : 'styles/**/*.scss',
            entryPoint  : 'app/css/main.css'
        },

        compass : {
            configFile  : 'config.rb',
            cssFolder   : 'app/css',
            scssFolder  : 'styles',
            imgFolder   : 'app/images'
        },

        browserSync : {
            baseDir : 'app/',
            watchPaths : ['app/*.html', 'app/css/*.css', 'app/js/*.js', 'markups/*.jade']
        }
    };

/* --------- jade --------- */

gulp.task('jade', function() {
    gulp.src(paths.jade.compiled)
        .pipe(plumber())
        .pipe(jade({
            pretty: ' \t ',
        }))
        .pipe(gulp.dest(paths.jade.destination));
});

/* --------- scss-compass --------- */

gulp.task('compass', function() {
    gulp.src(paths.scss.location)
        .pipe(plumber())
        .pipe(compass({
            config_file: paths.compass.configFile,
            css: paths.compass.cssFolder,
            sass: paths.compass.scssFolder,
            image: paths.compass.imgFolder
        }));
});

/* --------- browser sync --------- */

gulp.task('sync', function() {
    browserSync.init({
        server: {
            baseDir: paths.browserSync.baseDir
        }
    });
});

/* --------- watch --------- */

gulp.task('watch', function(){
    gulp.watch(paths.jade.location, ['jade']);
    gulp.watch(paths.scss.location, ['compass']);

    gulp.watch(paths.browserSync.watchPaths).on('change', browserSync.reload);
});

/* --------- default --------- */

gulp.task('default', ['jade', 'compass', 'sync', 'watch']);

/*******************************************
 * DIST
 ******************************************/

gulp.task('jadeDist', function() {
    gulp.src(paths.jade.compiled)
        .pipe(plumber())
        .pipe(jade({
            pretty: '\t',
        }))
        .pipe(gulp.dest(paths.jade.destination));
});

//включаем bower файлы
gulp.task('bowerDist', function () {
    gulp.src(RS_CONF.path.htmlDir)
        .pipe(wiredep({
            derictory: RS_CONF.path.baseDir+"/bower",
            overrides: {
                "qtip2": {
                    "main": ["./jquery.qtip.min.js", "./jquery.qtip.min.css"],
                    "dependencies": {"jquery": ">=1.6.0"}
                }
                , exclude: ["bower/qtip2/"]
                , ignorePath: /^(\.\.\/)*\.\./
            }
        }))
        .pipe(gulp.dest(RS_CONF.path.baseDir));
});

gulp.task('watch-bower', function (){
    gulp.watch('bower.json',['bower']);
})

// Переносим CSS JS HTML в папку DIST

gulp.task('userefDist', function() {
    var assets = useref.assets();

    return gulp.src('app/index.html')
        .pipe(assets)
        .pipe(gulpif("*.js", uglify()))
        .pipe(gulpif("*.css", minifyCss()))
        .pipe(assets.restore())
        .pipe(useref())
        .pipe(gulp.dest("./dist/"));
});
gulp.task('compassDist', function() {
    gulp.src(paths.scss.location)
        .pipe(plumber())
        .pipe(compass({
            config_file: paths.compass.configFile,
            css: paths.compass.cssFolderDist,
            sass: paths.compass.scssFolder,
            image: paths.compass.imgFolder
        }));
});

gulp.task('syncDist', function() {
    browserSync.init({
        server: {
            baseDir: paths.browserSync.baseDirDist
        }
    });
});

gulp.task('watchDist', function(){
    gulp.watch(paths.browserSync.watchPaths).on('change', browserSync.reload);
});

gulp.task('php', function() {
    return gulp.src('app/*.php')
        .pipe(gulp.dest("./dist/"));
});
// Перенос картинок
gulp.task("images", function () {
    return gulp.src(RS_CONF.path.baseDir+"/images/**/*")
        .pipe(imagemin({
            progressive: true,
            interlaced: true
        }))
        .pipe(gulp.dest(RS_CONF.path.distDir+"/images"));
});

gulp.task('build', [  'userefDist','php', 'compassDist','images']);
gulp.task('build-sync', ['jadeDist', 'bowerDist', 'userefDist', 'compassDist','images', 'syncDist', 'watchDist']);