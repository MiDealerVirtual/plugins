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
 * Usage:	{pyro:inventory_fetcher:used limit="10"}
 *
 */
class Plugin_inventory_fetcher extends Plugin
{
	/**
	 * Private Variables
	 */
	private $mod_cms_vars;
	private $mdv_db;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_inventory_fetcher()
	{
		// Connect to MDV DB
		$this->mdv_db = $this->load->database( $this->config->item( 'mdvdb_creds' ), TRUE );
		
		// Fetch certain CMS vars 
		$this->mod_cms_vars = extractVars( varsToExtract() );
		
		// Extend CMS vars
		$this->mod_cms_vars['skip_stock_vehicles'] = parseStr( '{pyro:variables:skip_stock_vehicles}' );
	}
	
	/**
	 * Used Inventory Fetcher
	 *
	 * @return used car inventory
	 */
	public function used()
	{
		// Fetch Attributes
		$limit		= $this->attribute( 'limit', 10 );
		$only_html	= $this->attribute( 'only_html', false );
		$show_data	= $this->attribute( 'show_data', false );
		$skip_btn	= $this->attribute( 'skip_btn', false );
		
		// Prepare query
		$sql = "SELECT * FROM `vehicles_available_to_viewer_final` WHERE `CLIENT_ID` IN (".$this->mod_cms_vars['mdv_ids'].") AND `CONDITION` IN ('used', 'certified')";
		
			// Remove stock vehicles (if enabled)
			if( $this->mod_cms_vars['skip_stock_vehicles'] == 'yes' )
				$sql .= " AND `IOL_IMAGE` = '0'";
		
		// Finish query
		$sql .= " ORDER BY `VEH_ID` RANDOM LIMIT ".$limit;
		
		// Return Used vehicles
		$results = $this->mdv_db->query( $sql );
		$used_vehicles = $results->result_array();
		
		/* NO LONGER USED, DELETE ON NEXT PUSH
		// Return Used vehicles (all vehicles)
		$used_vehicles = $this->mdv_db
			->select( '*' )
			->where( '`CLIENT_ID` IN ('.$this->mod_cms_vars['mdv_ids'].')' )
			->where( '`CONDITION`', 'used' )
			->order_by( '`VEH_ID`', 'random' )
			->limit( $limit )
			->get( 'vehicles_available_to_viewer_final' )
			->result_array();*/
		
		// Loop and Add extra field
		$extended_used_vehicles = array();
		foreach( $used_vehicles as $v )
		{		
			// create vehicle link
			$v['VEH_URL'] = $this->mod_cms_vars['base_url']."inventario/".createVehiclePermaLink( $this->mod_cms_vars,
											  array( 'ci' => $v['CLIENT_ID'],
											  		 'mk' => $v['MAKE'],
													 'md' => $v['MODEL'],
													 'tr' => $v['TRIM'],
													 'yr' => $v['YEAR'],
													 'vn' => substr( $v['VIN'], ( strlen( $v['VIN'] ) - 3 ) )
											) );
											
			// create image thumb path
			$v['IMAGE_W_PATH'] = $this->config->item( 'images_base_url' ).( ( $v['IOL_IMAGE'] == 1 ) ? $this->config->item('iol_vehicle_pictures_thumb_path' ) : $this->config->item( 'vehicle_pictures_thumb_path' ) ).'thumb_'.$v['IMAGE'];
			
			// create seo alt label
			$v['SEO_VEH_LABEL'] = $v['MAKE']." ".$v['MODEL']." ".( ( $v['TRIM'] != "" ) ? $v['TRIM']." " : "" ).$v['YEAR']." &mdash; ".$this->mod_cms_vars['dealer_name'];
			
			// save extension
			array_push( $extended_used_vehicles, $v );
		}
		
		// Determine what to return
		if( $only_html )
		{
			$html_to_return = "";
			foreach( $extended_used_vehicles as $v )
			{
				// Href & Img
				$a_href = '<a href="'.$v['VEH_URL'].'" title="'.$v['SEO_VEH_LABEL'].'">';
				$img = '<img alt="'.$v['SEO_VEH_LABEL'].'" src="'.$v['IMAGE_W_PATH'].'" title="'.$v['SEO_VEH_LABEL'].'" />';
				
				// Determine if data (year mke and model) is showing
				if( $show_data )
				{
					$html_to_return .=
'<div class="box_result clearfix">
	<div class="thumbs">
		'.$a_href.$img.'</a>
	</div>
	<ul>
		<li class="title">'.$a_href.$v['MAKE'].' '.$v['MODEL'].'</a></li>
		<li class="year">'.$v['YEAR'].'</li>
	</ul>
</div>';
				}
				else
				{
					$html_to_return .=
'<div class="thumb">
	'.$a_href.$img.'</a>
</div>';
				}
			}
			
			// add see all button
			if( !$skip_btn )
			{
				$html_to_return .= 
				'<div class="btn_2"><a href="inventario?conditions=used" title="Veh&iacute;culos Usados en '.parseStr( '{pyro:variables:dealer_inc_name}' ).'"></a></div>';
			}
			
			// return html
			return $html_to_return;
		}
		
		return $extended_used_vehicles;
	}
	
	/**
	 * Similar Inventory Fetcher
	 *
	 * @return similar car inventory
	 */
	public function similar()
	{
		// Fetch Attributes
		$limit		= $this->attribute( 'limit', 10 );
		$veh_id		= $this->attribute( 'veh_id' );
		$v_make		= $this->attribute( 'make' );
		$v_model	= $this->attribute( 'model' );
		$v_type		= $this->attribute( 'type' );
		
		// Prepare query
		$sql = "SELECT * FROM `vehicles_available_to_viewer_final` WHERE `CLIENT_ID` IN (".$this->mod_cms_vars['mdv_ids'].") AND `VEH_ID` != ".$veh_id." AND `MAKE` LIKE '".$v_make."' AND `MODEL` LIKE '".$v_model."'";
		
			// Remove stock vehicles (if enabled)
			if( $this->mod_cms_vars['skip_stock_vehicles'] == 'yes' )
				$sql .= " AND `IOL_IMAGE` = '0'";
		
		// Finish query
		$sql .= " ORDER BY `VEH_ID` RANDOM LIMIT ".$limit;
		
		// Return Used vehicles
		$results = $this->mdv_db->query( $sql );
		$similar_vehicles = $results->result_array();
		
		/* NOT USED NO MORE, DELETE ON NEXT PUSH
		$similar_vehicles = $this->mdv_db
			->select( '*' )
			->where( '`CLIENT_ID` IN ('.$this->mod_cms_vars['mdv_ids'].')' )
			->where( '`VEH_ID` !=', $veh_id )
			->like( '`MAKE`', $v_make )
			->like( '`MODEL`', $v_model )
			->order_by( '`VEH_ID`', 'random' )
			->limit( $limit )
			->get( 'vehicles_available_to_viewer_final' )
			->result_array();*/
			
		// Check to see if limit has been met
		$curr_count = count( $similar_vehicles );
		if( $curr_count < $limit )
		{
			// Prepare query
			$sql = "SELECT * FROM `vehicles_available_to_viewer_final` WHERE `CLIENT_ID` IN (".$this->mod_cms_vars['mdv_ids'].") AND `VEH_ID` != ".$veh_id." AND `TYPE` LIKE '".$v_type."'";
			
				// Remove stock vehicles (if enabled)
				if( $this->mod_cms_vars['skip_stock_vehicles'] == 'yes' )
					$sql .= " AND `IOL_IMAGE` = '0'";
			
			// Finish query
			$sql .= " ORDER BY `VEH_ID` RANDOM LIMIT ".( $limit - $curr_count );
			
			// Return Used vehicles
			$results = $this->mdv_db->query( $sql );
			$similar_vehicles = array_merge( $similar_vehicles, $results->result_array() );

			/* NOT USED NO MORE, DELETE ON NEXT PUSH
			$similar_vehicles = array_merge( $similar_vehicles,
				$this->mdv_db
				->select( '*' )
				->where( '`CLIENT_ID` IN ('.$this->mod_cms_vars['mdv_ids'].')' )
				->where( '`VEH_ID` !=', $veh_id )
				->like( '`TYPE`', $v_type )
				->order_by( '`VEH_ID`', 'random' )
				->limit( ( $limit - $curr_count ) )
				->get( 'vehicles_available_to_viewer_final' )
				->result_array() );*/
		}
		
		// Loop and Add extra field
		$extended_similar_vehicles = array();
		foreach( $similar_vehicles as $v )
		{
			// create vehicle link
			$v['VEH_URL'] = $this->mod_cms_vars['base_url']."inventario/".createVehiclePermaLink( $this->mod_cms_vars,
											  array( 'ci' => $v['CLIENT_ID'],
											  		 'mk' => $v['MAKE'],
													 'md' => $v['MODEL'],
													 'tr' => $v['TRIM'],
													 'yr' => $v['YEAR'],
													 'vn' => substr( $v['VIN'], ( strlen( $v['VIN'] ) - 3 ) )
											) );
											
			// create image thumb path
			$v['IMAGE_W_PATH'] = $this->config->item( 'images_base_url' ).( ( $v['IOL_IMAGE'] == 1 ) ? $this->config->item('iol_vehicle_pictures_thumb_path' ) : $this->config->item( 'vehicle_pictures_thumb_path' ) ).'thumb_'.$v['IMAGE'];
			
			// create seo alt label
			$v['SEO_VEH_LABEL'] = $v['MAKE']." ".$v['MODEL']." ".( ( $v['TRIM'] != "" ) ? $v['TRIM']." " : "" ).$v['YEAR']." &mdash; ".$this->mod_cms_vars['dealer_name'];
			
			// save extension
			array_push( $extended_similar_vehicles, $v );
		}
		
		return $extended_similar_vehicles;
	}
}

/* End of file session.php */