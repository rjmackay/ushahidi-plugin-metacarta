<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Metacarta WMS Hook - Load All Events
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class metacarta {
	
	private $layers;
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{		
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		Event::add('ushahidi_filter.map_base_layers', array($this, '_add_layer'));
	}
	
	public function _add_layer()
	{
		$this->layers = Event::$data;
		$this->layers = $this->_create_layer();
		
		// Return layers object with new Cloudmade Layer
		Event::$data = $this->layers;
	}
	
	public function _create_layer()
	{
			
			// WMS basic world map
			$layer = new stdClass();
			$layer->active = TRUE;
			$layer->name = 'metacarta_basic';
			$layer->openlayers = "WMS";
			$layer->title = 'Metacarta Basic';
			$layer->description = 'Basic world map layer from Metacarta';
			$layer->api_url = '';
			$layer->data = array(
				'baselayer' => TRUE,
				'attribution' => '',
				'url' => 'http://labs.metacarta.com/wms/vmap0',
				'type' => ''
			);
			$layer->wms_params = array(
				'format' => 'image/png',
				'layers' => 'basic',
				'tiled' => TRUE
			);
			$this->layers[$layer->name] = $layer;
		
		return $this->layers;
	}
}

new metacarta;