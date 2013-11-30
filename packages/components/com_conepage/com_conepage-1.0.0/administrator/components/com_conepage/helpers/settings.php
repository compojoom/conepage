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

/**
 * Class COnePageHelperSettings
 *
 * @since  1.0
 */
class COnePageHelperSettings
{
	private static $instance;

	/**
	 * Default function for the settings
	 *
	 * @param   string  $title    - The settings key
	 * @param   string  $default  - The default value if none is in the db
	 *
	 * @return  mixed
	 */
	public static function _($title = '', $default = '')
	{
		return self::getSettings($title, $default);
	}

	/**
	 * Get Setting
	 *
	 * @param   string  $title    - The settings key
	 * @param   string  $default  - The default value if none is in the db
	 *
	 * @return ExecSQLHelperSettings
	 */
	public static function getSettings($title = '', $default = '')
	{
		if (!isset(self::$instance))
		{
			self::$instance = self::_loadSettings();
		}

		return self::$instance->get($title, $default);
	}

	/**
	 * Loads the settings
	 *
	 * @return JObject - loads a singleton object with all settings
	 */
	private static function _loadSettings()
	{
		$db = JFactory::getDBO();
		$settings = new JObject;

		$query = ' SELECT st.title, st.value'
			. ' FROM #__conepage_settings AS st'
			. ' ORDER BY st.id';

		$db->setQuery($query);
		$data = $db->loadObjectList();

		foreach ($data as $value)
		{
			$settings->set($value->title, $value->value);
		}

		// Grab the settings from the menu and merge them in the object
		$app = JFactory::getApplication();
		$menu = $app->getMenu();

		if (is_object($menu))
		{
			if ($item = $menu->getActive())
			{
				$menuParams = $menu->getParams($item->id);

				foreach ($menuParams->toArray() as $key => $value)
				{
					if ($key == 'show_page_heading')
					{
						$key = 'show_page_title';
					}

					$settings->set($key, $value);
				}
			}
		}

		return $settings;
	}


	/**
	 * Get the value for a field
	 *
	 * @param   string  $value  - The val
	 *
	 * @return string
	 */
	public static function getSettingField($value)
	{
		switch ($value->type)
		{
			case 'textarea':
				return self::getTextareaSettings($value->id, $value->title, $value->value);
				break;

			case 'select':
				return self::getSelectSettings($value->id, $value->title, $value->value, $value->values);
				break;

			case 'bool':
				return self::getBoolField($value->id, $value->title, $value->value);
				break;

			case 'text':
			default:
				return self::getTextSettings($value->id, $value->title, $value->value);
				break;
		}
	}


	public static function getTextareaSettings($id, $title, $value, $class = 'text_area', $rows = 8, $cols = 50, $style = 'width:300px')
	{
		return '<textarea class="' . $class . '" name="conepageset[' . $id . ']" id="conepageset[' . $id
		. ']" rows="' . $rows . '" cols="' . $cols . '" style="' . $style . '" title="' . JText::_('COM_CADVANCEDSLIDESHOW_'
		. $title . '_DESC') . '" />' . $value . '</textarea>';
	}


	/**
	 * Gets a boolean field
	 *
	 * @param   int     $id     - The id
	 * @param   string  $title  - The title
	 * @param   string  $value  - The value
	 * @param   string  $class  - The class
	 * @param   string  $style  - The style
	 *
	 * @return string
	 */

	public static function getBoolField($id, $title, $value, $class = 'bool', $style = "width: 30px;")
	{
		$valuesArray = self::getSettingsValues("{0=NO}{1=YES}");

		$select = '<select name="conepageset[' . $id . ']" id="conepageset[' . $id . ']" class="' . $class . '">' . "\n";

		foreach ($valuesArray as $valueOption)
		{
			if ($value == $valueOption['id'])
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}

			$text = strtoupper(str_replace(' ', '_', $valueOption['value']));
			$text = str_replace('(', '', $text);
			$text = str_replace(')', '', $text);
			$text = str_replace(':', '', $text);
			$text = str_replace('.', '', $text);
			$text = str_replace('-', '', $text);
			$text = str_replace('__', '_', $text);
			$select .= '<option value="' . $valueOption['id'] . '" ' . $selected . '>'
				. JText::_('COM_CADVANCEDSLIDESHOW_' . $text) . '</option>' . "\n";
		}

		$select .= '</select>' . "\n";

		return $select;
	}

	/**
	 * Gets a select field
	 *
	 * @param   int     $id         - The id
	 * @param   string  $title      - The title
	 * @param   string  $value      - The value
	 * @param   array   $values     - The possible values
	 * @param   string  $class      - The class
	 * @param   int     $size       - The size
	 * @param   int     $maxlength  - The size
	 * @param   string  $style      - The style
	 *
	 * @return string
	 */
	public static function getSelectSettings($id, $title, $value, $values, $class = 'inputbox', $size = 50, $maxlength = 255, $style = 'width:300px')
	{
		$valuesArray = self::getSettingsValues($values);

		$select = '<select name="conepageset[' . $id . ']" id="conepageset[' . $id . ']" class="' . $class . '">' . "\n";

		foreach ($valuesArray as $valueOption)
		{
			if ($value == $valueOption['id'])
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}

			$text = strtoupper(str_replace(' ', '_', $valueOption['value']));
			$text = str_replace('(', '', $text);
			$text = str_replace(')', '', $text);
			$text = str_replace(':', '', $text);
			$text = str_replace('.', '', $text);
			$text = str_replace('-', '', $text);
			$text = str_replace('__', '_', $text);
			$select .= '<option value="' . $valueOption['id'] . '" ' . $selected . '>' . JText::_('COM_CADVANCEDSLIDESHOW_' . $text) . '</option>' . "\n";
		}

		$select .= '</select>' . "\n";

		return $select;
	}

	/**
	 * Gets a text field
	 *
	 * @param   int     $id         - The id
	 * @param   string  $title      - The title
	 * @param   string  $value      - The value
	 * @param   string  $class      - The class
	 * @param   int     $size       - The size
	 * @param   int     $maxlength  - The size
	 * @param   string  $style      - The style
	 *
	 * @return string
	 */
	public static function getTextSettings($id, $title, $value, $class = 'text_area', $size = 50, $maxlength = 255, $style = 'width:300px')
	{
		return '<input class="' . $class . '" type="text" name="conepageset[' . $id . ']"
            id="conepageset[' . $id . ']" value="' . $value . '" size="' . $size . '"
            maxlength="' . $maxlength . '" style="' . $style . '" title="' .
		JText::_('COM_CADVANCEDSLIDESHOW_' . strtoupper($title) . '_DESC') . '" />';
	}


	/**
	 * Gets the values
	 *
	 * @param   object  $params  - The params
	 *
	 * @return mixed
	 */
	public static function getSettingsValues($params)
	{
		$regex_one = '/({\s*)(.*?)(})/si';
		$regex_all = '/{\s*.*?}/si';
		$matches = array();
		$count_matches = preg_match_all($regex_all, $params, $matches, PREG_OFFSET_CAPTURE | PREG_PATTERN_ORDER);

		$values = array();

		for ($i = 0; $i < $count_matches; $i++)
		{
			$conepage = $matches[0][$i][0];
			preg_match($regex_one, $conepage, $conepageParts);
			$values_replace = array("/^'/", "/'$/", "/^&#39;/", "/&#39;$/", "/<br \/>/");
			$values = explode("=", $conepageParts[2], 2);

			foreach ($values_replace as $key2 => $values2)
			{
				$values = preg_replace($values2, '', $values);
			}

			$returnValues[$i]['id'] = $values[0];
			$returnValues[$i]['value'] = $values[1];
		}

		return $returnValues;
	}
}
