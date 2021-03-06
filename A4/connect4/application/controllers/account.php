<?php

class Account extends CI_Controller {
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	session_start();

    }
        
    public function _remap($method, $params = array()) {
	    	// enforce access control to protected functions	

    		$protected = array('updatePasswordForm','updatePassword','index','logout');
    		
    		if (in_array($method,$protected) && !isset($_SESSION['user']))
   			redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again
 	    	
	    	return call_user_func_array(array($this, $method), $params);
    }
          
    
    function loginForm() {
    		load_view($this, 'account/loginForm');
    }
    
    function login() {
    		$this->load->library('form_validation');
    		$this->form_validation->set_rules('username', 'Username', 'required');
    		$this->form_validation->set_rules('password', 'Password', 'required');

    		if ($this->form_validation->run() == FALSE)
    		{
    			load_view($this,'account/loginForm');
    		}
    		else
    		{
    			$login = $this->input->post('username');
    			$clearPassword = $this->input->post('password');
    			 
    			$this->load->model('user_model');
    		
    			$user = $this->user_model->get($login);
    			 
    			if (isset($user) && $user->comparePassword($clearPassword)) {
    				$_SESSION['user'] = $user;
    				$data['user']=$user;
    				
    				$this->user_model->updateStatus($user->id, User::AVAILABLE);
    				
    				redirect('arcade/index', 'refresh'); //redirect to the main application page
    			}
 			else {   			
				$data['errorMsg']='Incorrect username or password!';
 				load_view($this, 'account/loginForm',$data);
 			}
    		}
    }

    function logout() {
		$user = $_SESSION['user'];
    		$this->load->model('user_model');
	    	$this->user_model->updateStatus($user->id, User::OFFLINE);
    		session_destroy();
    		redirect('account/index', 'refresh'); //Then we redirect to the index page again
    }

     function showCaptchaImage() {
             $this->load->library("securimage");
             $this->securimage->show();
    }


    function newForm() {
	    	load_view($this,'account/newForm');
    }

    function _verifySecurimage($input) {
            $this->load->library("securimage");
            return $this->securimage->check($input);
    }

    function createNew() {
    		$this->load->library('form_validation');
    	        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.login]');
	    	$this->form_validation->set_rules('password', 'Password', 'required');
	    	$this->form_validation->set_rules('first', 'First', "required");
	    	$this->form_validation->set_rules('last', 'last', "required");
	    	$this->form_validation->set_rules('email', 'Email', "required|is_unique[user.email]");
                $this->form_validation->set_rules("verifycode", "Captcha", "required|callback__verifySecurimage");
                $this->form_validation->set_message('_verifySecurimage', 'Incorrect value. Please Try Again.');


	    	if ($this->form_validation->run() == FALSE)
	    	{
	    		load_view($this,'account/newForm');
	    	}
	    	else  
	    	{
	    		$user = new User();
	    		 
	    		$user->login = $this->input->post('username');
	    		$user->first = $this->input->post('first');
	    		$user->last = $this->input->post('last');
	    		$clearPassword = $this->input->post('password');
	    		$user->encryptPassword($clearPassword);
	    		$user->email = $this->input->post('email');
	    		
	    		$this->load->model('user_model');
	    		 
	    		
	    		$error = $this->user_model->insert($user);
	    		
	    		load_view($this,'account/loginForm');
	    	}
    }

    
    function updatePasswordForm() {
	    	load_view($this,'account/updatePasswordForm');
    }
    
    function updatePassword() {
	    	$this->load->library('form_validation');
	    	$this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
	    	$this->form_validation->set_rules('newPassword', 'New Password', 'required');
	    	 
	    	 
	    	if ($this->form_validation->run() == FALSE)
	    	{
	    		load_view($this,'account/updatePasswordForm');
	    	}
	    	else
	    	{
	    		$user = $_SESSION['user'];
	    		
	    		$oldPassword = $this->input->post('oldPassword');
	    		$newPassword = $this->input->post('newPassword');
	    		 
	    		if ($user->comparePassword($oldPassword)) {
	    			$user->encryptPassword($newPassword);
	    			$this->load->model('user_model');
	    			$this->user_model->updatePassword($user);
	    			redirect('arcade/index', 'refresh'); //Then we redirect to the index page again
	    		}
	    		else {
	    			$data['errorMsg']="Incorrect password!";
	    			load_view($this,'account/updatePasswordForm',$data);
	    		}
	    	}
    }
    
    function recoverPasswordForm() {
    		load_view($this,'account/recoverPasswordForm');
    }
    
    function recoverPassword() {
	    	$this->load->library('form_validation');
	    	$this->form_validation->set_rules('email', 'email', 'required');
	    	
	    	if ($this->form_validation->run() == FALSE)
	    	{
	    		load_view($this,'account/recoverPasswordForm');
	    	}
	    	else
	    	{ 
	    		$email = $this->input->post('email');
	    		$this->load->model('user_model');
	    		$user = $this->user_model->getFromEmail($email);

	    		if (isset($user)) {
	    			$newPassword = $user->initPassword();
	    			$this->user_model->updatePassword($user);
	    			
	    			$this->load->library('email');
	    		
	    			$config['protocol']    = 'smtp';
	    			$config['smtp_host']    = 'ssl://smtp.gmail.com';
	    			$config['smtp_port']    = '465';
	    			$config['smtp_timeout'] = '7';
	    			$config['smtp_user']    = 'your gmail user name';
	    			$config['smtp_pass']    = 'your gmail password';
	    			$config['charset']    = 'utf-8';
	    			$config['newline']    = "\r\n";
	    			$config['mailtype'] = 'text'; // or html
	    			$config['validation'] = TRUE; // bool whether to validate email or not
	    			
		    	  	$this->email->initialize($config);
	    			
	    			$this->email->from('csc309Login@cs.toronto.edu', 'Login App');
	    			$this->email->to($user->email);
	    			
	    			$this->email->subject('Password recovery');
	    			$this->email->message("Your new password is $newPassword");
	    			
	    			$result = $this->email->send();
	    			
	    			//$data['errorMsg'] = $this->email->print_debugger();	
	    			
	    			//$this->load->view('emailPage',$data);
	    			load_view($this,'account/emailPage');
	    			
	    		}
	    		else {
	    			$data['errorMsg']="No record exists for this email!";
	    			load_view($this,'account/recoverPasswordForm',$data);
	    		}
	    	}
    }    
 }

