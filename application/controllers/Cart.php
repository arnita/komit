<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Cart extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    


 		function index_post()
 		{

 			$cek = $this->db->get_where('tbl_cart',array('id_produk'=>$this->post('id_produk')))->row_array();
 			
 			if(!empty($cek))
 			{
 				$data = array(
                    'id_produk'       => $this->post('id_produk'),
                    'jumlah'       => (int)$cek['jumlah']+1,
                );
     		   $this->db->where('id_produk', $this->post('id_produk'));
      		  $update = $this->db->update('tbl_cart', $data);
      		   if ($data) {
		            $this->response($data, 200);
		        } else {
		            $this->response(array('status' => 'fail', 502));
		        }
 			}
 			else
 			{
 				$data = array('id_produk'=>$this->post('id_produk'),'jumlah'=>'1');
		        $insert = $this->db->insert('tbl_cart', $data);
		        if ($insert) {
		            $this->response($data, 200);
		        } else {
		            $this->response(array('status' => 'fail', 502));
		        }
 			}

 			  	
 			
 		}

 		function index_get()
 		{
 			$data = $this->db->select('a.nama_produk,b.jumlah')->from('tbl_produk a')->join('tbl_cart b','a.id_produk = b.id_produk')->get()->result_array();
		            $this->response($data, 200);

 		}

}