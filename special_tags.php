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
	
	public function form()
	{
		// Save Attributes
		$id = $this->attribute( 'id', false );
		$name = $this->attribute( 'name', false );
		$class = $this->attribute( 'class', false );
		$method = $this->attribute( 'method', "post" );
		$action = $this->attribute( 'action', false );
		$open = $this->attribute( 'open', false );
		$close = $this->attribute( 'close', false );
		
		// Determine if opening form
		if( $open )
		{
			// Create output
			$output = "<form";
			
			// Display optional parameters
			if( $id != false )
				$output .= ' id="'.$id.'"';
			if( $name != false )
				$output .= ' name="'.$name.'"';
			if( $class != false )
				$output .= ' class="'.$class.'"';
			if( $action != false )
				$output .= ' action="'.$action.'"';
			$output .= ' method="'.$method.'"';
			
			// Close ouptut
			$output .= ">";
			
			// Return opening form
			return $output;
		}
		else if( $close )
		{
			return "</form>";	
		}
		else
			return false;
	}
	
	public function input()
	{
		// Save Attributes
		$type = $this->attribute( 'type', "text" );
		$id = $this->attribute( 'id', false );
		$name = $this->attribute( 'name', false );
		$class = $this->attribute( 'class', false );
		$value = $this->attribute( 'value', false );
		$disabled = $this->attribute( 'disabled', false );
		
		// Create output
		$output = "<input type=\"'".$type."\"";
		
		// Display optional parameters
		if( $id != false )
			$output .= ' id="'.$id.'"';
		if( $name != false )
			$output .= ' name="'.$name.'"';
		if( $class != false )
			$output .= ' class="'.$class.'"';
		if( $value != false )
			$output .= ' value="'.$value.'"';
		if( $disabled != false )
			$output .= ' disabled="disabled"';
		
		// Close output
		$output = " />";
		
		// Default return
		return $output;
	}
	
	public function select()
	{
		// Save Attributes
		$id = $this->attribute( 'id', false );
		$name = $this->attribute( 'name', false );
		$class = $this->attribute( 'class', false );
		$disabled = $this->attribute( 'disabled', false );
		$size = $this->attribute( 'size', false );
		$open = $this->attribute( 'open', false );
		$close = $this->attribute( 'close', false );
		
		// Determine if opening form
		if( $open )
		{
			// Create output
			$output = "<select";
			
			// Display optional parameters
			if( $id != false )
				$output .= ' id="'.$id.'"';
			if( $name != false )
				$output .= ' name="'.$name.'"';
			if( $class != false )
				$output .= ' class="'.$class.'"';
			if( $disabled != false )
				$output .= ' disabled="disabled"';
			if( $size != false )
				$output .= ' size="'.$size.'"';
			
			// Close ouptut
			$output .= ">";
			
			// Return opening form
			return $output;
		}
		else if( $close )
		{
			return "</select>";	
		}
		else
			return false;
	}
	
	public function select_option()
	{
		// Save Attributes
		$label = $this->attribute( 'label', false );
		$value = $this->attribute( 'value', false );
		$disabled = $this->attribute( 'disabled', false );
		$selected = $this->attribute( 'selected', false );
		
		// Create output
		$output = "<option";
		
		// Display optional parameters
		if( $value != false )
			$output .= ' value="'.$value.'"';
		if( $disabled != false )
			$output .= ' disabled="disabled"';
		if( $selected != false )
			$output .= ' selected="selected"';
		
		// Close output
		$output .= ">".$label."</option>";
		
		// Return opening form
		return $output;
	}
}

/* End of file session.php */