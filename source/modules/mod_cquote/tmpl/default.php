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

JHtml::_('behavior.formvalidation');

$doc = JFactory::getDocument();

$doc->addScriptDeclaration('
	jQuery( document ).ready(function() {
		jQuery("#quote_send").click(function(){
			jQuery(this).attr("disabled", "disabled");
			jQuery.post("index.php?option=com_ajax&module=cquote&format=raw", jQuery("#cQuoteForm").serialize())
				.done(function( data ) {
					jQuery("#cquote_return").html(data);
				});
			return false;
		});
	});
');
?>
<form action="index.php?option=com_ajax&module=cquote&format=raw" id="cQuoteForm" name="cQuoteForm" class="form-validate form-horizontal">
<div id="cquote_return"></div>
<div id="cquote_<?php echo $module->id; ?>" class="cquote_holder">

	<div class="control-group">
		<label class="control-label" for="cname">Name</label>
		<div class="controls">
			<input type="text" id="cname" name="cname" placeholder="Your full name" class="required input-xlarge" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="company">Company</label>
		<div class="controls">
			<input type="text" id="company" name="company" placeholder="Company" class="input-xlarge" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="email">E-Mail</label>
		<div class="controls">
			<input type="text" id="email" name="email" placeholder="Email" class="required validate-email input-xlarge" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="phone">Phone</label>
		<div class="controls">
			<input type="text" id="phone" name="phone" placeholder="Include country code" class="input-xlarge" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="website">Website</label>
		<div class="controls">
			<input type="text" id="website" name="website" placeholder="compojoom.com" class="input-xlarge" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="budget">Budget</label>
		<div class="controls">
			<select name="budget" id="budget" class="input-xlarge">
				<option value="under 1000">Under 1000 Euro</option>
				<option value="1000 - 5000">1000 - 5000 Euro</option>
				<option value="5000 - 10000">5000 - 10000 Euro</option>
				<option value="10000 - 20000">10000 - 20000 Euro</option>
				<option value="20000 - 40000">20000 - 50000 Euro</option>
				<option value="50000+">50000+ EUR</option>
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="message">Message</label>
		<div class="controls">
			<textarea id="message" name="message" placeholder="Your message to us" rows="5" class="input-xlarge"></textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success" id="quote_send">Send</button>
		</div>
	</div>
</div>
</form>
