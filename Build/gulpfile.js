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
  generateComponentsList,
);
