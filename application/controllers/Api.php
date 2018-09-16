<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

	public function index_get(){
        $this->load->model('Api/Currency_model', 'currency');
		$result = $this->currency->get_currency_disctinct();
			
        if ( ! empty( $result ) ){

             $message = [
                'status' => "200",
                'message' => "success!",
                'data'  => $result,
		    ];

            $this->set_response([$message], 200);

        } else {

              $message = [
                'status' => "403",
                'message' => "exchange rates not found!",
				'data' => $this->db->error()['message']
            ];

            $this->set_response([$message], 403);
        }
    }
	
    public function create_post(){
        $this->load->model('Api/Currency_model', 'currency');
		try {
			$result = $this->currency->add_currency($this->post());
			if ( ! empty( $result ) ){

             $message = [
                'status' => "200",
                'message' => "sukses create data!",
                'data'  => $this->post(),
		    ];

				$this->set_response([$message], 200);

			} else {
				  $message = [
					'status' => "403",
					'message' => "create failed!",
					'data' => $this->db->error()['message']
				];

				$this->set_response([$message], 403);
			}
			}
		catch (Exception $e){
			$this->set_response($e, 403);
		}
        
        
    }
	
	public function history_get(){
		
		if (!empty($this->get('currency_date'))){
			$this->load->model('Api/Currency_model', 'currency');
			$this->load->helper('Arraygroup');
			
			$data['history'] = $this->currency->get_currency($this->get());
			$average = $this->currency->get_currency_avg($this->get('currency_date'));
			$data['average'] = $average;
			
			
			$average_group = array_group_by($average,'currency_from','currency_to');
			foreach ($data['history'] as $hkey=>$hval){
				if (count($average_group[$hval['currency_from']][$hval['currency_to']])==7){
					$dataAvg = $average_group[$hval['currency_from']][$hval['currency_to']];
					$avg = array_sum(array_column($dataAvg, 'currency_rate'))/7;
					$data['history'][$hkey]['average'] = $avg;
				}else{
					$data['history'][$hkey]['average'] = 'insufficient data';
				}
			}
			if ( ! empty( $data['history'] ) ){

				 $message = [
					'status' => "200",
					'message' => 'success',
					'data'  => $data['history']
				];

				$this->set_response([$message], 200);

			} else {

				  $message = [
					'status' => "403",
					'message' => "exchange rates not found",
					'data' => $this->db->error()['message']
				];

				$this->set_response([$message], 403);
			}
		}else {

			 $message = [
					'status' => "403",
					'message' => "Please input currency date!",
					'data' => $this->db->error()['message']
				];

			$this->set_response([$message], 403);
		}
	}
	
	public function historydetail_get(){
		
		if (!empty($this->get('currency_from'))&&!empty($this->get('currency_to'))){
			$this->load->model('Api/Currency_model', 'currency');
			
			$data['history'] = $this->currency->get_currency($this->get(),array('currency_date'=>'DESC'),array(0,7));
			
			if ( ! empty( $data['history'] ) ){
				$data['average'] = array_sum(array_column($data['history'], 'currency_rate'))/count($data['history']); 
				$data['variance'] = max(array_column($data['history'], 'currency_rate'))- min(array_column($data['history'], 'currency_rate'));

				 $message = [
					'status' => "200",
					'message' => 'success',
					'data'  => $data
				];

				$this->set_response([$message], 200);

			} else {

				  $message = [
					'status' => "403",
					'message' => "exchange rates not found!",
					'data' => $this->db->error()['message']
				];

				$this->set_response([$message], 403);
			}
		}else {

			 $message = [
					'status' => "403",
					'message' => "Please input currency_from and currency_to!",
					'data' => ''
				];

			$this->set_response([$message], 403);
		}
		
	}
	
	public function index_delete(){
		
		if (!empty($this->delete('currency_from'))&&!empty($this->delete('currency_to'))){
			$this->load->database();
			$this->db->where('currency_from', $this->delete('currency_from'));
			$this->db->where('currency_to', $this->delete('currency_to'));
			$delete = $this->db->delete('currency_trans');
			
			if ($delete){
				 $message = [
					'status' => "200",
					'message' => 'success',
					'data'  => $this->delete(),
				];

				$this->set_response([$message], 200);
			}else{
				$message = [
					'status' => "403",
					'message' => "failed!",
					'data' => $this->db->error()['message']
				];

				$this->set_response([$message], 403);
			}
		}else{
			$message = [
				'status' => "403",
				'message' => "Please input currency_from and currency_to!",
				'data' => ''
			];

			$this->set_response([$message], 403);
		}
		
	}
	
}