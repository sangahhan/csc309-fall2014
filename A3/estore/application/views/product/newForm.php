<h1>New Product</h1>

<?php 
// View for creating new product form

echo "<p>" . anchor(site_url('store'),'Back') . "</p>";

echo form_open_multipart('store/create', array('onSubmit' => 'return validateProduct()', 'id' => 'product-form'));
// Area for form validation error to show
echo '<p class="error" id="product-form-error"></p>';

echo form_label('Name'); 
echo form_error('name');
echo form_input(array(
	'name' => 'name',
	'required' => 'required'
));

echo form_label('Description');
echo form_error('description');
echo form_textarea(array (
	'name' => 'description',
	'required' => 'required'
));

echo form_label('Price');
echo form_error('price');
echo '<p class="error" id="product-price-error"></p>';
echo form_input(array(
	'id' => 'product-price',
	'name' => 'price',
	'required' => 'required'
));

echo form_label('Photo');

if(isset($fileerror))
	echo $fileerror;	
?>
<label class="file-upload">
	<input type="file" name="userfile" size="20" required/>
</label>

<?php 	

echo form_submit( array(
	'name' => 'submit',
	'value' => 'Create',
	'class' => 'button'
));
echo form_close();
?>	

