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

        if (!authenticate_login($this)){
            return;
        }

        $this->load->model('product_model');
        $products = $this->product_model->getAll();
        $data['products']=$products;
        load_view($this, 'product/list.php',$data);

    }

    function newForm() {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        load_view($this, 'product/newForm.php');
    }

    function create() {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

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
        } else {
            if ( !$fileUploadSuccess) {
                $data['fileerror'] = $this->upload->display_errors();
                load_view($this, 'product/newForm.php',$data);
                return;
            }
            load_view($this,'product/newForm.php');
        }
    }


    function read($id) {
        if (!authenticate_login($this)){
            return;
        }

        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        if (isset($product)){
            $data['product']=$product;
            load_view($this, 'product/read.php',$data);
        } else {
            load_view($this, 'auth/non_existent.php');
        }
    }

    function editForm($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        if (isset($product)){
            $data['product']=$product;
            load_view($this, 'product/editForm.php',$data);
        } else {
            load_view($this, 'auth/non_existent.php');
        }
    }

    function update($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        if (!isset($product)){
            load_view($this, 'auth/non_existent.php');
            return;
        }

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
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        if (!isset($product)){
            load_view($this, 'auth/non_existent.php');
            return;
        }

        if (isset($id))
            $this->product_model->delete($id);

        //Then we redirect to the index page again
        redirect('store/index', 'refresh');
    }

    function cart(){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');
        $data['items'] = $items;
        load_view($this, 'product/cart.php', $data);
    }

    function add_to_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];
            $item['quantity'] = $item['quantity'] + 1;
        } else {
            $this->load->model('product_model');
            $product = $this->product_model->get($product_id);
            if (isset($product)){
                $items[$product_id] = array("name" => $product->name,
                                    "quantity" => 1);
            }
        }

        $this->session->set_userdata('cart', $items);
        redirect('store/index', 'refresh');
    }

    function reduce_from_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];

            if ($item['quantity'] <= 1){
                unset($items[$product_id]);
            } else {
                $item['quantity'] = $item['quantity'] - 1;
            }
        }

        $this->session->set_userdata('cart', $items);

        $data['items'] = $items;
        load_view($this, 'product/cart.php', $data);
    }

    function increase_in_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];
            $item['quantity'] = $item['quantity'] + 1;
        }

        $this->session->set_userdata('cart', $items);

        $data['items'] = $items;
        load_view($this, 'product/cart.php', $data);
    }

    function remove_from_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }
        
        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];
            unset($items[$product_id]);
        }

        $this->session->set_userdata('cart', $items);

        $data['items'] = $items;
        load_view($this, 'product/cart.php', $data);
    }
}
