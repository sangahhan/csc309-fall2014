<?php

class Auth extends CI_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
        $this->load->helper('utils');

    }

    /* If the user is not logged in, display the login form.
     */
    function index() {
        check_logged_out($this);
        $this->load->model('customer_model');
        $data['failed_attempt'] = 0;
        load_view($this, 'auth/authenticate.php', $data);

    }

    /* Take the user credentials and validate. If the credentials are valid,
     * redirect the user to the store. Otherwise, indicate of invalid
     * login and make the user login again
     */
    function login() {
        check_logged_out($this);
        if( $this->input->post()){
            $this->load->model('customer_model');
            $user = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );

            if( $this->customer_model->check_user_authentication($user)){
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('logged_in', 1);
                redirect(site_url('/store'));
            }
        }
        // Failed attempt is set to true to indicate in the view
        $data['failed_attempt'] = 1;
        load_view($this, 'auth/authenticate.php', $data);
    }

    /* If a user is not already logged in, display the form for registration.
     */
    function registration_form(){
        check_logged_out($this);
        load_view($this, 'auth/registrationForm.php');
    }

    /* If a user is not already logged in, get the posted information from
     * a registration form, validate the input and create a new customer
     * entry in the database. If the insertion is not successful,
     * load the registration form view
     */
    function register() {
        check_logged_out($this);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username','Username',
                'required|min_length[5]|max_length[16]|is_unique[customers.login]');
        $this->form_validation->set_rules('password','Passowrd',
                'required|min_length[4]|max_length[16]');
        $this->form_validation->set_rules('first','First Name',
                'required|max_length[24]');
        $this->form_validation->set_rules('last','Last Name',
                'required|max_length[24]');
        $this->form_validation->set_rules('email',
                'Email','required|max_length[45]|callback_email_check');

        if ($this->form_validation->run() == true) {
            $this->load->model('customer_model');

            $customer = new Customer();
            $customer->login = $this->input->get_post('username');
            $customer->password = $this->input->get_post('password');
            $customer->first = $this->input->get_post('first');
            $customer->last = $this->input->get_post('last');
            $customer->email = $this->input->get_post('email');

            if ($this->customer_model->insert($customer)){
                load_view($this,'auth/registration_complete.php');
            } else {
                // Otherwise try again!
                load_view($this,'auth/registrationForm.php');
            }
        } else {
            load_view($this,'auth/registrationForm.php');
        }
    }

    /* Return true if the given email has correct format.
     */
    function email_check($e){
        if (!filter_var($e,FILTER_VALIDATE_EMAIL)){
            $this->form_validation->set_message('email_check',
                'Invalid email format. Example: user@domain.com');
            return false;
        }
        return true;
    }

    /* Clear out the session details and redirect to the authentication url
     *
     */
    function logout(){

        $current_user = array(
                'username'  =>'',
                'logged_in' => 0,
        );

        $this->session->unset_userdata($current_user);
        $this->session->sess_destroy();
        redirect(site_url('/auth'), 'refresh');
    }

    /* Deny access when a non logged in user tries to access the store */
    function deny_access(){
        load_view($this, 'auth/permission_denied.php');
    }

    /* Deny access when an already logged in user tries to login or register */
    function logged_in_user(){
        load_view($this, 'auth/logged_in_user.php');
    }
}
