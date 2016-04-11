<?php
defined('_JEXEC') or die;
jimport( 'joomla.application.module.helper' );

$app = JFactory::getApplication();
$doc =& JFactory::getDocument();
$doc->setMimeEncoding('application/json');
$json = new stdClass();
$json->titulo = $app->get('sitename');
$json->descripcion = $app->get('MetaDesc');
$modulos = array();
$mods = JModuleHelper::getModules('contenido');
$attribs['style'] = 'json';
foreach ($mods as $mod) {
	$m = new stdClass();
	$m->id = 'mod_' . $mod->id;
	$m->titulo = $mod->title;
	$m->contenido = json_decode(JModuleHelper::renderModule($mod, $attribs));
	$m->modulo = $mod->module;
	$modulos[] = $m;
}
$json->modulos = $modulos;
$mods = JModuleHelper::getModules('footer');
if (count($mods) > 0) {
	$json->pie = $mods[0]->content;
}
echo json_encode($json);