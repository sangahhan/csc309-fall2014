<?php
class Customer_model extends CI_Model {

	function getAll()
	{
		$query = $this->db->get('customers');
		return $query->result('Customer');
	}

	function get($id)
	{
		$query = $this->db->get_where('customers',array('id' => $id));

		return $query->row(0,'Customer');
	}

	function delete($id) {
		//TODO : delete all the customer orders first.
		// Get all the orders that is by the customer
		// For each order, delete the order_item. Then delete the order itself.
		return $this->db->delete("customers",array('id' => $id ));
	}

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

	/* Given username and password, return if the provided credentials are
	 * valid.
	 */
	function check_user_authentication($user_info){
		// TODO: Encrypt password before checking for password
		// $this->load->library('encrypt');
		// $enc_password = $this->encrypt->encode($user_info['password']);

		$query = $this->db->get_where('customers', array('login'=> $user_info['username'],
			'password'=> $user_info['password']));
        if($query->num_rows() == 1 ){
            return TRUE;
        }

        return FALSE;

	}

}
?>
