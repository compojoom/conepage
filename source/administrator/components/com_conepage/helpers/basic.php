<?php
/**
 * @package    COnePage
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       30.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die ('Restricted access');

/**
 * Class CAdvancedSlideshowHelperBasic
 *
 * @since  1.0
 */
class COnePageHelperBasic
{
	private static $instance;

	/**
	 * Generates the footer
	 *
	 * @return  string
	 */
	public static function getFooter()
	{
		$footer = '<p style="text-align: center; margin-top: 15px;" class="copyright"> ';
		$footer .= 'COnePage - All in one page for <a href="http://joomla.org" target="_blank">Joomla!™</a>';
		$footer .= ' by <a href="https://compojoom.com">compojoom.com</a>';
		$footer .= '</p>';

		return $footer;
	}

	/**
	 * include the bootstrap css and js if necessary
	 *
	 * @return  void
	 */
	public static function bootstrap()
	{
		if (JVERSION < 3.0)
		{
			JHTML::_('stylesheet', 'media/com_conepage/css/bootstrap.css');
			JHTML::_('stylesheet', 'media/com_conepage/css/bootstrap25.css');
			JHTML::_('script', 'media/com_conepage/js/jquery.min.js');
			JHTML::_('script', 'media/com_conepage/js/bootstrap.min.js');
			JHTML::_('script', 'media/com_conepage/js/radiobtns.js');
			JHTML::_('script', 'media/com_conepage/js/bootstrap25.js');
		}

		// Always load the strapper css
		JHTML::_('stylesheet', 'media/com_conepage/css/strapper.css');
	}

	/**
	 * Logs the command
	 *
	 * @param   string  $command  - The command
	 * @param   string  $result   - The result
	 *
	 * @return  bool
	 *
	 * @throws  Exception
	 */
	public static function logExec($command, $result)
	{
		$date = JFactory::getDate()->toSql();
		$user = JFactory::getUser();

		$log = array("id" => null, "command" => $command, "result" => $result, "created" => $date, "user_id" => $user->id);

		$row = JTable::getInstance('Execsql', 'Table');

		if (!$row->bind($log))
		{
			throw new Exception($row->getError(), 42);
		}

		if (!$row->check())
		{
			throw new Exception($row->getError(), 42);
		}

		if (!$row->store())
		{
			throw new Exception($row->getError(), 42);
		}

		$row->checkin();

		return true;
	}
}
