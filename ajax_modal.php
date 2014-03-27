<?php defined('_JEXEC') or die;

/**
 * File       ajax_modal.php
 * Created    3/27/14 2:27 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */

// Import library dependencies
jimport('joomla.plugin.plugin');

class plgAjaxAjax_modal extends JPlugin
{

	/**
	 * Constructor.
	 *
	 * @param   object &$subject The object to observe
	 * @param   array  $config   An optional associative array of configuration settings.
	 *
	 * @since   0.1
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$this->app = JFactory::getApplication();
		$this->db  = JFactory::getDbo();

	}

	function onAjaxAjax_modal()
	{

		$function  = $this->app->input->getCmd('function', 'jSelectArticle');
		$component = $this->app->input->getCmd('component', 'content');

		switch ($component)
		{
			case('content'):
				$query = $this->db->getQuery(true);
				$query
					->select('*')
					->from($this->db->quoteName('#__content'))
					->where($this->db->quoteName('state') . ' = ' . $this->db->quote('1'));

				$this->db->setQuery($query);

				$this->items = $this->db->loadObjectList();

				require_once JPATH_ROOT . '/components/com_content/helpers/route.php';

				break;
		}

		ob_start(); ?>

		<!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<body>
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
		</body>
		</html>

		<?php return ob_get_clean();
	}
}
