<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// all helper methods for assets

// formats $assets so that they are ready for view
function format_assets(&$assets)
{
	if (empty($assets))
		return $assets;

	// for every asset: truncate 'note' and create HTML for delete button
	foreach ($assets as &$asset) {
		$asset['note'] = truncate($asset['note']);
		$asset['deleteHTML'] = generate_asset_delete_html($asset['id']);
	}

	return $assets;
}

// truncates text so that it is at most length $length (including $omission)
// call on $asset['note']
function truncate($text, $length = 100, $omission = '...')
{
	if (empty($text))
		return '';
	
	$text_len = mb_strlen($text);
	if ($text_len > $length) {
		$text = mb_substr($text, 0, $length-mb_strlen($omission)).$omission;
	}

	return $text;
}

// generate the HTML for a button delete
function generate_asset_delete_html($id)
{
	$html = '<form action="'.site_url('asset/delete/'.$id).'" method="post">';
	$html .= '<button type="submit" value="delete">Delete</button>';
	$html .= '</form>';

	return $html;
}

// create a link to lookup assets by username
// display default username when not set
function view_asset_username(&$asset, &$users)
{
	// if no actual user_id associated, just display the default name (no link)
	if ($asset['user_id'] == 0)
		return $users['DEFAULT'];

	return anchor('user/view/'.$users[$asset['user_id']], $users[$asset['user_id']]);
}

// correctly display asset room
function view_asset_room(&$asset, &$rooms)
{
	if (is_null($asset['room_id']))
		return $rooms['DEFAULT'];
	
	return $rooms[$asset['room_id']];
}

// create the array for dropdown from array of all
function view_room_dropdown_from_all($rooms)
{
	unset($rooms['DEFAULT']);
	$rooms = array(0 => '', -1 => '(no room)') + $rooms;

	return $rooms;
}