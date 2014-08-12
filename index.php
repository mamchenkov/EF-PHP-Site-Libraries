<?php
/**
 * Demo page
 * 
 * This page demonstrates how to use Easy Forex site building libraries, of which there are four:
 * 
 * - Grid, which is used to setup renderable templates
 * - Widgets, which is used to populate content
 * - Pattern, which is a simpler utility for pattern-based parsing/rendering
 * - Site, which is for organizing site's cultures and languages into hierary (not demonstrated here yet)
 * 
 * @author Leonid Mamchenkov <leonidm@easy-forex.com>
 */

// This is the only requirement
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'EasyForex' . DIRECTORY_SEPARATOR . 'autoload.php';

/*
 * Template configuration
 */
$template = new EasyForex\Grid\Template('demo', array(
	new EasyForex\Grid\Row('header', array(
		new EasyForex\Grid\Column('brandLogo', EasyForex\Grid\Renderable::MAX_WIDTH / 2),
		new EasyForex\Grid\Column('brandName', EasyForex\Grid\Renderable::MAX_WIDTH / 2, '<h4>Easy Forex</h4>'),
	)),
	new EasyForex\Grid\Row('mainmenu', new EasyForex\Grid\Column('mainmenuContent', EasyForex\Grid\Renderable::MAX_WIDTH)),
	new EasyForex\Grid\Row('messages', new EasyForex\Grid\Column('messagesContent', EasyForex\Grid\Renderable::MAX_WIDTH)),
	new EasyForex\Grid\Row('banner',   new EasyForex\Grid\Column('bannerContent',   EasyForex\Grid\Renderable::MAX_WIDTH)),
));

$span2rows = new EasyForex\Grid\Row('span2rows');

/* this is fun (embeded template) */
$tilesTemplate = new EasyForex\Grid\Template('tiles');
$tilesTemplate->setFormat('blank');

$tilesTemplate->addRow(new EasyForex\Grid\Row('tiles1', array(
	new EasyForex\Grid\Column('tileLeft1',   EasyForex\Grid\Renderable::MAX_WIDTH / 3),
	new EasyForex\Grid\Column('tileCenter1', EasyForex\Grid\Renderable::MAX_WIDTH / 3),
	new EasyForex\Grid\Column('tileRight1',  EasyForex\Grid\Renderable::MAX_WIDTH / 3),
)));

$tilesTemplate->addRow(new EasyForex\Grid\Row('tiles2', array(
	new EasyForex\Grid\Column('tileLeft2',   EasyForex\Grid\Renderable::MAX_WIDTH / 3),
	new EasyForex\Grid\Column('tileCenter2', EasyForex\Grid\Renderable::MAX_WIDTH / 3),
	new EasyForex\Grid\Column('tileRight2',  EasyForex\Grid\Renderable::MAX_WIDTH / 3),
)));
/* until about here */

$span2rows->addColumn(new EasyForex\Grid\Column('tileRows', 9, $tilesTemplate));
$span2rows->addColumn(new EasyForex\Grid\Column('regForm', 3 ));
$template->addRow($span2rows);

$template->addRow(new EasyForex\Grid\Row('containers',   new EasyForex\Grid\Column('containersContent',   EasyForex\Grid\Renderable::MAX_WIDTH)));
$template->addRow(new EasyForex\Grid\Row('serialized',   new EasyForex\Grid\Column('serializedConcent',   EasyForex\Grid\Renderable::MAX_WIDTH)));
$template->addRow(new EasyForex\Grid\Row('unserialized', new EasyForex\Grid\Column('unserializedConcent', EasyForex\Grid\Renderable::MAX_WIDTH)));

// This is handy for saving templates into databases or files
$string = $template->export();

// This is handy for loading saved templates from databases or files
$newTemplate = new EasyForex\Grid\Template('tmp');
$newTemplate->import($string);



/*
 * In a universe far far away ... 
 * Page configuration, aka content for the template
 * 
 * Hardcoded here, but you can easily add a friendly user interface with drag-and-drop
 * functionality and such.  Think of Construct (http://constructyourcss.com/) on steroids.
 * 
 * Also, you can create more widgets for specific things like forms, social buttons, videos, 
 * tracking, third-party API integration snippets, etc.
 */
$pageConfig = array(
		'brandLogo' => (string) new EasyForex\Widget\ImageWidget(array('src' => 'http://www.easy-forex.com/img/easy-forex-logo_240x60.png', 'title' => 'Super logo')),
		'brandName' => (string) new EasyForex\Widget\TextWidget(array('text'=>'Easy Markets','tag'=>'h3 class="foobar"')),
		'mainmenuContent' => (string) new EasyForex\Widget\TextWidget(array('text' => 'Main menu goes here')),
		'messagesContent' => (string) new EasyForex\Widget\TextWidget(array('text' => 'You have no messages')),
		'bannerContent' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'city', 'width' => 1110, 'height' => 455)),
		'tileLeft1' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'business', 'width' => 164, 'height' => 172)),
		'tileCenter1' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'business', 'width' => 164, 'height' => 172)),
		'tileRight1' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'business', 'width' => 164, 'height' => 172)),
		'tileLeft2' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'business', 'width' => 164, 'height' => 172)),
		'tileCenter2' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'business', 'width' => 164, 'height' => 172)),
		'tileRight2' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'business', 'width' => 164, 'height' => 172)),
		'regForm' => (string) new EasyForex\Widget\ImageWidget(array('category' => 'city', 'width' => 200, 'height' => 344)),
		'containersContent' => '<h3>List of container IDs for content</h3>' . (string) new EasyForex\Widget\TextWidget(array('text' => print_r($template->getContainerIds(), true), 'tag' => 'pre')),
		'serializedConcent' => '<h3>Serialized template</h3>' . (string) new EasyForex\Widget\TextWidget(array('text' => $string, 'tag' => 'pre')),
		'unserializedConcent' => '<h3>Unserialized tmeplate</h3>' . (string) new EasyForex\Widget\TextWidget(array('text' => print_r($newTemplate, true), 'tag' => 'pre')),
	);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Demo page</title>

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<?php echo $template->render($pageConfig, 'bootstrap3'); ?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
</html>
