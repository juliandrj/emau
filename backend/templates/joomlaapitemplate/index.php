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
?>
<?php
     $isThisHomepage = JUri::getInstance()->toString() == JUri::base()."?template=api";
     
     $d = JFactory::getDocument();
     $d->setMimeEncoding('application/json');
     require_once dirname(__FILE__).'/libs/ApiObjectFactory.php';
?>
<?php
if( $isThisHomepage ){
?>
    {
      "latest": <jdoc:include type="modules" name="apilatest" />,
      "topmenu": <jdoc:include type="module" name="mod_menu" title="Menu Principale" />,
      "tagspopular": <jdoc:include type="module" name="mod_tags_popular" title="(API) Tag popolari Home" />
    }
<?php
} else {
?>
    {
        "content": <jdoc:include type="component" />
    }
<?php
}
?>
