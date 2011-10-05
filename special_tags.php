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
class Plugin_special_tags extends Plugin
{
	/**
	 * Private Variables
	 */
	private $base_url;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_special_tags()
	{
		$this->base_url = $this->parser->parse_string( '{pyro:url:site}', array(), TRUE );
	}
	
	/**
	 * Widget Area Fetcher
	 *
	 * @return	Decoded & Parsed HTML
	 */
	public function url()
	{
		// Save Attributes
		$href = $this->attribute( 'href', false );
		$onclick = $this->attribute( 'onclick', false );
		$target = $this->attribute( 'target', false );
		$title = $this->attribute( 'title', false );
		
		// Create script tag
		if( $href )
		{
			$url_html = '<a href="'.$href.'"';
				if( $onclick )
					$url_html .= ' onClick="'.$onclick.'"';
				if( $target )
					$url_html .= ' target="'.$target.'"';
				if( $title )
					$url_html .= ' title="'.$title.'"';
			$url_html .= '>';
			return $url_html;
		}
		
		// Default return
		return false;
	}
	
	public function img()
	{
		// Save Attributes
		$id = $this->attribute( 'id', false );
		$src = $this->attribute( 'src', false );
		$style = $this->attribute( 'style', false );
		$title = $this->attribute( 'title', false );
		$alt = $this->attribute( 'alt', false );
		
		// Create script tag
		if( $src )
		{
			$img_html = '<img src="'.$src.'"';
				if( $id )
					$img_html .= ' id="'.$id.'"';
				if( $style )
					$img_html .= ' style="'.$style.'"';
				if( $title )
					$img_html .= ' title="'.$title.'"';
				if( $alt )
					$img_html .= ' alt="'.$alt.'"';
			$img_html .= ' />';
			return $img_html;
		}
		
		// Default return
		return false;
	}
	
	public function div_open()
	{
		// Save Attributes
		$id = $this->attribute( 'id', false );
		$class = $this->attribute( 'class', false );
		$style = $this->attribute( 'style', false );
		$title = $this->attribute( 'title', false );
		$alt = $this->attribute( 'alt', false );
		
		// Create div open tag
		$div_html = '<div';
			if( $id )
				$div_html .= ' id="'.$id.'"';
			if( $class )
				$div_html .= ' class="'.$class.'"';
			if( $style )
				$div_html .= ' style="'.$style.'"';
			if( $title )
				$div_html .= ' title="'.$title.'"';
			if( $alt )
				$div_html .= ' alt="'.$alt.'"';
		$div_html .= '>';
		return $div_html;
	}
	
	public function div_close()
	{
		return "</div>";
	}
	
	public function script()
	{
		// Save Attributes
		$src = $this->attribute( 'src', false );
		
		// Create script tag
		if( $src != false )
		{
			return "<script src=\"".$src."\"></script>";	
		}
		
		// Default return
		return false;
	}
	
	public function script_open()
	{
		return "<script>";
	}
	
	public function script_close()
	{
		return "</script>";
	}
	
	public function header_tag()
	{
		// Save Attributes
		$number = $this->attribute( 'number', 1 );
		$text = $this->attribute( 'text', false );
		
		// Create script tag
		if( $text != false )
		{
			return "<h$number>".$text."</h$number>";	
		}
		
		// Default return
		return false;
	}
	
	public function literal()
	{
		// Save Attributes
		$text = $this->attribute( 'text', false );
		
		// Display text
		if( $text != false )
		{
			return $text;
		}
		
		// Default return
		return false;
	}
}

/* End of file session.php */