/* Search for package 'gulp' in 'node-modules' directory. */
let gulp = require('gulp');
let babel = require('gulp-babel');
let sass = require('gulp-sass')(require('sass'));
let rename = require('gulp-rename');
let autoprefixer = require('gulp-autoprefixer');
let sourcemaps = require('gulp-sourcemaps');
let browserify = require('browserify');
let babelify = require('babelify');
let source = require('vinyl-source-stream');
let buffer = require('vinyl-buffer');
let uglify = require('gulp-uglify');
let plumber = require('gulp-plumber');
let browserSync = require('browser-sync').create();   // Initialize browserSync immediately.
let reload = browserSync.reload;


/* Variables for Gulp tasks */
// 1. CSS (SCSS)
let styleSrcFile = 'source/scss/devsunshine-admin.scss';
let stylesSrcDir = 'source/scss/';
let stylesDistDir = './assets/css/';  // where CSS will be distributed: compile to minified CSS.
let stylesSrcWatch = 'src/scss/**/*.scss';
let stylesSrcList = [styleSrcFile];

// 2. JS
// let scriptjQueryFile = 'jquery.js'; // temporary include manually
let scriptSrcFile = 'devsunshine-admin.js';
let scriptsSrcDir = 'src/js/';
let scriptsDistDir = './assets/js/'; // where the JS will be distribute: compile to minified JS
let scriptsSrcWatch = 'src/js/**/*.js';
// A list of JavaScript that we want to check
let scriptsSrcList = [scriptSrcFile];		// ~ jsFiles in tutorial

// 3. fonts
let fontsSrcDir = 'src/fonts/';
let fontsDistDir = './assets/fonts';
//let fontsSrcWatch = 'src/js/**/*.js';

// 4. icons
let iconsSrcDir = 'src/icons/';
let iconsDistDir = './assets/icons';
let iconsSrcWatch = 'src/js/**/*.svg';  // use icons in svg

// 5. images
let imagesSrcDir = 'src/images/';
let imagesDistDir = './assets/images';
let imagesSrcWatch = 'src/js/**/*.png'; // use image in svg

/**
 * Gulp tasks
 * ====================================
 * **/

/* Wrap the current project with domain "generalgulp.devsunset"
* - Access domain: https://generalgulp.devsunset:3000
*  */
gulp.task('browser-sync', function(){
  browserSync.init( {
    open: true,
    injectChanges: true,
    proxy: 'generalgulp.devsunset',
    serveStatic: ['./assets'],
    https: {
      key: 'source/resources/certificates/server-generalgulp.key',
      cert: 'source/resources/certificates/server-generalgulp.crt'
    }
  });
});

function browser_sync_setup_instance(){
  browserSync.init( {
    open: true,
    injectChanges: true,
    proxy: 'generalgulp.devsunset',
    serveStatic: ['./assets'],
    https: {
      key: 'source/resources/certificates/server-generalgulp.key',
      cert: 'source/resources/certificates/server-generalgulp.crt'
    }
  });

}

function browser_sync_create_new_instance(){
  let browserSync = require('browser-sync').create();

  browserSync.init( {
    open: true,
    injectChanges: true,
    proxy: 'generalgulp.devsunset',
    serveStatic: ['./dist'],
    https: {
      key: 'source/resources/certificates/server-generalgulp.key',
      cert: 'source/resources/certificates/server-generalgulp.crt'
    }
  });

  return browserSync;
}
/******************************/
/*** Devsunshine plugin distribution tasks - Update 2021-Dec-7 ***/
/******************************/

/* 1. Compile multiple SCSS source files to the same destination CSS files */
let taskDistributePluginStyles = gulp.task('distribute-plugin-styles', function(done){
  // 2. Declare a source directory
  let stylesSrcDir = 'source/';

  // 1. Declare a single files
  let styleAdminSrcFolder = 'admin/scss/';
  let styleAdminSrcFile = 'gutbcontent-admin.scss';

  // 3. Distribution directory
  // 3.1. Generic distribution directory
  let stylesDistDir = './assets/';  // where CSS will be distributed: compile to minified CSS.
  let stylesDistFolder = 'admin/css/';
  // 3.2. Plugin admin styles
  distribute_single_scss_to_css(
    stylesSrcDir + styleAdminSrcFolder + styleAdminSrcFile,
    stylesDistDir + stylesDistFolder
  );

  // 4. Custom Gutenberg editor/content block styles 
  // 4.1. Backend scope - Gutenberg editor display
  // 4.1.1. Source files
  let editorStyleSrcFolder = 'editor/scss/';
  let editorStyleSrcFile = 'gutbcontent-gutenberg-blocks.scss';

  // 4.1.2. Distribution directory
  let editorStyleDistDir = './assets/';
  let editorStyleDistFolder = 'editor/css/'

  distribute_single_scss_to_css(
    stylesSrcDir + editorStyleSrcFolder + editorStyleSrcFile,
    editorStyleDistDir + editorStyleDistFolder
  );
  
  // 4.2. Frontend scope - users view display.
  // 4.1.1. Source files
  editorStyleSrcFolder = 'frontend/scss/';
  editorStyleSrcFile = 'gutbcontent-gutenberg-blocks.scss';

  // 4.1.2. Distribution directory
  editorStyleDistDir = './assets/';
  editorStyleDistFolder = 'frontend/css/'

  distribute_single_scss_to_css(
    stylesSrcDir + editorStyleSrcFolder + editorStyleSrcFile,
    editorStyleDistDir + editorStyleDistFolder
  );

  // 4.3. Custom page template
  pageTemplateStyleSrcFolder = 'page/scss/';
  pageTemplateStyleSrcFile = 'template-scientific-post.scss';

  // 4.1.2. Distribution directory
  pageTemplateStyleDistDir = './assets/';
  pageTemplateStyleDistFolder = 'page/css/'

  distribute_single_scss_to_css(
    stylesSrcDir + pageTemplateStyleSrcFolder + pageTemplateStyleSrcFile,
    pageTemplateStyleDistDir + pageTemplateStyleDistFolder
  );

  done();
});

let taskDistributePrerequisitePluginStyles = gulp.task('distribute-prerequisite-plugin-styles', function(done){
  let stylesSrcDir = 'source/';

  let stylesDistDir = './assets/'; // where the JS will be distribute: compile to minified JS

  let styleSrcLibraryFolder = 'library/scss/';
  let styleSrcLibraryFile = 'gutbcontent-prerequisite.scss';
  let styleDistLibraryFolder = 'library/css/';

  distribute_single_scss_to_css(
    stylesSrcDir + styleSrcLibraryFolder + styleSrcLibraryFile,
    stylesDistDir + styleDistLibraryFolder
  );

  done();
});



let taskDistributePluginScripts = gulp.task('distribute-plugin-scripts', function(done){
  // 1. Declare a source directory -> a distribution directory
  // 1.1. Root Source directory
  let scriptsSrcDir = 'source/';
  // 1.2. Root distribution directory.
  let scriptsDistDir = './assets/';  // where JavaScript ES6 will be compiled to Vanilla JavaScript

  // 2. Declare file & its metadata to be compiled
  // 2.1. JS files for Plugin admin setting pages
  let scriptAdminSrcFolder = 'admin/js/';
  let scriptAdminSrcFile = 'gutbcontent-admin.js';
  //let scriptsDistFolder = scriptAdminSrcFolder;

  // Distribute the plugin admin setting page script while keeping the same directory structure
  distribute_single_js_to_vanilla_js(
    scriptsSrcDir + scriptAdminSrcFolder,
    scriptAdminSrcFile,
    scriptsDistDir + scriptAdminSrcFolder
  );

  // 2.2. JS files for the Gutenberg custom Call-to-Action block
  // Compile while keeping same directory structure.
  // 2.2.1. Backend scope - Gutenberg editor
  let scriptCustomCTASrcFolder = 'editor/js/';
  let scriptCustomCTASrcFile = 'gutbcontent-gutenberg-blocks.js';

  // Distribute the plugin custom CTA block while keeping the same directory structure
  distribute_single_js_to_vanilla_js(
    scriptsSrcDir + scriptCustomCTASrcFolder,
    scriptCustomCTASrcFile,
    scriptsDistDir + scriptCustomCTASrcFolder
  );

  // 2.2.2. Fronend scope - user views
  scriptCustomCTASrcFolder = 'frontend/js/';
  scriptCustomCTASrcFile = 'gutbcontent-gutenberg-blocks.js';
  
  distribute_single_js_to_vanilla_js(
    scriptsSrcDir + scriptCustomCTASrcFolder,
    scriptCustomCTASrcFile,
    scriptsDistDir + scriptCustomCTASrcFolder
  );

  // 2.2.3. Page template - Update 2022-Jan-09
  scriptPageTemplateSrcFolder = 'page/js/';
  scriptPageTemplateSrcFile = 'template-scientific-post.js';
  
  distribute_single_js_to_vanilla_js(
    scriptsSrcDir + scriptPageTemplateSrcFolder,
    scriptPageTemplateSrcFile,
    scriptsDistDir + scriptPageTemplateSrcFolder
  );

  done();
});

let taskDistributePrerequisitePluginScripts = gulp.task('distribute-prerequisite-plugin-scripts', function(done){
  let scriptsSrcDir = 'source/';

  let scriptsDistDir = './assets/'; // where the JS will be distribute: compile to minified JS

  let scriptLibrarySrcFolder = 'library/js/';
  let scriptLibraryFile = 'gutbcontent-prerequisite.js'; // Obtain the uncompressed version at https://jquery.com/download/
  
  distribute_single_js_to_vanilla_js(
    scriptsSrcDir + scriptLibrarySrcFolder,
    scriptLibraryFile,
    scriptsDistDir + scriptLibrarySrcFolder
  );

  done();
});

/*let taskDistributePluginStylesScripts = gulp.task('distribute-plugin-styles-scripts', function(done){
  gulp.parallel( ['distribute-plugin-styles', 'distribute-plugin-scripts'] );
  done();
});*/

let taskDistributePluginStylesScripts = gulp.task(
  'distribute-plugin-styles-scripts',
  gulp.parallel( ['distribute-plugin-styles', 'distribute-plugin-scripts'] )
);

let taskDistributePluginPrerequisiteLibrary = gulp.task(
  'distribute-prerequisite-plugin-styles-scripts',
  gulp.parallel( ['distribute-prerequisite-plugin-styles','distribute-prerequisite-plugin-scripts'] )
);

  /******************************/
/*** Single tasks  ***/
/******************************/
/* 1. Transpile SCSS to minified CSS */
let taskDistributeStyles = gulp.task('distribute-styles', function(done){
  distribute_all_scss_to_css(stylesSrcWatch, stylesDistDir);
  done();
});

/* Compile SCSS to normal CSS
* - outputStyle: no compress
* - No rename */
function distribute_all_scss_to_css(scssSourceDir, cssDestDir){
  return gulp.src( scssSourceDir )
    .pipe( plumber() )
    .pipe( sourcemaps.init() )
    .pipe(
      sass(
        {
          errorLogToConsole: true
        }
      ).on('error', console.error.bind( console ) )
    )
    .pipe(
      autoprefixer({ cascade: false })
    )
    .pipe( sourcemaps.write('./') )
    .pipe(gulp.dest( cssDestDir ) )
    .pipe( browserSync.stream() );
}


function distribute_single_scss_to_css(scssSourceFile, cssDestDir){
  return gulp.src( scssSourceFile )
    .pipe( plumber() )
    .pipe( sourcemaps.init() )
    .pipe(
      sass(
        {
          errorLogToConsole: true
        }
      ).on('error', console.error.bind( console ) )
    )
    .pipe(
      autoprefixer({ cascade: false })
    )
    .pipe( sourcemaps.write('./') )
    .pipe(gulp.dest( cssDestDir ) )
    .pipe( browserSync.stream() );
}

let taskDistributeMinifiedStyles = gulp.task('distribute-minified-styles', function(done){
  distribute_all_scss_to_minified_css(stylesSrcWatch, stylesDistDir);
  done();
});

function distribute_all_scss_to_minified_css(scssSourceDir, cssDestDir){
  return gulp.src( scssSourceDir )
    .pipe( plumber() )
    .pipe( sourcemaps.init() )
    .pipe(
      sass(
        {
          errorLogToConsole: true,
          outputStyle: 'compressed'
        }
      ).on('error', console.error.bind( console ) )
    )
    .pipe(
      autoprefixer({ cascade: false })
    )
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( sourcemaps.write('./') )
    .pipe(gulp.dest( cssDestDir ) )
    .pipe( browserSync.stream() );
}



/* 2. Compile JS to minified JS */
/* 2.1. Just compile JS (include translating JS ES6) to Vanilla JS */

/*let taskDistributeScripts2 = gulp.task('distribute-scripts-2', function(done){
  // scriptFilesList.map( entryFile => distribute_single_js(scriptFolder, entryFile, scriptDist) );
  distribute_all_js(scriptsSrcWatch, scriptsDistDir);
  done();
});

function distribute_all_js(jsSourceDir, jsDestDir){
  return browserify({
    entries: jsSourceDir
  })
    .transform( babelify, {presets: ["@babel/preset-env"] })
    .bundle()
    .pipe( source( jsSourceDir ) )
    .pipe( plumber() )
    .pipe( rename({ extname: ".js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest( jsDestDir ) )
    .pipe( browserSync.stream() );
}*/

let taskDistributeScripts = gulp.task('distribute-scripts', function(done){
  // scriptFilesList.map( entryFile => distribute_single_js(scriptFolder, entryFile, scriptDist) );
  distribute_all_js_to_readable_js(scriptsSrcWatch, scriptsDistDir);
  done();
});

/*function distribute_all_to_vanilla_js(jsFilesDir, jsFilenamesList, jsDestDir){
  jsFilenamesList.map( jsFilename => distribute_single_js_to_vanilla_js(jsFilesDir, jsFilename, jsDestDir) );
}*/

function distribute_all_js_to_readable_js(jsSourceDir, jsDestDir){
  return gulp.src(jsSourceDir)
    .pipe( plumber() )
    .pipe( babel() )
    .pipe( rename({ extname: ".js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest(jsDestDir))
    .pipe( browserSync.stream() );
}

function distribute_single_js_to_readable_js(jsSourceFile, jsDestDir){
  return gulp.src(jsSourceFile)
    .pipe( plumber() )
    .pipe( babel() )
    .pipe( rename({ extname: ".js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest(jsDestDir))
    .pipe( browserSync.stream() );
}


/* Rebuild files list: multi-dimension array: File list item contains: jsFileDir, jsFileName */

/*
* - Add .pipe( uglify() ) to convert to minified JS versions
*  */
function distribute_single_js_to_vanilla_js(jsFileDir, jsFileName, jsDestDir) {
  return browserify({
    entries: [jsFileDir + jsFileName]
  })
    .transform( babelify, {presets: ["@babel/preset-env"] })
    .bundle()
    .pipe( source( jsFileName ) )
    .pipe( plumber() )
    .pipe( rename({ extname: ".js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest( jsDestDir ) )
    .pipe( browserSync.stream() );
}

function distribute_single_js_to_minified_vanilla_js(jsFileDir, jsFileName, jsDestDir) {
  return browserify({
    entries: [jsFileDir + jsFileName]
  })
    .transform( babelify, {presets: ["@babel/preset-env"] })
    .bundle()
    .pipe( source( jsFileName ) )
    .pipe( plumber() )
    .pipe( rename({ extname: ".min.js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( uglify() )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest( jsDestDir ) )
    .pipe( browserSync.stream() );
}

/* 2.2. Compile JS to minified JS*/
let taskDistributeMinifiedScripts = gulp.task('distribute-minified-scripts', function(done){
  // scriptFilesList.map( entryFile => distribute_single_js(scriptFolder, entryFile, scriptDist) );
  distribute_all_js_to_minified_js(scriptsSrcWatch, scriptsDistDir);
  done();
});



/*function distribute_all_to_minified_js(jsFilesDir, jsFilenamesList, jsDestDir){
  jsFilenamesList.map( jsFilename => distribute_single_js_to_minified_js(jsFilesDir, jsFilename, jsDestDir) );
}*/

function distribute_all_js_to_minified_js(jsSourceDir, jsDestDir){
  return gulp.src(jsSourceDir)
    .pipe( plumber() )
    .pipe( babel() )
    .pipe( rename({ extname: ".js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( uglify() )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest(jsDestDir))
    .pipe( browserSync.stream() );
}

/*function distribute_single_js_to_minified_js(jsFileDir, jsFileName, jsDestDir) {
  return browserify({
    entries: [jsFileDir + jsFileName]
  })
    .transform( babelify, {presets: ["@babel/preset-env"] })
    .bundle()
    .pipe( source( jsFileName ) )
    .pipe( plumber() )
    .pipe( rename({ extname: ".min.js" }) )
    .pipe( buffer() )
    .pipe( sourcemaps.init({ loadMaps: true }) )
    .pipe( uglify() )
    .pipe( sourcemaps.write( './' ) )
    .pipe( gulp.dest( jsDestDir ) )
    .pipe( browserSync.stream() );
}*/

let taskDistributeIcons = gulp.task('distribute-icons', function(done){
  distribute_icons(iconsSrcWatch, iconsDistDir );
  done();
});

let taskDistributePluginIcons = gulp.task('distribute-plugin-icons', function(done){
  let iconSource = 'source/resources/icons/*.svg';
  let iconDist = './assets/resources/icons';

  gulp.src(iconSource).pipe(gulp.dest(iconDist));

  done();
});

function distribute_icons(iconSrc, iconDist){
  return gulp.src(iconSrc)
    .pipe(gulp.dest(iconDist));
}

let taskDistributeImages = gulp.task('distribute-images', function(done){
  distribute_icons(imagesSrcWatch, imagesDistDir );
  done();
});

function distribute_images(imageSrc, imageDist){
  return gulp.src(imageSrc)
    .pipe(gulp.dest(imageDist));
}

/*** Comprehensive tasks ***/

// Task to compile to readable scripst
let taskWatchDistributeStylesScripts = gulp.task('styles-scripts-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(stylesSrcWatch, gulp.series(['distribute-styles']));
  //gulp.watch(stylesSrcWatch, gulp.series(['distribute-scripts']));
  gulp.watch(scriptsSrcWatch, gulp.series( ['distribute-single-plugin-script', 'distribute-prerequisite-plugin-scripts'] ));
  done();
});

// Task to compile to minified CSS & JS (use when development process is done).
let taskWatchDistributeMinifiedStylesScripts = gulp.task('minified-styles-scripts-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(stylesSrcWatch, gulp.series(['distribute-minified-styles']));
  gulp.watch(scriptsSrcWatch, gulp.series(['distribute-minified-scripts']));
  done();
});

let taskWatchDistributePluginStyles = gulp.task('styles-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(stylesSrcWatch, gulp.series(['distribute-styles']));
  done();
});



let taskWatchDistributeScripts = gulp.task('scripts-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(scriptsSrcWatch, gulp.series(['distribute-scripts']));
  done();
});

/* ============================================== */
/* 2021-Dec-08 Styles Scripts watch */
/* ============================================== */

let taskWatchPluginStylesScripts = gulp.task('plugin-styles-scripts-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(stylesSrcWatch, gulp.series(['distribute-plugin-styles']));

  //gulp.watch(scriptsSrcWatch, gulp.series( ['distribute-plugin-scripts', 'distribute-prerequisite-plugin-scripts'] ));
  gulp.watch(scriptsSrcWatch, gulp.series( ['distribute-plugin-scripts'] ));
  done();
});

let taskWatchPluginStyles = gulp.task('plugin-styles-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(stylesSrcWatch, gulp.series(['distribute-plugin-styles']));
  done();
});

let taskWatchPluginScripts = gulp.task('plugin-scripts-watch', function(done){
  browser_sync_setup_instance();
  gulp.watch(scriptsSrcWatch, gulp.series(['distribute-plugin-scripts']));
  done();
});


/* Helper functions */
function trigger_simple_plumber(srcFile, destUrl){
  return gulp.src( srcFile )
    .pipe( plumber() )
    .pipe( gulp.dest( destUrl ) );
}



