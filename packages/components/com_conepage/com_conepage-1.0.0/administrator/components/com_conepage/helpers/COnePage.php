<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Class ExecSQLHelper
 *
 * @since  1.0
 */
abstract class COnePageHelper
{
	/**
	 * Loads the Submenu in cat table
	 *
	 * @param   object  $submenu  - The submenu
	 *
	 * @return void
	 */
	public static function addSubmenu($submenu)
	{
		$language = JFactory::getLanguage();
		$language->load('com_conepage.sys', JPATH_ADMINISTRATOR, null, true);

		$view = JFactory::getApplication()->input->get('task');

		$active2 = ($view == 'controlcenter');
		JSubMenuHelper::addEntry(JText::_('COM_CADVANCEDSLIDESHOW_CONTROLCENTER'), 'index.php?option=com_conepage&view=controlcenter', $active2);

		$subMenus = array(
			'slides' => 'COM_CADVANCEDSLIDESHOW_SLIDES',
			'categories' => 'COM_CADVANCEDSLIDESHOW_GALLERIES',
			'settings' => 'COM_CADVANCEDSLIDESHOW_CONFIGURATION',
			'information' => 'COM_CADVANCEDSLIDESHOW_INFORMATIONS',
			'help' => 'COM_CADVANCEDSLIDESHOW_HELP',
		);

		foreach ($subMenus as $key => $name)
		{
			$active = ($view == $key);

			if ($key == 'categories')
			{
				JSubMenuHelper::addEntry(JText::_($name), 'index.php?option=com_categories&extension=com_conepage', $active);
			}
			else
			{
				JSubMenuHelper::addEntry(JText::_($name), "index.php?option=com_conepage&view=" . $key, $active);
			}
		}

		$active = ($view == 'liveupdate');
		JSubMenuHelper::addEntry(JText::_('COM_CADVANCEDSLIDESHOW_LIVEUPDATE'), 'index.php?option=com_conepage&view=liveupdate', $active);

		$active3 = ($view == 'help');
		JSubMenuHelper::addEntry(JText::_('COM_CADVANCEDSLIDESHOW_HELP'), 'index.php?option=com_conepage&view=help', $active3);


		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-cadvancedslideshow ' .
		'{background-image: url(../media/com_conepage/backend/images/icon-48.png);}');


		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_CADVANCEDSLIDESHOW_GALLERIES'));
		}
	}
}
