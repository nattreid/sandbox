<?php

/** This file is part of KCFinder project
 *
 *      @desc Base configuration file
 *   @package KCFinder
 *   @version 3.12
 *    @author Pavel Tzonkov <sunhater@sunhater.com>
 * @copyright 2010-2014 KCFinder Project
 *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
 *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 *      @link http://kcfinder.sunhater.com
 */
/* IMPORTANT!!! Do not comment or remove uncommented settings in this file
  even if you are using session configuration.
  See http://kcfinder.sunhater.com/install for setting descriptions */

$_CONFIG = array(
// GENERAL SETTINGS

    'disabled' => true,
    'uploadURL' => "/upload",
    'uploadDir' => "",
    'theme' => "default",
    'types' => array(
        // (F)CKEditor types
        'files' => "",
        'flash' => "swf",
        'images' => "*img",
        // TinyMCE types
        'file' => "",
        'media' => "swf flv avi mpg mpeg qt mov wmv asf rm",
        'image' => "*img",
    ),
// IMAGE SETTINGS
    'imageDriversPriority' => "imagick gmagick gd",
    'jpegQuality' => 70,
    'thumbsDir' => ".thumbs",
    'maxImageWidth' => 800,
    'maxImageHeight' => 800,
    'thumbWidth' => 100,
    'thumbHeight' => 100,
    'watermark' => "",
// DISABLE / ENABLE SETTINGS
    'denyZipDownload' => false,
    'denyUpdateCheck' => false,
    'denyExtensionRename' => false,
// PERMISSION SETTINGS
    'dirPerms' => 0755,
    'filePerms' => 0644,
    'access' => array(
        'files' => array(
            'upload' => true,
            'delete' => false,
            'copy' => false,
            'move' => false,
            'rename' => false
        ),
        'dirs' => array(
            'create' => true,
            'delete' => false,
            'rename' => false
        )
    ),
    'deniedExts' => "exe com msi bat cgi pl php phps phtml php3 php4 php5 php6 py pyc pyo pcgi pcgi3 pcgi4 pcgi5 pchi6",
// MISC SETTINGS
    'filenameChangeChars' => array(/*
      ' ' => "_",
      ':' => "."
     */),
    'dirnameChangeChars' => array(/*
      ' ' => "_",
      ':' => "."
     */),
    'mime_magic' => "",
    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => 'KCFINDER_',
// THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION SETTINGS
    '_normalizeFilenames' => false,
    '_check4htaccess' => true,
    //'_tinyMCEPath' => "/tiny_mce",
    '_sessionVar' => "KCFINDER",
        //'_sessionLifetime' => 30,
        //'_sessionDir' => "/full/directory/path",
        //'_sessionDomain' => ".mysite.com",
        //'_sessionPath' => "/my/path",
        //'_cssMinCmd' => "java -jar /path/to/yuicompressor.jar --type css {file}",
        //'_jsMinCmd' => "java -jar /path/to/yuicompressor.jar --type js {file}",
);

$path = __DIR__ . '/../../../';
require_once $path . 'vendor/autoload.php';

// prava pro temp atd
umask(0);

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger($path . 'log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory($path . 'temp');

$configurator->createRobotLoader()
        ->addDirectory($path . 'app/')
        ->register();

$configurator->addConfig($path . 'app/config/config.neon');
$configurator->addConfig($path . 'app/config/project.neon');
$configurator->addConfig($path . 'app/config/config.local.neon');

$configurator->addParameters([
    'logDir' => $path . 'log',
    'sessionDir' => $path . 'temp/sessions'
]);

$container = $configurator->createContainer();

$resource = 'cms.KCFinder';
$user = $container->getService('user');
$user->getStorage()->setNamespace('cms');
$_CONFIG['disabled'] = !$user->isAllowed($resource, 'view');

if ($user->isAllowed($resource, 'edit')) {
    $_CONFIG['access'] = array(
        'files' => array(
            'upload' => true,
            'delete' => true,
            'copy' => true,
            'move' => true,
            'rename' => true
        ),
        'dirs' => array(
            'create' => true,
            'delete' => true,
            'rename' => true
        )
    );
}