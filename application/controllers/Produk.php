<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Produk extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    function index_get() {
        $id_produk = $this->get('id_produk');
        if ($id_produk == '') {
            $kontak = $this->db->get('tbl_produk')->result();
        } else {
            $this->db->where('id_produk', $id_produk);
            $kontak = $this->db->get('tbl_produk')->result();
        }
        $this->response($kontak, 200);
    }

    function index_post() {
        $data = array(
                    'id_produk'           => $this->post('id_produk'),
                    'nama_produk'          => $this->post('nama_produk'),
                    'harga_produk'    => $this->post('harga_produk'),
                    'total_produk'    => $this->post('total_produk'));
        $insert = $this->db->insert('tbl_produk', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_put($id=null) {
        $id_produk = $this->put('id_produk');
        //print_r($id_produk);exit();
        $data = array(
                    'id_produk'       => $this->put('id_produk'),
                    'nama_produk'          => $this->put('nama_produk'),
                    'harga_produk'    => $this->put('harga_produk'),
                    'total_produk'    => $this->put('total_produk'));
        $this->db->where('id_produk', $id_produk);
        $update = $this->db->update('tbl_produk', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {

        $id_produk = $this->delete('id_produk');

        $this->db->where('id_produk', $id_produk);
        $delete = $this->db->delete('tbl_produk');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }


 		function index_input_cart($id=null)
 		{

 			$cek = $this->db->get_where('tbl_cart',array('id_produk'=>$id))->row_array();

 			  	$data = array('id_produk'=>$id,'jumlah'=>'1');
		        $insert = $this->db->insert('tbl_cart', $data);
		        if ($insert) {
		            $this->response($data, 200);
		        } else {
		            $this->response(array('status' => 'fail', 502));
		        }
 			
 		}

 		function index_cart($id=null)
 		{
 			$data = $this->db->select('a.nama_produk,b.jumlah')->from('tbl_produk a')->join('tbl_cart b','a.id_produk = b.id_produk')->get()->result_array();
 			echo json_encode(array('success'=>'telo'));

 		}

}