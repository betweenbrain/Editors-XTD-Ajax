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

		$option    = $this->app->input->get('plugin');
		$function  = $this->app->input->get('function', 'AjaxSelectItem');
		$component = $this->app->getUserStateFromRequest($option . '_filter_component', 'filter_component', 'content', 'string');

		// Supported components, used at plugins/ajax/ajax_modal/response.php:15
		$options = array(
			'content' => 'Content',
			'k2'      => 'K2',
			'zoo'     => 'Zoo'
		);

		// Construct the query
		$query = $this->db->getQuery(true);

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
				$query->select($this->db->quoteName($fields))
					->from($this->db->quoteName('#__content'))
					->where($this->db->quoteName('state') . ' = ' . $this->db->quote('1'));

				require_once JPATH_ROOT . '/components/com_content/helpers/route.php';
				break;

			case('k2'):
				$query->select($this->db->quoteName($fields))
					->from($this->db->quoteName('#__k2_items'));
				break;

			case('zoo'):
				$query->select(array('name as title', 'application_id as catid', 'access', 'created', 'id'));
				$query->from($this->db->quoteName('#__zoo_item'));
				break;
		}

		$this->db->setQuery($query);
		$this->items = $this->db->loadObjectList();

		// Start output buffering
		ob_start();

		include JPATH_PLUGINS . '/ajax/ajax_modal/response.php';

		// Return output buffer
		return ob_get_clean();
	}
}
