<?php
class Order_Item_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order_items');
		return $query->result('Order_Item');
	}  

	function get($id)
	{
		$query = $this->db->get_where('order_items',array('id' => $id));
		if ($query->num_rows() > 0){
			return $query->row(0,'Order_Item');
		}
	}

	function delete($id) {
		return $this->db->delete("order_items",array('id' => $id ));
	}

	function insert($order_item) {
		return $this->db->insert("order_items", array(
			'product_id' => $order_item->product_id,
			'order_id' => $order_item->order_id,
			'quantity' => $order_item->quantity));
	}


}
?>
