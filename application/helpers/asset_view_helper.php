<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// all helper methods for assets

// formats $assets so that they are ready for view
function format_assets($assets)
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