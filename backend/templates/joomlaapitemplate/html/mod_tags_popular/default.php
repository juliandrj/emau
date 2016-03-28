<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_popular
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$ObjectFactory = new ApiObjectFactory();

//$menuItems = $ObjectFactory->BuildMenu( $list );
//print( json_encode($menuItems) );
$tagList = $ObjectFactory->BuildTagList( $list );
print( json_encode($tagList) );
?>
