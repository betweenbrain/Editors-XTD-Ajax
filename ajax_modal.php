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

	function onAjaxAjax_modal()
	{

		$response = "
		<!DOCTYPE html>
		<html>
		<head>
			<title></title>
		</head>
		<body>
		<h1>Hello Mom!</h1>
		</body>
		</html>";

		return $response;
	}
}
