<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$ObjectFactory = new ApiObjectFactory();
//print_r($list);
$articles = $ObjectFactory->BuildModArticlesCategory( $list );

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

print( json_encode( utf8ize($articles) ) );
?>

