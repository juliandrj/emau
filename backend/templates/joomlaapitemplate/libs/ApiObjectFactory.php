<?php

/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    Author: Fabio Buda
    Copyright: Netdesign 2015
    Package name: Joomla! Api Template
    Documentation: http://wiki.netd.it
*/

require_once 'Article.php';
require_once 'Menu.php';

require_once 'Category.php';
require_once 'Tag.php';

class ApiObjectFactory{

    function __construct(){
        header("X-API: Joomla API by Netdesign - www.netd.it");
    }

    public function BuildModArticlesCategory( $list ){
        $output = array();
        
        foreach( $list as $item ){
            $SingleArticle = new Article( $item );
            $SingleArticle->buildFullUrlByModArticlesCategory( $item );
            array_push( $output, $SingleArticle->item );
        }
        return $output;
    }

    public function BuildMenu( $list ){
        $Menu = new Menu( $list );
        return $Menu->menu;
    }

    public function BuildArticle( $item ){
        $article = new Article( $item );
        $article->buildFullUrl( $item );
        return $article;
    }
    
    public function BuildCategory( $category, $items, $pagination ){
        $category = new Category( $category, $items, $pagination );
        return $category;
    }
    
    public function BuildTag( $tag, $items, $pagination ){
        $tag = new Tag( $tag, $items, $pagination );
        return $tag;
    }
    
    public function BuildTagList( $list ){
        JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
        $tagList = array();
        foreach( $list as $item ){
            $item->urlfull = JUri::base();
            $item->urlfull .= JRoute::_(TagsHelperRoute::getTagRoute($item->tag_id . '-' . $item->alias));
            $item->apiurlfull = $item->urlfull."?template=api";
            array_push( $tagList, $item );
        }
        return $tagList;
    }

    public function BuildSearchResultList( $list = array() ){
        $output = array();
        foreach( $list as $item ){
            $article = new Article( $item );
            $article->buildFullUrlBySearch( $item );
            array_push($output, $article);
        }
        return $output;
    }

}
?>
