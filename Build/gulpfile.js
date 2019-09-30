const
  {src, dest, series, parallel} = require('gulp'),

  cleanCSS = require('gulp-clean-css'),
  concat = require('gulp-concat'),
  copy = require('gulp-copy'),
  del = require('del'),
  fs = require('fs'),
  nunjucks = require('gulp-nunjucks')
;

const options = {
  inputPath: 'node_modules/prismjs/',
  outputPath: '../Resources/Public/Vendor/PrismJs/',
  availablePlugins: [
    'autoloader',
    'command-line',
    'line-highlight',
    'line-numbers',
  ],
};

const getPluginPathsForFilePattern = (filePattern) => {
  let pluginPaths = [];
  options.availablePlugins.forEach((plugin) => {
    pluginPaths.push(options.inputPath + 'plugins/' + plugin + '/' + filePattern);
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

const copyPluginJavaScripts = () =>
  src(getPluginPathsForFilePattern('*.min.js'))
    .pipe(copy(options.outputPath + 'plugins/', {prefix: 3}))
;

const copyPluginStyles = () =>
  src(getPluginPathsForFilePattern('*.css'))
    .pipe(copy(options.outputPath + 'plugins/', {prefix: 3}))
    .pipe(cleanCSS())
    .pipe(dest(options.outputPath + 'plugins/'))
;

const copyThemes = () =>
  src([options.inputPath + 'themes/*.css'])
    .pipe(cleanCSS())
    .pipe(dest(options.outputPath + 'themes/'))
;

const adjustAutoloaderPlugin = (cb) => {
  // If cache busting is activated (e.g. prism-autoloader.min.1234567890.js) the url of the loaded language files
  // is not correct. So here is a dirty workaround.
  let autoloader = fs.readFileSync(options.outputPath + 'plugins/autoloader/prism-autoloader.min.js', 'utf8');

  autoloader = autoloader.replace('\\.(?:min\\.)js$/', '\\.(?:min\\.)(?:[0-9]+\\.)js$/');

  fs.writeFile(options.outputPath + 'plugins/autoloader/prism-autoloader.min.js', autoloader, cb);
};

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
    copyPluginJavaScripts,
    copyPluginStyles,
    copyThemes,
  ),
  adjustAutoloaderPlugin,
  generateComponentsList,
);
