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
