<?php
/**
 * @package    CAdvancedSlideshow
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       20.09.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * Class ExecSQLModelSettings
 *
 * @since  1.0
 */
class COnePageModelSettings extends JModelLegacy
{
	public $_data = null;

	public $_id = null;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Loads the data
	 *
	 * @return  array|null
	 */
	public function getData()
	{
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query);
		}

		return $this->_data;
	}

	/**
	 * Checks if an element is checked out
	 *
	 * @param   int  $uid  - The uid
	 *
	 * @return bool
	 */
	public function isCheckedOut($uid = 0)
	{
		if ($this->_loadData())
		{
			if ($uid)
			{
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			}
			else
			{
				return $this->_data->checked_out;
			}
		}
	}

	/**
	 * Check the table in
	 *
	 * @return  bool
	 */
	public function checkin()
	{
		if ($this->_id)
		{
			$setts = & $this->getTable();

			if (!$setts->checkin($this->_id))
			{
				$this->setError($this->_db->getErrorMsg());

				return false;
			}
		}

		return false;
	}

	/**
	 * Checks out the element
	 *
	 * @param   int  $uid  - The uid
	 *
	 * @return  bool
	 */
	public function checkout($uid = null)
	{
		if ($this->_id)
		{
			if (is_null($uid))
			{
				$user =& JFactory::getUser();
				$uid = $user->get('id');
			}

			$hotspots = & $this->getTable();

			if (!$hotspots->checkout($uid, $this->_id))
			{
				$this->setError($this->_db->getErrorMsg());

				return false;
			}

			return true;
		}

		return false;
	}

	/**
	 * Stores the settings
	 *
	 * @param   object  $dataArray  - The data array
	 *
	 * @return bool
	 */
	public function store($dataArray)
	{
		$row =& $this->getTable('Settings', 'Table');

		if (!empty($dataArray))
		{
			foreach ($dataArray as $key => $value)
			{
				$data['id'] = $key;
				$data['value'] = $value;

				if (!$row->bind($data))
				{
					$this->setError($this->_db->getErrorMsg());

					return false;
				}

				if (!$row->check())
				{
					$this->setError($this->_db->getErrorMsg());

					return false;
				}

				if (!$row->store())
				{
					$this->setError($this->_db->getErrorMsg());

					return false;
				}
			}
		}

		return true;
	}


	/**
	 * Builds the query
	 *
	 * @return  string
	 */
	public function _buildQuery()
	{
		$query = ' SELECT st.*'
			. ' FROM #__conepage_settings AS st'
			. ' ORDER BY st.id';

		return $query;
	}
}
