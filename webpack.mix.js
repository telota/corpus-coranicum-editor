let mix = require('laravel-mix');

mix.setResourceRoot(process.env.MIX_APP_SUBPATH);
mix.options({ fileLoaderDirs: { fonts: 'assets/fonts' }, });

mix.stylus('resources/assets/stylus/app.styl', './public/assets/css/app.css');
mix.sass(
  'resources/assets/sass/bootstrap-styling.scss',
  'public/assets/css/bootstrap-styling.css',
);

mix.copy('node_modules/font-awesome/fonts','public/assets/fonts');

mix.styles(
  [
    'node_modules/font-awesome/css/font-awesome.min.css',
    'node_modules/jquery-ui-dist/jquery-ui.min.css',
    'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
    'node_modules/summernote/dist/summernote.css',
    'node_modules/select2/dist/css/select2.min.css',
    'node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    'node_modules/jquery-jcrop/css/jquery.Jcrop.min.css',
    'node_modules/cropperjs/dist/cropper.css',
  ],
  'public/assets/css/bundle.css',
);

mix.copy('node_modules/summernote/dist/font', 'public/assets/css/font');
mix.copy('node_modules/jquery-ui-dist/images', 'public/assets/css/images');
mix.copy('node_modules/jquery-jcrop/css/Jcrop.gif', 'public/assets/css');
mix.copy('resources/assets/fonts', 'public/assets/fonts');

// Mix node modules
mix
  .scripts(
    [
      // Not sure if and why we need jquery.1
      // 'node_modules/jquery.1/node_modules/jquery/dist/jquery.min.js',
      'node_modules/jquery/dist/jquery.min.js',
      'node_modules/datatables.net/js/jquery.dataTables.min.js',
      'node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js',
      'node_modules/jquery-ui-dist/jquery-ui.min.js',
      'node_modules/summernote/dist/summernote.min.js',
      'resources/assets/js/libs/summernote-ext-rtl.js',
      'node_modules/select2/dist/js/select2.min.js',
      'node_modules/moment/min/moment-with-locales.min.js',
      'node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
      'node_modules/jquery-jcrop/js/jquery.Jcrop.min.js',
      'node_modules/clipboard/dist/clipboard.min.js',
      'node_modules/bootstrap/dist/js/bootstrap.min.js',
    ],
    'public/assets/js/bundle.js',
  )
  .sourceMaps();

mix
  .js('resources/assets/js/main.js', 'public/assets/js/main.js')
  .vue({ version: 2 })
  .sourceMaps();

mix.ts('resources/assets/typescript/main.ts','public/assets/js/main-typescript.js');

mix
  .js(
    'resources/assets/js/cc-edit/manuskriptseiten/manuskriptseiten-select.js',
    'public/assets/js/manuskriptseiten-select.js',
  )
  .vue({ version: 2 });
