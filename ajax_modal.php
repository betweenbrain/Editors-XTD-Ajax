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

		$options = array(
			'content' => 'Content',
			'k2'      => 'K2',
			'zoo'     => 'Zoo'
		);

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

			case('k2'):
				$query = $this->db->getQuery(true);
				$query
					->select('*')
					->from($this->db->quoteName('#__k2_items'));

				$this->db->setQuery($query);

				$this->items = $this->db->loadObjectList();

				break;
		}

		ob_start();

		include JPATH_PLUGINS . '/ajax/ajax_modal/response.php';

		return ob_get_clean();
	}
}
