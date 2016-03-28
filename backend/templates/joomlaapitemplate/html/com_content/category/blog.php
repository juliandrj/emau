<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/../../../libs/ApiObjectFactory.php';

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
/*$params = json_encode( $this->get('params') );
$pagination = $this->pagination->getPagesCounter();*/

/*unset($this->items);
unset($this->lead_items);
unset($this->intro_items);
unset($this->state);
unset($this->_models);
unset($this->user);
unset($this->parent);*/

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if( is_object($d) ){
        foreach ($d as $k => $v) {
            $d->$k = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

$pagination = $this->pagination;
$items = $this->items;
$ObjectFactory = new ApiObjectFactory();
$Category = $ObjectFactory->BuildCategory( $this, $items, $pagination );
//print_r($items[0]);
print( json_encode( utf8ize($Category) ) );
?>

