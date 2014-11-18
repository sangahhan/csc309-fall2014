<?php
class Order_model extends CI_Model {

	/*
	 * Return all entries in "orders" db as "Order" objects
	 */
	function getAll()
	{  
		$query = $this->db->get('orders');
		return $query->result('Order');
	}  

	/*
	* Given an order id, return the corresponding Order object. If the
	* id is invalid, return null.
	*/
	function get($id)
	{
		$query = $this->db->get_where('orders',array('id' => $id));
		if ($query->num_rows() > 0){
			return $query->row(0,'Order');
		}
	}

	/*
	 *	Delete an order.
	 */
	function delete($id) {
		return $this->db->delete("orders",array('id' => $id ));
	}

	/*
	 * Given an Order_Item object, insert into the database
	 */
	function insert($order) {
		return $this->db->insert("orders", array(
			'customer_id' => $order->customer_id,
			'order_date' => $order->order_date,
			'order_time' => $order->order_time,
			'total' => $order->total,
			'creditcard_number' => $order->creditcard_number,
			'creditcard_month' => $order->creditcard_month,
			'creditcard_year' => $order->creditcard_year));
	}



}
?>
