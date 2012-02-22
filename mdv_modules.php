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
 * Usage:	{pyro:mdv_modules:quick_search limit="10"}
 *
 */
class Plugin_mdv_modules extends Plugin
{
	/**
	 * Private Variables
	 */
	private $mod_cms_vars;
	private $mdv_db;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_mdv_modules()
	{
		// Connect to MDV DB
		$this->mdv_db = $this->load->database( $this->config->item( 'mdvdb_creds' ), TRUE );
		
		// Fetch certain CMS vars 
		$this->mod_cms_vars = extractVars( varsToExtract() );
		
		// Extend CMS vars
		$this->mod_cms_vars['skip_stock_vehicles'] = parseStr( '{pyro:variables:skip_stock_vehicles}' );
		$this->mod_cms_vars['filtered_inventory_allowed'] = parseStr( '{pyro:variables:filtered_inventory_allowed}' );
	}
	
	/**
	 * Used Inventory Fetcher
	 *
	 * @return used car inventory
	 */
	public function quick_search()
	{
		// Fetch Attributes
		$return_html		= $this->attribute( 'return_html', true );
		
		// Prepare query
		$sql = "SELECT DISTINCT `MAKE` FROM `vehicles_available_to_viewer_final` WHERE `CLIENT_ID` IN (".$this->mod_cms_vars['mdv_ids'].")";
		
			// Restrict inventory (if enabled)
			if( $this->mod_cms_vars['filtered_inventory_allowed'] != '' )
				$sql .= " AND `CONDITION` IN (".$this->mod_cms_vars['filtered_inventory_allowed'].")";
		
		// Finish query
		$sql .= " ORDER BY `MAKE` ASC";
		
		// Return makes of vehicles
		$results = $this->mdv_db->query( $sql );
		$makes = $results->result_array();
		
		// Determine what to return
		if( $return_html )
		{
			$html_to_return = 
'<div class="box_quicksearch">
     <h2>Búsqueda Rápida</h2>
	<h3>'.$sql.'</h3>
     <ul>
     	<form action="'.parseStr( '{pyro:url:base}' ).'inventario" method="get" id="quick_search">
          <li>
			<select name="makes" id="jq_quick_search_make">
				<option value="">Marca</option>';
			
			foreach( $makes as $m )
				$html_to_return .= '<option value="'.$m['MAKE'].'">'.$m['MAKE'].'</option>';
			
			$html_to_return .=
'			</select>
		</li>
          <li>
			<select name="models" id="jq_quick_search_model" disabled="disabled">
				<option value="">Modelo</option>
			</select>
		</li>
          <li>
               <div class="btn_2">
                    <a href="inventario" title="Búsqueda Rápida" id="jq_quick_search_submit"><span>Buscar</span></a>
               </div>
          </li>
          </form>
     </ul>
</div>';
			
			// return html
			return $html_to_return;
		}
		
		// Return makes in array
		return $makes;
	}
}

/* End of file session.php */