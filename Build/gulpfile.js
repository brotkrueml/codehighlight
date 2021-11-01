const
  {src, dest, series, parallel} = require('gulp'),

  cleanCSS = require('gulp-clean-css'),
  concat = require('gulp-concat'),
  del = require('del'),
  fs = require('fs'),
  nunjucks = require('gulp-nunjucks'),
  path = require('path'),
  rename = require('gulp-rename'),
  uglify = require('gulp-uglify')
;

const options = {
  inputPath: 'node_modules/prismjs/',
  outputPath: '../Resources/Public/Prism/',
  availablePlugins: [
    'command-line',
    'copy-to-clipboard',
    'inline-color',
    'line-highlight',
    'line-numbers',
    'toolbar',
  ],
};

const getPluginPathsForFilePattern = (filePattern) => {
  let pluginPaths = [];
  options.availablePlugins.forEach((pluginName) => {
    pluginPaths.push(options.inputPath + 'plugins/' + pluginName + '/' + filePattern);
  });

  return pluginPaths;
};

const cleanUp = () =>
  del([
    options.outputPath + '**',
  ], {
    force: true,
  })
;

const copyComponents = () =>
  src([options.inputPath + 'components/*.min.js'])
    .pipe(dest(options.outputPath + 'components/'))
;

const minifyAndCopyAutoloaderScript = () =>
  // The original file was patched (language_path), so we have to minify it
  src(options.inputPath + 'plugins/autoloader/prism-autoloader.js')
    .pipe(uglify())
    .pipe(rename('prism-autoloader.min.js'))
    .pipe(dest(options.outputPath + 'plugins/autoloader/'))
;

const copyPluginJavaScripts = () =>
  src(getPluginPathsForFilePattern('*.min.js'))
    .pipe(dest((file) => options.outputPath + 'plugins/' + path.basename(file.base)))
;

const copyPluginStyles = () =>
  src(getPluginPathsForFilePattern('*.css'))
    .pipe(cleanCSS())
    .pipe(dest((file) => options.outputPath + 'plugins/' + path.basename(file.base)))
;

const copyThemes = () =>
  src([options.inputPath + 'themes/*.css'])
    .pipe(cleanCSS())
    .pipe(dest(options.outputPath + 'themes/'))
;

const generateComponentsList = () => {
  const files = fs.readdirSync(options.outputPath + 'components/');

  let languages = [];
  files.forEach((file) => {
    let language = file.split('.')[0].replace('prism-', '');

    if (language !== 'core') {
      languages.push(language);
    }
  });

  return src('Templates/AvailableProgrammingLanguages.php.template')
    .pipe(nunjucks.compile({languages: languages}))
    .pipe(concat('AvailableProgrammingLanguages.php'))
    .pipe(dest('../Resources/Private/PHP/'))
};


exports.build = series(
  cleanUp,
  parallel(
    copyComponents,
    minifyAndCopyAutoloaderScript,
    copyPluginJavaScripts,
    copyPluginStyles,
    copyThemes,
  ),
  generateComponentsList,
);
