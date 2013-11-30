<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die ('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
 * Class TableSettings
 *
 * @since  1.0
 */
class TableSettings extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   string  &$db  - The db
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__conepage_settings', 'id', $db);
	}
}
