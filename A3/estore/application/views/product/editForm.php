<h2>Edit Product</h2>

<style>
	input { display: block;}
	
</style>

<?php 
	echo "<p>" . anchor('store/index','Back') . "</p>";
	
	echo form_open("store/update/$product->id");
	
	echo form_label('Name'); 
	echo form_error('name');
	echo form_input(array(
		'name' => 'name',
		'value' => $product->name,
		'required' => 'required'
	));

	echo form_label('Description');
	echo form_error('description');
	echo form_textarea(array (
		'name' => 'description',
		'value' => $product->description,
		'required' => 'required'
	));
	
	echo form_label('Price');
	echo form_error('price');
	
echo form_input(array(
	'name' => 'price',
	'value' => $product->price,
	'type' => 'number',
	'min' => '0',
	'step' => 'any',
	'required' => 'required'
));
echo form_submit( array(
	'name' => 'submit',
	'value' => 'Save',
	'class' => 'button'
));
	echo form_close();
?>	

