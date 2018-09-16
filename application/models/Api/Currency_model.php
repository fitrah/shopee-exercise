<?php 

class Currency_model extends CI_Model {
	
	public function __construct(){
			$this->load->database();
	}
		
	public function add_currency($post){
		
		$data = array(
			'currency_date' => $post['currency_date'],
			'currency_from' => $post['currency_from'],
			'currency_to' => $post['currency_to'],
			'currency_rate' => $post['currency_rate'],
			'currencytrans_status' => 1,
			'created_at' => date('Y-m-d H:i:s'),
		);

		return $this->db->insert('currency_trans', $data);
	}
	
	public function get_currency($params=NULL,$order=NULL,$limit=NULL){
		
		if (is_array($params)){
			foreach ($params as $key=>$val){
				$this->db->where($key,$val);			
			}
		}
		
		if (is_array($limit)){
			$this->db->limit($limit['1'],$limit['0']);
		}
		
		if (is_array($order)){
			foreach ($order as $key=>$val){
				$this->db->order_by($key,$val);			
			}
		}
		
		return $this->db->get('currency_trans')->result_array();
	}
	
	public function get_currency_avg($date){
		$this->db->where("currency_date BETWEEN ('$date' - INTERVAL 6 DAY) AND '$date'");
		return $this->db->get('currency_trans')->result_array();
	}
	
	public function get_currency_disctinct(){
		$this->db->select('currency_from,currency_to');
		$this->db->group_by('currency_from');
		$this->db->group_by('currency_to');
		return  $this->db->get('currency_trans')->result_array();
	}

}