const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/') // Dossier où seront générés les fichiers compilés
    .setPublicPath('/build') // URL publique pour accéder aux fichiers

    // Ajouter les entrées JS et CSS
    .addEntry('app', './assets/app.js')
    .addStyleEntry('styles', './assets/styles/app.css') // Nouveau nom "styles"
    

    // Activer les fonctionnalités utiles
    .enablePostCssLoader() // Activer PostCSS si besoin (optionnel)
    .enableSourceMaps(!Encore.isProduction()) // Activer les sourcemaps en mode développement
    .cleanupOutputBeforeBuild() // Nettoyer le dossier public/build avant chaque build
    .enableBuildNotifications() // Notifications de compilation
    .enableVersioning(Encore.isProduction()); // Activer le versioning pour éviter le cache
    Encore.enableSingleRuntimeChunk();
    Encore.configureBabel((config) => {
        if (!config.presets.includes('@babel/preset-env')) {
            config.presets.push('@babel/preset-env');
        }
    });

module.exports = Encore.getWebpackConfig();
