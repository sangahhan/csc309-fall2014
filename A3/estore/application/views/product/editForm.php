<h1>Edit Product</h1>

<?php 
echo "<p>" . anchor(site_url('store'),'Back') . "</p>";

echo form_open("store/update/$product->id", array('onSubmit' => 'return validateProduct()', 'id' => 'product-form'));

echo '<p class="error" id="product-form-error"></p>';
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

echo '<p class="error" id="product-price-error"></p>';
echo form_input(array(
	'id' => 'product-price',
	'name' => 'price',
	'value' => $product->price,
	'required' => 'required'
));
echo form_submit( array(
	'name' => 'submit',
	'value' => 'Save',
	'class' => 'button'
));
echo form_close();
?>	

