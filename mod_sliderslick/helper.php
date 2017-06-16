<?php
/**
 * Helper class for slider slick! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://www.javimata.com
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class modItems
{

    public static function getItems( &$params )
    {

    	/*
    	 * Obtiene el tipo de fuente para el slider
    	 * 1 = Content ( items default de Joomla )
    	 * 2 = Banners ( Componente de banners nativo de Joomla )
    	 * 3 = Folder ( Obtiene las imagenes desde un folder especifico )
    	 * 4 = K2 ( Contenido desde componente K2 )
		*/
        $source       = $params->get("source",1);
        $sortby       = $params->get("sortby",'title ASC');
        $sortbyb      = $params->get("sortbyb",'name ASC');
        $slides_limit = $params->get("slides_limit",0);
        
        if ( $source == 1 ){
            // Source 1 - Articles ( Content )

            $category      = $params->get("source_content_category");

            ( $slides_limit > 0 ) ? $whereLimit = " LIMIT " . $slides_limit : $whereLimit = "";

            $where      = ' catid = ' . $category;
            $whereOrder = $sortby ;

            $db    = JFactory::getDBO();
            $query = 'SELECT * FROM #__content WHERE ' . $where . ' AND state=1 ORDER BY ' . $whereOrder . $whereLimit;
            $db->setQuery($query);
            $items = $db->loadObjectList();

        }elseif ( $source == 2 ){

            $category = $params->get("source_banners_category");

            ( $slides_limit > 0 ) ? $whereLimit = " LIMIT " . $slides_limit : $whereLimit = "";

            $where      = ' catid = ' . $category;
            $whereOrder = $sortbyb ;

            $db    = JFactory::getDBO();
            $query = 'SELECT *,name AS title FROM #__banners WHERE ' . $where . ' AND state=1 ORDER BY ' . $whereOrder . $whereLimit;
            $db->setQuery($query);
            $items = $db->loadObjectList();

        }elseif ( $source == 3 ){
            // Obtener archivos de carpeta


        }else {
            // No source selected


        }

        return $items;

    }

}