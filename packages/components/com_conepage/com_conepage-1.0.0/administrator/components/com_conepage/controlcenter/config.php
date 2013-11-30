<?php
/**
 * ControlCenter
 * @package Joomla!
 * @Copyright (C) 2012 - Yves Hoppe - compojoom.com
 * @All rights reserved
 * @Joomla! is Free Software
 * @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
 * @version $Revision: 0.9.0 beta $
 **/

// Include tiles config
//require_once('');
defined('_JEXEC') or die();

class ControlCenterConfig {

    var $version                = "1.0.0 Alpha";
    var $copyright              = "Copyright (C) 2012 - 2014 Yves Hoppe - compojoom.com";
    var $license                = "GPL v2 or later";
    var $translation            = "English: compojoom.com";
    var $description            = "COM_EXECSQL_XML_DESCRIPTION";
    var $thankyou               = "";

    var $_extensionTitle        = "com_conepage";
    var $extensionPosition     = "execsql"; // e.G. ccc_extensionPostion_left

    var $_logopath              = '/media/com_conepage/backend/images/logo.png';

    public static function &getInstance()
    {
        static $instance = null;

        if(!is_object($instance)) {
            $instance = new ControlCenterConfig();
        }

        return $instance;
    }
}
