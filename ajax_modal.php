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
// Pagination class
JLoader::import('joomla.html.pagination');
// Pagniation dependencies
JHtml::_('behavior.tooltip');

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
		// Form controls
		$option     = $this->app->input->get('plugin');
		$component  = $this->app->getUserStateFromRequest($option . '_filter_component', 'filter_component', 'content', 'string');
		$function   = $this->app->input->get('function', 'AjaxSelectItem');
		$limit      = $this->app->getUserStateFromRequest($option . '_limit', 'limit', $this->app->getCfg('list_limit'), 'int');
		$limitstart = $this->app->getUserStateFromRequest($option . '_limitstart', 'limitstart', 0, 'int');
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		// Supported components, used at plugins/ajax/ajax_modal/response.php:15
		$options = array(
			'content' => 'Content',
			'k2'      => 'K2',
			'zoo'     => 'Zoo'
		);

		// Create a new query objects
		$query      = $this->db->getQuery(true);
		$limitQuery = $this->db->getQuery(true);

		// Queried database fields
		$fields = array(
			'title',
			'access',
			'catid',
			'created',
			'id'
		);

		switch ($component)
		{
			case('content'):
				$query
					->select($this->db->quoteName($fields))
					->from($this->db->quoteName('#__content'))
					->where($this->db->quoteName('state') . ' = ' . $this->db->quote('1'));

				$limitQuery
					->select('COUNT(*)')
					->from($this->db->quoteName('#__content'))
					->where($this->db->quoteName('state') . ' = ' . $this->db->quote('1'));

				require_once JPATH_ROOT . '/components/com_content/helpers/route.php';
				break;

			case('k2'):
				$query
					->select($this->db->quoteName($fields))
					->from($this->db->quoteName('#__k2_items'));

				$limitQuery
					->select('COUNT(*)')
					->from($this->db->quoteName('#__k2_items'));

				break;

			case('zoo'):
				$query
					->select(array('name as title', 'application_id as catid', 'access', 'created', 'id'))
					->from($this->db->quoteName('#__zoo_item'));

				$limitQuery
					->select('COUNT(*)')
					->from($this->db->quoteName('#__zoo_item'));

				break;
		}

		$this->db->setQuery($query, $limitstart, $limit);
		$this->items = $this->db->loadObjectList();

		$this->db->setQuery($limitQuery);
		$total = $this->db->loadResult();

		$this->pagination = new JPagination($total, $limitstart, $limit);

		// Start output buffering
		ob_start();

		include JPATH_PLUGINS . '/ajax/ajax_modal/response.php';

		// Return output buffer
		return ob_get_clean();
	}
}
