<?php defined('_JEXEC') or die;

/**
 * File       response.php
 * Created    3/27/14 8:46 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="templates/isis/css/template.css" type="text/css">
	<script src="/dev/joomla/3.3-dev/media/jui/js/jquery.min.js" type="text/javascript"></script>
	<script src="/dev/joomla/3.3-dev/media/jui/js/jquery-noconflict.js" type="text/javascript"></script>
	<script src="/dev/joomla/3.3-dev/media/jui/js/jquery-migrate.min.js" type="text/javascript"></script>
	<script type="text/javascript">

	</script>
	<!--[if lt IE 9]>
	<script src="../media/jui/js/html5.js"></script>
	<![endif]-->
</head>
<body>

<form action="<?php echo JRoute::_('index.php?option=com_ajax&plugin=ajax_modal&format=raw&function=AjaxSelectItem') ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<fieldset class="filter clearfix">
		<div class="filters pull-left">
			<select name="component" class="input-medium" onchange="this.form.submit()">
				<option value="">-- Component --</option>
				<option value="content">Content</option>
				<option value="k2">K2</option>
				<option value="zoo">Zoo</option>
			</select>
		</div>
	</fieldset>
	<table class="table table-striped table-condensed">
		<thead>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<a href="javascript:void(0)" onclick="if (window.parent) window.parent.<?php echo htmlspecialchars($function); ?>('<?php echo $item->id; ?>', '<?php echo $component; ?>');">
						<?php echo htmlspecialchars($item->title); ?></a>
				</td>
				<td class="center">
					<?php echo htmlspecialchars($item->access); ?>
				</td>
				<td class="center">
					<?php echo htmlspecialchars($item->catid); ?>
				</td>
				<td class="center">
					<?php if ($item->language == '*'): ?>
						<?php echo JText::alt('JALL', 'language'); ?>
					<?php else: ?>
						<?php echo $item->language_title ? htmlspecialchars($item->language_title) : JText::_('JUNDEFINED'); ?>
					<?php endif; ?>
				</td>
				<td class="center nowrap">
					<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4')); ?>
				</td>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</form>
</body>
</html>