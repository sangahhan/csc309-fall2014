<?php
class Customer_model extends CI_Model {

	/* Returns a list of all entries in the 'customers'  database as Customer
	 * objects
	*/
	function getAll()
	{
		$query = $this->db->get('customers');
		return $query->result('Customer');
	}

	/*
	 * Given a customer id, return the customer with the given id. If the
	 * id is invalid, return null.
	 */
	function get($id)
	{
		$query = $this->db->get_where('customers',array('id' => $id));
		if ($query->num_rows() > 0){
			return $query->row(0,'Customer');
		}
	}

	/*
	 * Delete a customer
	 */
	function delete($id) {

		return $this->db->delete("customers",array('id' => $id ));
	}

	/*
	 * Insert a customer in to the database given a Customer object
	 */
	function insert($customer) {
		// TODO: Encrypt password before inserting
		// $this->load->library('encrypt');
		// $password = $this->encrypt->encode($customer->password)
		return $this->db->insert("customers", array('first' => $customer->first,
												'last' => $customer->last,
				                               	'login' => $customer->login,
											   	'password' => $customer->password,
												'email'=> $customer->email));
	}

	/* Given username and password, return the user's userID if the provided 
	 * credentials are valid. Otherwise return NULL.
	 */
	function check_user_authentication($user_info){
		// TODO: Encrypt password before checking for password
		// $this->load->library('encrypt');
		// $enc_password = $this->encrypt->encode($user_info['password']);

		$query = $this->db->get_where('customers', array('login'=> $user_info['username'],
			'password'=> $user_info['password']));
        if($query->num_rows() == 1 ){
            return $query->row(0)->id;
        }

        return NULL;

	}

}
?>
