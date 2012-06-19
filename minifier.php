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
class Plugin_minifier extends Plugin
{
	/**
	 * Private Variables
	 */
	private $base_url;
	private $curr_theme;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_minifier()
	{
		// Fetch base url
		$this->base_url = parseStr( '{pyro:url:site}' );
		
		// Fetch current theme
		$this->curr_theme = parseStr( '{pyro:settings:default_theme}' );
	}
	
	/**
	 * Local theme files
	 */
	public function local_theme_files()
	{
		// Fetch attributes
		$css_files		= $this->attribute( 'css_files', false );
		$js_files		= $this->attribute( 'js_files', false );
	
		// Tags to return
		$tags_to_return = "";	
	
		// Prepare minified for css
		if( $css_files != false )
		{
			$tags_to_return .= '<link type="text/css" rel="stylesheet" href="'.$this->base_url."min/b=addons/default/themes/".$this->curr_theme."/css&f=".$css_files.'" />';
		}
		
		// Prepare minified for js
		if( $js_files != false )
		{
			$tags_to_return .= '<script type="text/javascript" src="'.$this->base_url."min/b=addons/default/themes/".$this->curr_theme."/js&f=".$js_files.'"></script>';
		}
		
		// Return
		if( strlen( $tags_to_return ) > 0 )
			return $tags_to_return;
	}
	
	/**
	 * Remote theme files
	 */
	public function remote_theme_files()
	{
		// Fetch attributes
		$css_files = $this->attribute( 'css_files', false );
		$js_files	= $this->attribute( 'js_files', false );
		$alt_dir = $this->attribute( 'alt_dir', false );
	
		// Tags to return
		$tags_to_return = "";	
	
		// Prepare minified for css
		if( $css_files != false )
		{
			$tags_to_return .= '<link type="text/css" rel="stylesheet" href="'.$this->config->item( 'perm_base_url' )."min/b=mdvcms_library/css&f=".$css_files.'" />';
		}
		
		// Prepare minified for js
		if( $js_files != false )
		{
			$tags_to_return .= '<script type="text/javascript" src="'.$this->config->item( 'perm_base_url' )."min/b=mdvcms_library/js&f=".$js_files.'"></script>';
		}
		
		// Return
		if( strlen( $tags_to_return ) > 0 )
			return $tags_to_return;
	}
}

/* End of file minifier.php */