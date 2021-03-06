(function () {
    'use strict';

    var baseDir = "app",
        distBaseDir = "./dist";

    module.exports = {
        path: {
            baseDir: baseDir,
            cssDir: baseDir +"/css/*.css",
            jsDir: baseDir +"/js/*.js",
            imgDir: baseDir + "/images/**/*",
            htmlDir: baseDir +"/*.html",
            distDir: distBaseDir,
            distCssDir: distBaseDir +"/css/",
            distJsDir: distBaseDir +"/js/",
            distDelDir: [distBaseDir +"/**", "!"+ distBaseDir],

        }

    };
})();
