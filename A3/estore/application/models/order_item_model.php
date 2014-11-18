<?php
class Order_Item_model extends CI_Model {

	/*
	 * Return all entries in "order_item" database as Order_Item objects
	 */
	function getAll()
	{  
		$query = $this->db->get('order_items');
		return $query->result('Order_Item');
	}  

	/*
	 * Given an order_item id, return the corresponding order_item. If the
	 * id is invalid, return null.
	 */
	function get($id)
	{
		$query = $this->db->get_where('order_items',array('id' => $id));
		if ($query->num_rows() > 0){
			return $query->row(0,'Order_Item');
		}
	}

	/*
	 * Given an order id, return all the order items belonging to that order id.
	 * For each item, inlude the name and price of the product as well.
	 * If the order_id is invalid, return null.
	 */
	function get_order($order_id)
	{
		$query = $this->db->get_where('order_items',array('order_id' => $order_id));
		if ($query->num_rows() > 0){
			$this->load->model('product_model');
			$result = $query->result('Order_Item');
			for ($i = 0; $i < count($result); $i++){
				$product = $this->product_model->get($result[$i]->product_id);
				$result[$i]->name = $product->name;
				$result[$i]->price = $product->price;
			}
			return $result;
		}
	}

	/*
	 * Delete an order item.
	 */
	function delete($id) {
		return $this->db->delete("order_items",array('id' => $id ));
	}

	/*
	 * Insert an order_item in to the database
	 */
	function insert($order_item) {
		return $this->db->insert("order_items", array(
			'product_id' => $order_item->product_id,
			'order_id' => $order_item->order_id,
			'quantity' => $order_item->quantity));
	}


}
?>
