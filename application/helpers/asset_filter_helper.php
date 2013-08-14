<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// all helper methods for assets

// formats $assets so that they are ready for view
function is_whole_number($var)
{
	return is_numeric($var) && (intval($var) == floatval($var));
}