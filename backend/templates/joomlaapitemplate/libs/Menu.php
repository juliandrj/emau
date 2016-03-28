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

class Menu{

    public $menu = array();

    private $ItemToUnset = array(
        "menutype",
        "alias",
        "note",
        "route",
        "link",
        "params",
        "home",
        "template_style_id",
        "component_id",
        "component",
        "tree",
        "query",
        "deeper",
        "shallower",
        "level_diff"
    );

    function __construct( $list ){
        $menu = array();
        foreach( $list as $item ){
            foreach( $this->ItemToUnset as $ToUnset ){
                unset( $item->{$ToUnset} );
            }
            $item->urlfull = JUri::base().$item->flink;
            $item->apiurlfull = $item->urlfull."?template=api";
            array_push( $menu, $item );
        }
        $this->menu = $menu;
    }


}

?>
