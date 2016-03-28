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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$ObjectFactory = new ApiObjectFactory();
$Article = $ObjectFactory->BuildArticle( $this->item );
print( json_encode($Article) );
?>

