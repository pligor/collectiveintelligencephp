<?php
$basePath = realpath( dirname(__FILE__).'/..' );
$yii_path = realpath( $basePath.'/../../yii' );
Yii::setPathOfAlias('yii', $yii_path);

return array(	//Any writable CWebApplication properties can be configured here:
	'basePath' => $basePath,
	'name' => 'Collective Intelligence',

	'preload' => array(
		'log',
		//'bootstrap', // preload the bootstrap component
	),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',

        'yii.components.*',
	),
	
	'aliases' => array(
    	'bootstrap' => 'ext.bootstrap',
    ),
	
	'behaviors' => array(
        'ApplicationConfigBehavior' => array(
            'class' => 'ext.behaviors.ApplicationConfigBehavior',
            //'property1'=>'value1',
        )
    ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		///*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			'generatorPaths' => array(
				//'bootstrap.gii',
            ),
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		//*/
	),

	// application components
	'components'=>array(
		/*by default we don't use the  extension,we use the original bootstrap js and css files,(with less).
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap',
		),*/
	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'site/page/<view:\w+>' => 'site/page/',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		*/
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		'db' => array(
            //in order for port to work you should use a real ip number. localhost and port=5000 will NOT work. 127.0.0.1 and port 5000 will WORK
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=colint',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'qr21131s35Uy4mT',
            'charset' => 'utf8',
            'enableParamLogging' => true,
            //'schemaCachingDuration' => 3600,	//number of seconds that table metadata can remain valid in cache
            'autoConnect' => true,	//Note, this property is only effective when the CDbConnection object is used as an application component.
            'tablePrefix' => '',
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				//array('class' => 'CFileLogRoute','levels' => 'error, warning',),
				array(
					'class' => 'CWebLogRoute',
				),
			),
		),
		
		'clientScript' => array(	//override clientScript
			'class' => 'CClientScript',
			'scriptMap' => array(
				'jquery.js' => false,
				'jquery.min.js' => false,
			),
			'coreScriptPosition' => CClientScript::POS_END,	//due to boilerplates instructions
		),
	),

	// application-level parameters that can be accessed using Yii::app()->params['paramName']
	'params'=>array(
		'adminEmail'=>'webmaster@example.com',	// this is used in contact page
		//'googleApiKey' => 'AIzaSyDI20ZYXdNdilyrRyQOuKXvruPmTq_8qH4',
		//'googleApiKey' => 'ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxQGj0PqsCtxKvarsoS-iqLdqZSKfxRdmoPmGl7Y9335WLC36wIGYa6o5Q',
	),
);
