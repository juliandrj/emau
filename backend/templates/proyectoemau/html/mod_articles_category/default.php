<?php defined('_JEXEC') or die;
$m = array();
foreach ($list as $e) {
	$a = new stdClass();
	$a->id = 'art-' . $e->id;
	$a->titulo = $e->title;
	$a->introtext = $e->introtext;
	$a->fulltext = $e->fulltext;
	$a->imgs = json_decode($e->images);
	$m[] = $a;
}
echo json_encode($m);
