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

class Tag{

    public $tag = false;
    public $pagination = false;
    public $articles = false;

    /*
        fabiobuda@netd.it - 03-04-2015
        Le classi Article e Menu possiedono
        la lista $ToUnset o $ItemToUnset per
        "pulire" i dati provenienti da Joomla.
        
        In realtà per una Tag/Category sono più i dati
        da eliminare che quelli da prendere, per questo
        motivo si decide di usare $ToGet al posto di
        $ToUnset ;)
    */
    //private $ToUnset = array(
    //);
    private $ToGet = array(
        "alias",
        "id",
        "path",
        "title",
        "note",
        "description",
        "published"
    );

    function __construct( $Tag, $Items = array(), $Pagination = array() ){
        $flatObject = json_decode( json_encode( $Tag ), true );
        if( array_key_exists( 'document', $flatObject ) ){
            $params = $flatObject['document'];
        } else {
            $params = array();
        }
        $Pagination = json_decode( json_encode( $Pagination ), true );

        foreach( $params as $param=>$value ){
            if( !in_array( $param, $this->ToGet ) ){
                unset( $params[ $param ] );
            }
        }
        //print_r(json_decode( json_encode( $Tag ), true ));
        
        $TEMP_Items = array();
        foreach( $Items as $Item ){
            $article = new Article( $Item );
            $article->buildFullUrlByTag( $Item );
            array_push( $TEMP_Items, $article->item );
        }
        
        unset($this->ToGet);
        $this->tag = $params;
        $this->pagination = $Pagination;
        $this->articles = $TEMP_Items;
    }

}

?>
