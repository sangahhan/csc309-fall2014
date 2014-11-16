<?php

class Store extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();


        $config['upload_path'] = './images/product/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

    }
    function index() {
        authenticate_login($this);
        $this->load->model('product_model');
        $products = $this->product_model->getAll();
        $data['products']=$products;
        load_view($this, 'product/list.php',$data);
    }

    function newForm() {
        authenticate_login($this);
        authenticate_admin($this);
        load_view($this, 'product/newForm.php');
    }

    function create() {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
        $this->form_validation->set_rules('description','Description','required');
        $this->form_validation->set_rules('price','Price','required');
        $fileUploadSuccess = $this->upload->do_upload();
        if ($this->form_validation->run() == true && $fileUploadSuccess) {
            $this->load->model('product_model');

            $product = new Product();
            $product->name = $this->input->get_post('name');
            $product->description = $this->input->get_post('description');
            $product->price = $this->input->get_post('price');

            $data = $this->upload->data();
            $product->photo_url = $data['file_name'];
            $this->product_model->insert($product);

            //Then we redirect to the index page again
            redirect('store/index', 'refresh');
        }
        else {
            if ( !$fileUploadSuccess) {
                $data['fileerror'] = $this->upload->display_errors();
                load_view($this, 'product/newForm.php',$data);
                return;
            }

            load_view($this,'product/newForm.php');
        }
    }

    function read($id) {
        authenticate_login($this);
        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        $data['product']=$product;
        load_view($this, 'product/read.php',$data);
    }

    function editForm($id) {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        $data['product']=$product;
        load_view($this, 'product/editForm.php',$data);
    }

    function update($id) {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('description','Description','required');
        $this->form_validation->set_rules('price','Price','required');

        if ($this->form_validation->run() == true) {
            $product = new Product();
            $product->id = $id;
            $product->name = $this->input->get_post('name');
            $product->description = $this->input->get_post('description');
            $product->price = $this->input->get_post('price');

            $this->load->model('product_model');
            $this->product_model->update($product);
            //Then we redirect to the index page again
            redirect('store/index', 'refresh');
        }
        else {
            $product = new Product();
            $product->id = $id;
            $product->name = set_value('name');
            $product->description = set_value('description');
            $product->price = set_value('price');
            $data['product']=$product;
            load_view($this, 'product/editForm.php',$data);
        }
    }

    function delete($id) {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->model('product_model');

        if (isset($id))
            $this->product_model->delete($id);

        //Then we redirect to the index page again
        redirect('store/index', 'refresh');
    }

}
