<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<?php
	$options = array(
		'startOffset' => 0, // 0 starts on the first tab, 1 starts the second, etc$
		'useCookie' => true, // this must not be a string. Don't use quotes.
	);

	echo JHtml::_('tabs.start', $options);
	echo JHtml::_('tabs.panel', JText::_('COM_CADVANCEDSLIDESHOW_LAYOUT'), 'layout');

	?>
	<div class="col60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_CADVANCEDSLIDESHOW_LAYOUT'); ?></legend>

			<table class="admintable">
				<?php
				foreach ($this->items_layout as $value)
				{
					echo '<tr>';
					echo '<td class="key">';
					echo '<label for="' . $value->title . '" width="100" title="' . JText::_('COM_CADVANCEDSLIDESHOW_' . strtoupper($value->title) . '_DESC') . '">';
					echo JText::_('COM_CADVANCEDSLIDESHOW_' . strtoupper($value->title));
					echo '</label>';
					echo '</td>';

					echo '<td colspan="2">';

					switch ($value->type)
					{
						case 'textarea':
							echo CAdvancedSlideshowHelperSettings::getTextareaSettings($value->id, $value->title, $value->value);
							break;

						case 'select':
							echo CAdvancedSlideshowHelperSettings::getSelectSettings($value->id, $value->title, $value->value, $value->values);
							break;

						case 'text':
						default:
							echo CAdvancedSlideshowHelperSettings::getTextSettings($value->id, $value->title, $value->value);
							break;

					}

					echo '</td>';
					echo '</tr>';
				}
				?>
			</table>
		</fieldset>
	</div>
	<div class="clr"></div>
	<?php
	echo JHtml::_('tabs.panel', JText::_('COM_CADVANCEDSLIDESHOW_ADVANCED'), 'advanced');
	?>
	<div class="col60">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_CADVANCEDSLIDESHOW_ADVANCED'); ?></legend>

			<table class="admintable">
				<?php
				foreach ($this->items_advanced as $value)
				{
					echo '<tr>';
					echo '<td class="key">';
					echo '<label for="' . $value->title . '" width="100" title="' . JText::_('COM_CADVANCEDSLIDESHOW_' . strtoupper($value->title) . '_DESC') . '">';
					echo JText::_('COM_CADVANCEDSLIDESHOW_' . strtoupper($value->title));
					echo '</label>';
					echo '</td>';

					echo '<td colspan="2">';

					switch ($value->type)
					{
						case 'textarea':
							echo CAdvancedSlideshowHelperSettings::getTextareaSettings($value->id, $value->title, $value->value);
							break;

						case 'select':
							echo CAdvancedSlideshowHelperSettings::getSelectSettings($value->id, $value->title, $value->value, $value->values);
							break;

						case 'text':
						default:
							echo CAdvancedSlideshowHelperSettings::getTextSettings($value->id, $value->title, $value->value);
							break;

					}

					echo '</td>';
					echo '</tr>';
				}
				?>
			</table>
		</fieldset>
	</div>
	<div class="clr"></div>
	<?php
	echo JHtml::_('tabs.end');
	?>

	<input type="hidden" name="option" value="com_cadvancedslideshow"/>
	<input type="hidden" name="view" value="settings"/>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="controller" value="settings"/>

	<?php echo JHTML::_('form.token'); ?>
</form>

