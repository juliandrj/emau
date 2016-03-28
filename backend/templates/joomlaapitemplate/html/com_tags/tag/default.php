<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__).'/../../../libs/ApiObjectFactory.php';

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
//$n = count($this->items);
//$params = $this->params;
$items = $this->items;
$pagination = $this->pagination;

/* Set absolute HREF */
/*foreach( $items as $item ){
    $fullUrl = JRoute::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router));
    $item->core_full_url = $fullUrl;
}*/

$ObjectFactory = new ApiObjectFactory();
$Tag = $ObjectFactory->BuildTag( $this, $items, $pagination );

//print_r($this->get('params'));

print( json_encode( $Tag ) );

//print_r(get_class_vars($this));
//print_r($this->item);
//print_r($items);
?>
