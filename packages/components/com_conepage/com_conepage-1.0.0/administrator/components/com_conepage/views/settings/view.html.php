<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die();
jimport('joomla.application.component.view');

/**
 * Class   ExecSQLViewSettings
 *
 * @since  1.0
 */
class ExecSQLViewSettings extends JViewLegacy
{
	/**
	 * Displays the form
	 *
	 * @param   string  $tpl  - The tmpl
	 *
	 * @return mixed|void
	 */

	public function display($tpl = null)
	{
		$uri = JFactory::getURI();

		JToolBarHelper::title(JText::_('COM_EXECSQL_SETTINGS'), 'config');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel('cancel', 'Close');
		JToolBarHelper::help('screen.execsql', true);

		$items = $this->get('Data');

		for ($i = 0; $i < count($items); $i++)
		{
			$item = $items[$i];


			if ($item->catdisp == "basic")
			{
				$items_basic[$item->id] = $item;
			}

			if ($item->catdisp == "advanced")
			{
				$items_advanced[$item->id] = $item;
			}
		}

		$this->items = $items;
		$this->items_basic = $items_basic;
		$this->items_advanced = $items_advanced;

		parent::display($tpl);
	}
}
