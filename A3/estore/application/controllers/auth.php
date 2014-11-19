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
		if(!check_logged_out($this)){
			return;
		}

		$this->load->model('customer_model');
		$data['failed_attempt'] = 0;
		load_view($this, 'auth/authenticate.php', $data);

	}

	/* Take the user credentials and validate. If the credentials are valid,
	 * redirect the user to the store. Otherwise, indicate of invalid
	 * login and make the user login again
	 */
	function login() {

		if(!check_logged_out($this)){
			return;
		}

		if( $this->input->post()){
			$this->load->model('customer_model');
			$user = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$userid = $this->customer_model->check_user_authentication($user);
			if($userid != NULL){
				$this->session->set_userdata('username', $user['username']);
				$this->session->set_userdata('user_id', $userid);
				$this->session->set_userdata('logged_in', 1);
				$this->session->set_userdata('cart', array());
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
		if(!check_logged_out($this)){
			return;
		}
		load_view($this, 'auth/registrationForm.php');
	}

	/* If a user is not already logged in, get the posted information from
	 * a registration form, validate the input and create a new customer
	 * entry in the database. If the insertion is not successful,
	 * load the registration form view
	 */
	function register() {
		if(!check_logged_out($this)){
			return;
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','Username',
			'required|is_unique[customers.login]');
		$this->form_validation->set_rules('password','Password',
			'required|min_length[6]|max_length[16]');
		$this->form_validation->set_rules('passconf','Password Confirmation',
			'required|matches[password]');
		$this->form_validation->set_rules('first','First Name',
			'required|max_length[24]');
		$this->form_validation->set_rules('last','Last Name',
			'required|max_length[24]');
		$this->form_validation->set_rules('email',
			'Email','required|is_unique[customers.email]|max_length[45]|callback__email_check');

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
	function _email_check($e){
		if (!filter_var($e,FILTER_VALIDATE_EMAIL)){
			$this->form_validation->set_message('_email_check',
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
}
