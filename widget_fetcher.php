<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * MDV Forms Plugin
 *
 * Insert froms anywhere
 *
 * @package		MDV_CMS
 * @author		MDV.com Dev Team
 * @copyright	Copyright (c) 2010 - 2011, MDV.com
 *
 * Usage:	{pyro:widget_fetcher:area slug="area_slug_here"}
 *
 */
class Plugin_widget_fetcher extends Plugin
{
	/**
	 * Private Variables
	 */
	private $base_url;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_widget_fetcher()
	{
		$this->base_url = $this->parser->parse_string( '{pyro:url:site}', array(), TRUE );
	}
	
	/**
	 * Widget Area Fetcher
	 *
	 * @return	Decoded & Parsed HTML
	 */
	public function area()
	{
		// Save Attributes
		$area_slug = $this->attribute( 'slug', false );
		
		// Fetch Widget Area
		if( $area_slug != false )
		{
			// Extract area
			$widget_area = $this->parser->parse_string( '{pyro:widgets:area slug="'.$area_slug.'"}', array(), TRUE );
			
			// Clean up beginning
			$widget_area = substr( $widget_area, ( strpos( $widget_area, "</h3>" ) + strlen( "</h3>" ) ) );
			
			// Clean up ending
			$widget_area = substr( $widget_area, 0, strrpos( $widget_area, '<div class="divider"></div>' ) );
			
			// Clean up in between
			$area_parts = array();
			$widget_area = explode( '<div class="widget html">', $widget_area );
			foreach( $widget_area as $part )
			{
				if( strpos( $part, "<h3>" ) != FALSE )
					$part = substr( $part, ( strpos( $part, "</h3>" ) + strlen( "</h3>" ) ) );
				
				if( strpos( $part, '<div class="divider"></div>' ) != FALSE )
					$part = substr( $part, 0, strpos( $part, '<div class="divider"></div>' ) );
				
				// re-parse part if neccesary
				if( strpos( $part, "{pyro:" ) != false )
					$part = $this->parser->parse_string( $part, array(), TRUE );
				
				array_push( $area_parts, $part );
			}
	
			// Output Widget Area Cleaned up and Filtered
			return htmlspecialchars_decode( implode( "", $area_parts ) );
		}
		
		// Default return
		return "";
	}
	
	/**
	 * Widget Instance Fetcher
	 *
	 * @return	Decoded & Parsed HTML
	 */
	public function instance()
	{
		// Save Attributes
		$instance_id = $this->attribute( 'id', false );
		
		// Fetch Widget Area
		if( $instance_id != false )
		{
			// Extract area
			$widget_instance = $this->parser->parse_string( '{pyro:widgets:instance id="'.$instance_id.'"}', array(), TRUE );
	
			// Output Widget Area Cleaned up and Filtered
			return htmlspecialchars_decode( $widget_instance );
		}
		
		// Default return
		return "";
	}
	 
}

/* End of file session.php */