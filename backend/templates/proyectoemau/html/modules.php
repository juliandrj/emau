<?php
defined('_JEXEC') or die;

function modChrome_json($module, &$params, &$attribs) {
	$obj = new stdClass();
	$obj->titulo = $module->title;
	$obj->contenido = json_decode($module->content);
	$obj->modulo = $module->module;
	echo json_encode($obj);
}
