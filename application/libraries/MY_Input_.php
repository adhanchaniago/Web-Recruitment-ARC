<?php
class MY_Input extends CI_Input {

	function save_query($query_array){
		$CI =& get_instance();
		$CI->db->insert('ci_query',array('query_string' => http_build_query($query_array)));
		return $CI->db->insert_id();	
		
	}

}