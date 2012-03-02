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
 */
class Plugin_mdv_forms extends Plugin
{
	/**
	 * Private Variables
	 */
	private $base_url;
	
	/**
	 * Plugin Constructor
	 */
	public function Plugin_mdv_forms()
	{
		$this->base_url = $this->parser->parse_string( '{pyro:url:site}', array(), TRUE );	
	}
	
	/**
	 * Reservation Form
	 *
	 * @return	HTML form
	 */
	public function reservation()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix' );
		$client_id = $this->attribute( 'client_id' );
		$lead_type = $this->attribute( 'lead_type' );
		$veh_id = $this->attribute( 'veh_id' );
		$veh_vin = $this->attribute( 'veh_vin' );
		$veh_price = $this->attribute( 'veh_price' );
		$vehicle = $this->attribute( 'vehicle' );
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/reservation" method="post" id="vehicle_contact'.$form_suffix.'">
		<table cellpadding="0" cellspacing="0">
		<tbody>
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="'.$client_id.'" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="'.$lead_type.'" />
			<input type="hidden" id="lms_veh_id'.$form_suffix.'" name="veh_id" value="'.$veh_id.'" />
			<input type="hidden" id="lms_veh_vin'.$form_suffix.'" name="veh_vin" value="'.$veh_vin.'" />
			<input type="hidden" id="lms_vehicle'.$form_suffix.'" name="vehicle" value="'.$vehicle.'" />
			<input type="hidden" id="lms_veh_price'.$form_suffix.'" name="veh_price" value="'.$veh_price.'" />
			<tr>
				<td>
					<label>Nombre:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_fname'.$form_suffix.'" name="fname" value="" />
				</td>
				<td>
					<label>Apellido:&nbsp;</label>
					<input type="text" class="" id="lms_lname'.$form_suffix.'" name="lname" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>N&uacute;mero Telef&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="jq_telephone" id="lms_telephone'.$form_suffix.'" name="telephone" value="" />
				</td>
				<td>
					<label>Correo Electr&oacute;nico:&nbsp;</label>
					<input type="text" class="" id="lms_email'.$form_suffix.'" name="email" value="" />
				</td>
			</tr>
			<tr >
				<td>
					<label>Veh&iacute;culo:&nbsp;</label>
					'.$vehicle.'
				</td>
				<td>
					<label>Precio del Veh&iacute;culo:&nbsp;</label>
					'.$veh_price.'
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<div class="jq_loader_circle_sml fl jq_hide" id="jq_reservation_loader'.$form_suffix.'"></div>
					<div class="btn_3 fl"><a href="#" id="jq_reservation_submit_btn'.$form_suffix.'">ENVIAR</a></div>
				</td>
				<td><label><span>*</span> = Requerido</label></td>
			</tr>
		</tbody>
		</table>
		</form>';
	
		// Output form HTML
		return $output;
	}
	
	/**
	 * Part Form
	 *
	 * @return	HTML form
	 */
	public function part()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix', '_frm_1' );
		$form_dealer_options = $this->_parsePyroVar( 'mdv_form_options', true );
		$forced_id = $this->attribute( 'forced_id', NULL );
		     if( $forced_id != NULL )
				 {
						$forced_id = explode( "|", $forced_id );
						$form_dealer_options = array( $forced_id[0] => $forced_id[1] );
				 }
		
		// Custom Inernal Vars
		$opt_count = count( $form_dealer_options );
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/part" method="post" id="part'.$form_suffix.'">
		<table cellpadding="0" cellspacing="0">
		<tbody>
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="parts" />
			<tr'.( ( $opt_count == 1 ) ? ' class="jq_hide"' : '' ).'>
				<td colspan="2">
					<h3>Informaci&oacute;n del Dealer</h3>
				</td>
			</tr>
			<tr class="alternate'.( ( $opt_count == 1 ) ? ' jq_hide' : '' ).'">
				<td>
					<label>Seleccione Dealer:&nbsp; <span>*</span></label>
					<select class="" id="lms_dealer'.$form_suffix.'" name="dealer_id">';
		
			// Add options
			foreach( $form_dealer_options as $o => $v )
			{
				$output .= 
		'				<option value="'.$v.'"'.( ( $opt_count == 1 ) ? ' selected="selected"' : '' ).'>'.$o.'</option>';
			}
		
		$output .=
		'			</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n del Veh&iacute;culo</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>A&ntilde;o:&nbsp; <span>*</span></label>
					<input type="text" class="sml" id="lms_year'.$form_suffix.'" name="year" value="" />
				</td>
				<td>
					<label>Marca:&nbsp; <span>*</span></label>
					<input type="text" class="sml" id="lms_make'.$form_suffix.'" name="make" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Modelo:&nbsp; <span>*</span></label>
					<input type="text" class="sml" id="lms_model'.$form_suffix.'" name="model" value="" />
				</td>
				<td>
					<label>Ajuste:&nbsp;</label>
					<input type="text" class="sml" id="lms_trim'.$form_suffix.'" name="trim" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n de Piezas</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Pieza para:&nbsp;</label>
					<select class="" id="lms_parts_for'.$form_suffix.'" name="parts_for">
						<option value="">Seleccionar</option>
						<option value="Interior">Interior</option>
						<option value="Exterior">Exterior</option>
						<option value="Mec&aacute;nica">Mec&aacute;nica</option>
						<option value="El&eacute;ctrica">El&eacute;ctrica</option>
					</select>
				</td>
				<td>
					<label>Urgencia:&nbsp;</label>
					<select class="" id="lms_urgency'.$form_suffix.'" name="urgency">
						<option value="">Seleccionar</option>
						<option value="Lo antes Posible">Lo antes Posible</option>
						<option value="Ma&ntilde;ana">Ma&ntilde;ana</option>
						<option value="En una semana">En una semana</option>
						<option value="Favor llamarme">Favor llamarme</option>
					</select>
				</td>
			</tr>
			<tr class="alternate">
				<td colspan="2">
					<label>Descripci&oacute;n:</label>
					<textarea class="med" id="lms_description'.$form_suffix.'" name="description"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n de Contacto</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Nombre:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_fname'.$form_suffix.'" name="fname" value="" />
				</td>
				<td>
					<label>Apellido:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_lname'.$form_suffix.'" name="lname" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>N&uacute;mero Telef&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="jq_telephone" id="lms_telephone'.$form_suffix.'" name="telephone" value="" />
				</td>
				<td>
					<label>Correo Electr&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_email'.$form_suffix.'" name="email" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<div class="jq_loader_circle_sml fl jq_hide" id="jq_part_loader'.$form_suffix.'"></div>
					<div class="btn_3 fl"><a href="#" id="jq_part_submit_btn'.$form_suffix.'">ENVIAR</a></div>
				</td>
				<td>
					<label><span>*</span> = Requerido</label>
				</td>
			</tr>
		</tbody>
		</table>
		</form>';
	
		// Output form HTML
		return $output;
	}
	
	/**
	 * Service Form
	 *
	 * @return	HTML form
	 */
	public function service()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix', ''.$form_suffix.'' );
		$form_dealer_options = $this->_parsePyroVar( 'mdv_form_options', true );
		$forced_id = $this->attribute( 'forced_id', NULL );
		     if( $forced_id != NULL )
				 {
						$forced_id = explode( "|", $forced_id );
						$form_dealer_options = array( $forced_id[0] => $forced_id[1] );
				 }
		
		// Custom Inernal Vars
		$opt_count = count( $form_dealer_options );
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/service" method="post" id="service'.$form_suffix.'">
		<table cellpadding="0" cellspacing="0">
		<tbody>
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="service_apt" />
			<tr'.( ( $opt_count == 1 ) ? ' class="jq_hide"' : '' ).'>
				<td colspan="2">
					<h3>Informaci&oacute;n del Dealer</h3>
				</td>
			</tr>
			<tr class="alternate'.( ( $opt_count == 1 ) ? ' jq_hide' : '' ).'">
				<td>
					<label>Seleccione Dealer:&nbsp; <span>*</span></label>
					<select class="" id="lms_dealer'.$form_suffix.'" name="dealer_id">';
		
			// Add options
			foreach( $form_dealer_options as $o => $v )
			{
				$output .= 
		'				<option value="'.$v.'"'.( ( $opt_count == 1 ) ? ' selected="selected"' : '' ).'>'.$o.'</option>';
			}
		
		$output .=
		'			</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n de Contacto</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Nombre:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_fname'.$form_suffix.'" name="fname" value="" />
				</td>
				<td>
					<label>Apellido:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_lname'.$form_suffix.'" name="lname" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>N&uacute;mero Telef&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="jq_telephone" id="lms_telephone'.$form_suffix.'" name="telephone" value="" />
				</td>
				<td>
					<label>Correo Electr&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_email'.$form_suffix.'" name="email" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n de Cita</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Fecha Preferida:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_preferred_date'.$form_suffix.'" name="preferred_date" value="" />
				</td>
				<td>
					<label>Hora Preferida:&nbsp;</label>
					<select class="" id="lms_preferred_time'.$form_suffix.'" name="preferred_time">
						<option value="">Seleccionar</option>
						<option value="8:00 AM">8:00 AM</option>
						<option value="9:00 AM">9:00 AM</option>
						<option value="10:00 AM">10:00 AM</option>
						<option value="11:00 AM">11:00 AM</option>
						<option value="12:00 PM">12:00 PM</option>
						<option value="1:00 PM">1:00 PM</option>
						<option value="2:00 PM">2:00 PM</option>
						<option value="3:00 PM">3:00 PM</option>
						<option value="4:00 PM">4:00 PM</option>
						<option value="5:00 PM">5:00 PM</option>
						<option value="6:00 PM">6:00 PM</option>
						<option value="7:00 PM">7:00 PM</option>
					</select>
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Tipo de Servicio:&nbsp;</label>
					<select class="" id="lms_service_type'.$form_suffix.'" name="service_type">
						<option value="">Seleccionar</option>
						<option value="Mantenimiento">Mantenimiento</option>
						<option value="Cambio de Aceite">Cambio de Aceite</option>
						<option value="Alineaci&oacute;n">Alineaci&oacute;n</option>
						<option value="Diagn&oacute;stico">Diagn&oacute;stico</option>
						<option value="Reclamo de Pieza/Veh&iacute;culo">Reclamo de Pieza/Veh&iacute;culo</option>
						<option value="Otro">Otro</option>
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n del Veh&iacute;culo</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Marca:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_make'.$form_suffix.'" name="make" value="" />
				</td>
				<td>
					<label>Modelo:&nbsp;</label>
					<input type="text" class="" id="lms_model'.$form_suffix.'" name="model" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>A&ntilde;o:&nbsp;</label>
					<input type="text" class="" id="lms_year'.$form_suffix.'" name="year" value="" />
				</td>
				<td>
					<label>Millaje:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_mileage'.$form_suffix.'" name="mileage" value="" />
				</td>
			</tr>
			<tr>
				<td>
					<div class="jq_loader_circle_sml fl jq_hide" id="jq_service_loader'.$form_suffix.'"></div>
					<div class="btn_3 fl"><a href="#" id="jq_service_submit_btn'.$form_suffix.'">ENVIAR</a></div>
				</td>
				<td>
					<label><span>*</span> = Requerido</label>
				</td>
			</tr>
		</tbody>
		</table>
		</form>';
	
		// Output form HTML
		return $output;
	}
	
	/**
	 * Contact Form
	 *
	 * @return	HTML form
	 */
	public function contact()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix', '_frm_1' );
		$id_position = $this->attribute( 'id_pos', 0 );
		
		
		// Custom Inernal Vars
		$mdv_ids = explode( ",", $this->_parsePyroVar( 'mdv_ids' ) );
		$redirect_client_id = $this->_parsePyroVar( 'redirect_client_id' );
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/contact" method="post" id="contact'.$form_suffix.'" class="jq_contact_form">
		<table cellpadding="0" cellspacing="0">
		<tbody>
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="'.( ( $redirect_client_id != '' ) ? $redirect_client_id : $mdv_ids[$id_position] ).'" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="contact" />
			<tr>
				<td>
					<label>Nombre:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_fname'.$form_suffix.'" name="fname" value="" />
				</td>
				<td>
					<label>Apellido:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_lname'.$form_suffix.'" name="lname" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>N&uacute;mero Telef&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="jq_telephone" id="lms_telephone'.$form_suffix.'" name="telephone" value="" />
				</td>
				<td>
					<label>Correo Electr&oacute;nico:&nbsp;</label>
					<input type="text" class="" id="lms_email'.$form_suffix.'" name="email" value="" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Asunto / Veh&iacute;culo que te interesa:&nbsp;</label>
					<input type="text" class="" id="lms_subject'.$form_suffix.'" name="subject" value="" />
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<label>Mensaje:</label>
					<textarea class="med" id="lms_message" name="message"></textarea>
				</td>
				<td></td>
			</tr>
			<tr class="alternate">
				<td>
					<div class="jq_loader_circle_sml fl jq_hide" id="jq_contact_loader'.$form_suffix.'"></div>
					<div class="btn_3 fl jq_contact_submit_btn"><a href="#contact'.$form_suffix.'">ENVIAR</a></div>
				</td>
				<td>
					<label><span>*</span> = Requerido</label>
				</td>
			</tr>
		</tbody>
		</table>
		</form>';
	
		// Output form HTML
		return $output;
	}
	
	/**
	 * Finance Form
	 *
	 * @return	HTML form
	 */
	public function finance()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix', '_frm_1' );
		$form_dealer_options = $this->_parsePyroVar( 'mdv_form_options', true );
		
		// Custom Inernal Vars
		$opt_count = count( $form_dealer_options );
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/finance" method="post" id="finance'.$form_suffix.'">
		<table cellpadding="0" cellspacing="0">
		<tbody>
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="credit" />
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n del Solicitante</h3>
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Nombre:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_fname'.$form_suffix.'" name="fname" value="" />
				</td>
				<td>
					<label>Apellido:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_lname'.$form_suffix.'" name="lname" value="" />
				</td>
			</tr>
			<tr>
				<td>
					<label>N&uacute;mero Telef&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="jq_telephone" id="lms_telephone'.$form_suffix.'" name="telephone" value="" />
				</td>
				<td>
					<label>Correo Electr&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_email'.$form_suffix.'" name="email" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Fecha de Nacimiento <span>*</span></label>
					<input type="text" class="tiny" id="lms_month'.$form_suffix.'" name="month" value="" />
					<input type="text" class="tiny" id="lms_day'.$form_suffix.'" name="day" value="" />
					<input type="text" class="tiny" id="lms_year'.$form_suffix.'" name="year" value="" />
				</td>
				<td>
					<label>Estado Civil:&nbsp; <span>*</span></label>
					<select class="" id="lms_civil_status'.$form_suffix.'" name="civil_status">
						<option value="">Seleccionar</option>
						<option value="Soltero(a)">Soltero(a)</option>
						<option value="Casado(a)">Casado(a)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n de Direcci&oacute;n</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Direcci&oacute;n:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_address'.$form_suffix.'" name="address" value="" />
				</td>
				<td>
					<label>Urbanizaci&oacute;n:&nbsp;</label>
					<input type="text" class="" id="lms_neighborhood'.$form_suffix.'" name="neighborhood" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Cuidad:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_city'.$form_suffix.'" name="city" value="" />
				</td>
				<td>
					<label>C&oacute;digo Postal:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_zip'.$form_suffix.'" name="zip" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n Financiera</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Tipo de Empleo:&nbsp; <span>*</span></label>
					<select class="" id="lms_employment_status'.$form_suffix.'" name="employment_status">
						<option value="">Seleccionar</option>
						<option value="Tiempo Completo">Tiempo Completo</option>
						<option value="Tiempo Parcial">Tiempo Parcial</option>
						<option value="Por Cuenta Propia">Por Cuenta Propia</option>
					</select>
				</td>
				<td>
					<label>Ingreso Mensual:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_monthly_income'.$form_suffix.'" name="monthly_income" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Residencia:&nbsp;</label>
					<select class="" id="lms_housing_status'.$form_suffix.'" name="housing_status">
						<option value="">Seleccionar</option>
						<option value="Alquiler">Alquiler</option>
						<option value="Propia">Propia</option>
						<option value="Familiar">Familiar</option>
					</select>
				</td>
				<td>
					<label>Pago de Residencia:&nbsp;</label>
					<input type="text" class="" id="lms_housing_payment'.$form_suffix.'" name="housing_payment" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Veh&iacute;culo de Inter&eacute;s</h3>
				</td>
			</tr>
			<tr class="alternate">
				<td'.( ( $opt_count == 1 ) ? ' class="jq_hide"' : '' ).'>
					<label>Seleccione Dealer:&nbsp; <span>*</span></label>
					<select class="" id="lms_dealer'.$form_suffix.'" name="dealer_id">';
		
			// Add options
			foreach( $form_dealer_options as $o => $v )
			{
				$output .= 
		'				<option value="'.$v.'"'.( ( $opt_count == 1 ) ? ' selected="selected"' : '' ).'>'.$o.'</option>';
			}
		
		$output .=
		'			</select>
				</td>
				<td>
					<label>Veh&iacute;culo que Busca:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_vehicle_interested'.$form_suffix.'" name="vehicle_interested" value="" />
				</td>
			</tr>
			<tr>
				<td>
					<div class="jq_loader_circle_sml fl jq_hide" id="jq_finance_loader'.$form_suffix.'"></div>
					<div class="btn_3 fl"><a href="#" id="jq_finance_submit_btn'.$form_suffix.'">ENVIAR</a></div>
				</td>
				<td>
					<label><span>*</span> = Requerido</label>
				</td>
			</tr>
		</tbody>
		</table>
		</form>';
	
		// Output form HTML
		return $output;
	}
	
	/**
	 * Trade-in Form
	 *
	 * @return	HTML form
	 */
	public function trade()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix', '_frm_1' );
		$form_dealer_options = $this->_parsePyroVar( 'mdv_form_options', true );
		$required_opt_fields = $this->attribute( 'req_opt_fields', false );
		$hide_required_fields = $this->attribute( 'hide_req_fields', false );
		$forced_id = $this->attribute( 'forced_id', NULL );
		     if( $forced_id != NULL )
				 {
						$forced_id = explode( "|", $forced_id );
						$form_dealer_options = array( $forced_id[0] => $forced_id[1] );
				 }
		
		// Parse params (if neccessary)
		$required_opt_fields = ( $required_opt_fields != false ) ? explode( ",", $required_opt_fields ) : false;
		$hide_required_fields = ( $hide_required_fields != false ) ? explode( ",", $hide_required_fields ) : false;
		
		// Custom Inernal Vars
		$opt_count = count( $form_dealer_options );
		
		// Set flags for possible optional requirements
		$is_email_req = ( is_array( $required_opt_fields ) && in_array( 'email', $hide_required_fields ) ) ? true : false;
		
		// Set flags for possible hidden requirements
		$is_vin_hidden = ( is_array( $hide_required_fields ) && in_array( 'vin', $hide_required_fields ) ) ? true : false;
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/trade" method="post" id="trade'.$form_suffix.'">
		<table cellpadding="0" cellspacing="0">
		<tbody>
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="trade_in" />
			<tr'.( ( $opt_count == 1 ) ? ' class="jq_hide"' : '' ).'>
				<td colspan="2">
					<h3>Informaci&oacute;n del Dealer</h3>
				</td>
			</tr>
			<tr class="alternate'.( ( $opt_count == 1 ) ? ' jq_hide' : '' ).'">
				<td>
					<label>Seleccione Dealer:&nbsp; <span>*</span></label>
					<select class="" id="lms_dealer'.$form_suffix.'" name="dealer_id">';
		
			// Add options
			foreach( $form_dealer_options as $o => $v )
			{
				$output .= 
		'				<option value="'.$v.'"'.( ( $opt_count == 1 ) ? ' selected="selected"' : '' ).'>'.$o.'</option>';
			}
		
		$output .=
		'			</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n del Cliente</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Nombre:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_fname'.$form_suffix.'" name="fname" value="" />
				</td>
				<td>
					<label>Apellido:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_lname'.$form_suffix.'" name="lname" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>N&uacute;mero Telef&oacute;nico:&nbsp; <span>*</span></label>
					<input type="text" class="jq_telephone" id="lms_telephone'.$form_suffix.'" name="telephone" value="" />
				</td>
				<td>
					<label>Correo Electr&oacute;nico:&nbsp;'.( ( $is_email_req ) ? ' <span>*</span>' : '' ).'</label>
					<input type="text" class="'.( ( $is_email_req ) ? 'jq_opt_req' : '' ).'" id="lms_email'.$form_suffix.'" name="email" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Informaci&oacute;n del Veh&iacute;culo</h3>
				</td>
			</tr>
			<tr>
				<td>
					<label>Marca:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_make'.$form_suffix.'" name="make" value="" />
				</td>
				<td>
					<label>Model:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_model'.$form_suffix.'" name="model" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>A&ntilde;o:&nbsp; <span>*</span></label>
					<input type="text" class="tiny" id="lms_year'.$form_suffix.'" name="year" value="" />
				</td>
				<td>
					<label>Millaje:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_mileage'.$form_suffix.'" name="mileage" value="" />
				</td>
			</tr>
			<tr>
				<td'.( ( $is_vin_hidden ) ? ' colspan="2"' : '' ).'>';
		
		// Hide vin
		if( $is_vin_hidden ):
			$output .=		
		'			<input type="hidden" class="" id="lms_vin'.$form_suffix.'" name="vin" value="mdvcms_opt_hide" />';
		else:
			$output .=		
		'			<label>N&uacute;mero de Chassis:&nbsp; <span>*</span></label>
					<input type="text" class="" id="lms_vin'.$form_suffix.'" name="vin" value="" />
				</td>
				<td>';
		endif;
			
		// Continue
		$output .=		
		'			<label>Condici&oacute;n:&nbsp; <span>*</span></label>
					<select class="" id="lms_condition'.$form_suffix.'" name="condition">
						<option value="">Seleccionar</option>
						<option value="Excelente">Excelente</option>
						<option value="Buena">Buena</option>
						<option value="Promedio">Promedio</option>
						<option value="Bajo Promedio">Bajo Promedio</option>
					</select>
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<label>Color Exterior:&nbsp;</label>
					<input type="text" class="" id="lms_color_exterior'.$form_suffix.'" name="color_exterior" value="" />
				</td>
				<td>
					<label>Color Interior:&nbsp;</label>
					<input type="text" class="" id="lms_color_interior'.$form_suffix.'" name="color_interior" value="" />
				</td>
			</tr>
			<tr class="alternate">
				<td>
					<div class="jq_loader_circle_sml fl jq_hide" id="jq_tradein_loader'.$form_suffix.'"></div>
					<div class="btn_3 fl"><a href="#" id="jq_trade_submit_btn'.$form_suffix.'">ENVIAR</a></div>
				</td>
				<td>
					<label><span>*</span> = Requerido</label>
				</td>
			</tr>
		</tbody>
		</table>
		</form>';
	
		// Output form HTML
		return $output;
	}
	
	/**
	 * Newsletter Form
	 *
	 * @return	HTML form
	 */
	public function newsletter()
	{
		// Save Attributes
		$form_suffix = $this->attribute( 'form_suffix', '_frm' );
		$client_id = $this->attribute( 'client_id', '' );
		
		// Form HTML Output
		$output =
		'<form action="lms_post_api/newsletter" method="post" id="newsletter'.$form_suffix.'">
			<input type="hidden" id="lms_client_id'.$form_suffix.'" name="cid" value="'.$client_id.'" />
			<input type="hidden" id="lms_lead_type'.$form_suffix.'" name="lead_type" value="newsletter" />
			<input type="text" id="lms_email'.$form_suffix.'" name="email" value="" />
			<div class="btn_footer"><a href="#" id="jq_newsletter_submit_btn'.$form_suffix.'">&#187;</a></div>
		</form>';
	
		// Output form HTML
		return ( $client_id != '' ) ? $output : '';
	}
	
	private function _parsePyroVar( $slug, $is_array = FALSE )
	{
		$raw = $this->parser->parse_string( '{pyro:variables:'.$slug.'}', array(), TRUE );
		
		if( $is_array )
		{
			$exploded_raw = explode( "|", $raw );
			$temp_arr = array();
			
			foreach( $exploded_raw as $v )
			{
				$v = explode( "=>", $v );
				$temp_arr[$v[0]] = $v[1];	
			}
			
			return $temp_arr;	
		}
		
		return $raw;
	}
}

/* End of file session.php */