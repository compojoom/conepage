<?php
/**
 * @package    COnePage
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       13.06.14
 *
 * @copyright  Copyright (C) 2008 - 2014 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

if (JVERSION >= 3)
{
	// Load JQuery & bootstrap for this module
	JHtml::_('bootstrap.framework');
}

// Module class
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
?>
<!-- START CQuote by compojoom.com  -->
<div class="cquoteegroup<?php echo $moduleclass_sfx ?>">
	<?php
	// Params for individual module template
	if ($params->get('template', 'default') == 'default')
	{
		include JModuleHelper::getLayoutPath('mod_cquote', 'default');
	}
	else
	{
		// Fall back to default template
		include JModuleHelper::getLayoutPath('mod_cquote', 'default');
	}
?>
</div>
<!-- END CQuote by compojoom.com  -->
