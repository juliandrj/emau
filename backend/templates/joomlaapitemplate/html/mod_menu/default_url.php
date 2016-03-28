<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class = $item->anchor_css ? 'class="'.$item->anchor_css.' ' : '';
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';

$isMainMenu = strpos($item->menutype, "mainmenu");

if ($item->menu_image && $isMainMenu !== false ) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = '<img src="'.$item->menu_image.'" title="'.$item->title.'"/><h3>'.$item->title.'</h3>' :
		//OR
		$linktype = '<img src="'.$item->menu_image.'" title="'.$item->title.'"/>';
} else if ($item->menu_image) {
        $linktype = '<img src="'.$item->menu_image.'" title="'.$item->title.'"/>'.$item->title;
}
else { $linktype = $item->title;
}
$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

if($item->parent){
    $class .= 'link-parent"';
}

switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $class; ?>href="<?php echo $flink; ?>" <?php echo $title; ?>><?php echo $linktype; ?></a><?php
		break;
	case 1:
		// _blank
?><a <?php echo $class; ?>href="<?php echo $flink; ?>" target="_blank" <?php echo $title; ?>><?php echo $linktype; ?></a><?php
		break;
	case 2:
		// window.open
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$params->get('window_open');
			?><a <?php echo $class; ?>href="<?php echo $flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;" <?php echo $title; ?>><?php echo $linktype; ?></a><?php
		break;
endswitch;
