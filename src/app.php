<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__. '/../templates',
));

/*$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
    }));*/

// -- Assetic --

$app->register(new SilexAssetic\AsseticServiceProvider());

$app['assetic.path_to_web'] = __DIR__ . '/../web';
$app['assetic.options'] = array(
    'debug' => true,
    'auto_dump_assets' => true,
);

$app['assetic.filter_manager'] = $app->share(
    $app->extend('assetic.filter_manager', function($fm, $app) {
	$fm->set('cssmin', new Assetic\Filter\CssMinFilter());
	$fm->set('jsqueeze', new Assetic\Filter\JSqueezeFilter());

	return $fm;
    })
);

$app['assetic.asset_manager'] = $app->share(
    $app->extend('assetic.asset_manager', function($am, $app) {
	$am->set('styles', new Assetic\Asset\AssetCache(
	    new Assetic\Asset\GlobAsset(
		__DIR__ . '/../resources/css/*.css',
		array($app['assetic.filter_manager']->get('cssmin'))
	    ),
	    new Assetic\Cache\FilesystemCache(__DIR__ . '/../var/cache/assetic')
	));

	$am->get('styles')->setTargetPath('css/styles.css');

    $am->set('scripts', new Assetic\Asset\AssetCache(
	new Assetic\Asset\GlobAsset(
	    __DIR__ . '/../resources/js/*.js',
	    array($app['assetic.filter_manager']->get('jsqueeze'))
	),
	new Assetic\Cache\FilesystemCache(__DIR__ . '/../var/cache/assetic')
    ));

	$am->get('scripts')->setTargetPath('js/scripts.js');

	return $am;
    })
);

return $app;
