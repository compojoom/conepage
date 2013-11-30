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

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_cadvancedslideshow/tables');

JLoader::register('COnePageHelperSettings', JPATH_ADMINISTRATOR . '/components/com_conepage/helpers/settings.php');
JLoader::register('COnePageHelperBasic', JPATH_ADMINISTRATOR . '/components/com_conepage/helpers/basic.php');

require_once dirname(__FILE__) . '/helper.php';

// Get Bootstrap
COnePageHelperBasic::bootstrap();

if (JVERSION >= 3)
{
	// Load JQuery & bootstrap for this module
	JHtml::_('bootstrap.framework');
}

// Module class
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
?>
<!-- START COnePage by compojoom.com  -->
<div class="conepagegroup<?php echo $moduleclass_sfx ?>">
	<?php
	// Params for individual module template
	if ($params->get('template', 'default') == 'default')
	{
		include JModuleHelper::getLayoutPath('mod_conepage_navi', 'default');
	}
	else
	{
		// Fall back to default template
		include JModuleHelper::getLayoutPath('mod_conepage_navi', 'default');
	}
?>
</div>
<!-- END COnePage Navi by compojoom.com  -->
