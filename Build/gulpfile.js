const
  gulp = require('gulp'),

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
    'line-numbers',
  ],
};


const cleanUp = () =>
  del([
    options.outputPath + '**',
  ], {
    force: true,
  })
;

const copyComponents = () =>
  gulp
    .src([options.inputPath + 'components/*.min.js'])
    .pipe(gulp.dest(options.outputPath + 'components/'))
;

const copyPlugins = () => {
  let pluginPaths = [];
  options.availablePlugins.forEach((plugin) => {
    pluginPaths.push(options.inputPath + 'plugins/' + plugin + '/*.min.js');
    pluginPaths.push(options.inputPath + 'plugins/' + plugin + '/*.css');
  });

  return gulp
    .src(pluginPaths)
    .pipe(copy(options.outputPath + 'plugins/', {prefix: 3}))
    ;
};

const copyThemes = () =>
  gulp
    .src([options.inputPath + 'themes/*.css'])
    .pipe(gulp.dest(options.outputPath + 'themes/'))
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

  return gulp.src('Templates/AvailableProgrammingLanguages.php.template')
    .pipe(nunjucks.compile({languages: languages}))
    .pipe(concat('AvailableProgrammingLanguages.php'))
    .pipe(gulp.dest('../Resources/Private/PHP/'))
};


exports.build = gulp.series(
  cleanUp,
  gulp.parallel(
    copyComponents,
    copyPlugins,
    copyThemes,
  ),
  adjustAutoloaderPlugin,
  generateComponentsList,
);
