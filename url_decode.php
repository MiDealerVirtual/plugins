<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Inventory Plugin
 *
 * Fetch specific types of inventory
 *
 * @package		MDV_CMS
 * @author		MDV.com Dev Team
 * @copyright	Copyright (c) 2010 - 2011, MDV.com
 *
 * Usage:	{pyro:minifier:local_theme_files js_files="file.js,files2.js"}
 *
 */
class Plugin_url_decode extends Plugin
{
	/**
	 * Private Variables
	 */
	private $base_url;
	private $curr_url;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_url_decode()
	{
		// Fetch base url
		$this->base_url = parseStr( '{pyro:url:site}' );
		
		// Fetch current url
		$this->curr_url = parseStr( '{pyro:url:current}' );
	}
	
	/**
	 * Determine inventory url
	 */
	public function activate_current()
	{
		// save arguments
		$url		= $this->attribute( 'url', false );
		
		// extra variables needed
		$first_seg = parseStr( '{pyro:url:segments segment="1" default="false"}' );
		
		// eary return
		if( $url == $this->curr_url )
			return 'active';
		
		// check for `inventory` mode
		if( $first_seg == "inventario" && $url == $this->base_url.ltrim( $_SERVER['REQUEST_URI'], "/" ) )
			return 'active';
	}
}

/* End of file minifier.php */