const Encore = require('@symfony/webpack-encore');
// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')
    .addEntry('admin/app', './assets/app-admin.js')
    .addEntry('select2', './assets/js/admin/select2.js')
    .addEntry('admin/sidebar', './assets/js/admin/sidebar.js')
    .addEntry('admin/topbar', './assets/js/admin/topbar.js')
    .addEntry('admin/calendar', './assets/js/admin/calendar.js')
    .addEntry('admin/meeting-form', './assets/js/admin/meeting-form.js')
    .addEntry('admin/closest-meeting-timer', './assets/js/admin/closest-meeting-timer.js')
    .addEntry('admin/meeting-modal', './assets/js/admin/meeting-modal.js')
    .addEntry('form-validator', './assets/js/admin/form-validator.js')
    .addEntry('website/navbar', './assets/js/website/navbar.js')
    .addEntry('particles', './assets/js/particles.js')
    .addEntry('particles-ini', './assets/libs/particles.js/particles.js')
    .addEntry('home/carousel', './assets/js/homepage/carousel.js')
    .addStyleEntry('css/app', './assets/styles/app.scss')

    // Enable jquery
    .autoProvidejQuery()
    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader((options) => {
        // Optionally adjust the configuration of the Sass loader
        // For example, to process SCSS files
        options.sassOptions = {
            indentedSyntax: false, // Set to true if using indented Sass
        };
    })

    .addStyleEntry('bootstrap', './node_modules/bootstrap/dist/css/bootstrap.min.css')

    .copyFiles({
        from: './assets/image',
        to: 'images/[path][name].[ext]',
    })
    .copyFiles({
        from: './assets/trello',
        to: 'trello/[path][name].[ext]',
    })

    .copyFiles({
        from: './assets/libs/particles.js',
        to: 'libs/particles.js/[name].[ext]',
    })

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
