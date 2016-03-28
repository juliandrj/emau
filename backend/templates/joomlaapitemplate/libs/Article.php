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

require_once 'Tag.php';

class Urls{

    public $output = array();

    function __construct( $jsonUrls ){
        $output = array();
        $urls = json_decode( $jsonUrls );
        if( $urls->urla != "" ){
            $a = array("url"=>$urls->urla,
                       "text"=>$urls->urlatext,
                       "target"=>$urls->targeta);
            array_push( $output, $a );
        }
        if( $urls->urlb != "" ){
            $b = array("url"=>$urls->urlb,
                       "text"=>$urls->urlbtext,
                       "target"=>$urls->targetb);
            array_push( $output, $b  );
        }
        if( $urls->urlc != "" ){
            $c = array("url"=>$urls->urlc,
                       "text"=>$urls->urlctext,
                       "target"=>$urls->targetc);
            array_push( $output, $c );
        }
        $this->output = $output;
    }
}

class Article{

    public $item = false;

    private $ToUnset = array(
        "author",
        "author_email",
        "created_by",
        "created_by_alias",
        "checked_out",
        "checked_out_time",
        "modified",
        "modified_by",
        "modified_by_name",
        "publish_up",
        "publish_down",
        "attribs",
        "metadata",
        "params",
        "tagLayout",
        "event"
    );

    function __construct( $item ){
        foreach( $this->ToUnset as $ToUnset ){
            if( array_key_exists( $ToUnset, $item ) ){
                unset( $item->{$ToUnset} );
            }
        }
        $item->tags = $this->cleanTags( $item->tags->itemTags );
        $item->urls = $this->cleanUrls( $item->urls );
        if( property_exists( $item, "images" )  ){
            $item->images = $this->cleanImages( $item->images );
        } else if( property_exists( $item, "core_images"  )  ){
            $item->images = $this->cleanImages( $item->core_images ); 
        }
        
        //print_r($item);
        $item = $this->fillCategoryAliasIfUnset( $item );
        
        $item->urlfull = JUri::base().$item->link."?template=api";

        $item->plain_text = strip_tags( $item->text );
        $item->plain_intro_text = strip_tags( $item->introtext );
        
        if( $item->plain_text != "" ){
            $item->plain_light_text = substr( $item->plain_text, 0, 100 )."...";
        } else {
            $item->plain_light_text = substr( $item->plain_intro_text, 0, 100 )."...";
        }
        
        $this->item = $item;
    }
    
    function fillCategoryAliasIfUnset( $item ){
        // Joomla 3 non restituisce category_alias
        // quando accedi da una lista di articoli
        // in tag, valorizza dunque il campo che
        // è fondamentale ottenendolo direttamente dal DB
        if( !property_exists( $item, "category_alias" ) ){
            $thisCategory =& JTable::getInstance('category');
            $thisCategory->load( $item->core_catid );
            $item->category_alias = $thisCategory->alias;
        }
        return $item;
    }
    
    function cleanTags( $tagList ){
        $out = array();
        foreach( $tagList as $tag ){
            $t = new Tag($tag);
            array_push( $out, $t->tag );
        }
        return $out;
    }
    
    function cleanUrls( $urlJson ){
        $urls = new Urls( $urlJson );
        return $urls->output;
    }
    
    function cleanImages( $imagesJson ){
        $img = json_decode( $imagesJson );
        if( $img->image_intro == "" ){
            $img->image_intro = JUri::base()."images/default.png";
        } else {
            $img->image_intro = JUri::base().$img->image_intro;
        }
        $img->image_fulltext = JUri::base().$img->image_fulltext;
        return $img;
    }
    
    function buildFullUrl( $item ){
        if( property_exists($item, "link") ){
            $this->buildFullUrlByModArticlesCategory( $item );
        } else if( property_exists($item, "slug") &&
            property_exists($item, "catid") &&
            property_exists($item, "language")){
            $this->buildFullUrlByCategory( $item );
        } else if( property_exists($item, "href") ){
            $this->buildFullUrlBySearch( $item );
        } else if( property_exists($item, "content_item_id") &&
                   property_exists($item, "core_alias") &&
                   property_exists($item, "core_catid") &&
                   property_exists($item, "core_language") &&
                   property_exists($item, "type_alias") &&
                   property_exists($item, "router") ){
            $this->buildFullUrlByTag( $item );
        }
    }
    
    function buildFullUrlByCategory( $item ){
        $this->item->urlfull = JUri::base().ltrim( JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)), "/" );
        $this->item->apiurlfull = $this->item->urlfull."?template=api";
    }
    
    function buildFullUrlBySearch( $item ){
        $this->item->urlfull = JUri::base().JRoute::_($item->href);
        $this->item->apiurlfull = $this->item->urlfull."?template=api";
    }

    function buildFullUrlByModArticlesCategory( $item ){
        $this->item->urlfull = JUri::base().ltrim( JRoute::_($item->link), "/" );
        $this->item->apiurlfull = $this->item->urlfull."?template=api";
    }
    
    function buildFullUrlByTag( $item ){
        $this->item->urlfull = JUri::base().ltrim( JRoute::_(TagsHelperRoute::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)), "/" );
        $this->item->apiurlfull = $this->item->urlfull."?template=api";
    }

}

?>
