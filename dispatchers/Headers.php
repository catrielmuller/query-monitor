<?php
/*

© 2013 John Blackbourn

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

class QM_Output_Dispatcher_Headers extends QM_Output_Dispatcher {

	public $id = 'headers';

	public function __construct() {
		parent::__construct();
	}

	public function init( QM_Plugin $qm ) {

		if ( QM_Util::is_ajax() )
			ob_start();

	}

	public function after_output( QM_Plugin $qm ) {

		# flush once, because we're nice
		if ( ob_get_length() )
			ob_flush();

	}

	public function get_outputter( QM_Component $component ) {
		return new QM_Output_Headers( $component );
	}

	public function active( QM_Plugin $qm ) {

		if ( !$qm->show_query_monitor() ) {
			return false;
		}

		# if the headers have already been sent then we can't do anything about it
		return ( QM_Util::is_ajax() and !headers_sent() );
	}

}

function register_qm_dispatcher_headers( array $dispatchers ) {
	$dispatchers['headers'] = new QM_Output_Dispatcher_Headers;
	return $dispatchers;
}

add_filter( 'query_monitor_dispatchers', 'register_qm_dispatcher_headers' );
