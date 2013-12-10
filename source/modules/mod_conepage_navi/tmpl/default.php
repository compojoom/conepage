<?php
/**
 * @package    COnePage
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       30.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die;

$doc = JFactory::getDocument();

JHTML::_('stylesheet', 'media/mod_conepage_navi/css/navi.css');
JHTML::_('script', 'media/mod_conepage_navi/js/jquery.copnavi.js');

$doc->addScriptDeclaration('
	jQuery( document ).ready(function() {
		jQuery("#conepage_navi_ul_' . $module->id . '").copnavi({
			imgpath: "' . JUri::root() . 'media/mod_conepage_navi/images/"
		});
	});
');
?>
<div id="conepage_navi_<?php echo $module->id; ?>" class="conepage_navi_holder" role="navigation">
	<ul id="conepage_navi_ul_<?php echo $module->id; ?>" class="conepage_navi_ul nav nav-list about-list hidden-phone hidden-tablet" >

	</ul>
	<div style="clear:both"></div>
</div>
