<h1>New Product</h1>

<?php 
echo "<p>" . anchor('store/index','Back') . "</p>";

echo form_open_multipart('store/create');

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
echo form_input(array(
	'name' => 'price',
	'type' => 'number',
	'min' => '0',
	'step' => 'any',
	'required' => 'required'
));

echo form_label('Photo');

if(isset($fileerror))
	echo $fileerror;	
?>
<label class="file-upload">
	<input type="file" name="userfile" size="20"  />
</label>

<?php 	

echo form_submit( array(
	'name' => 'submit',
	'value' => 'Create',
	'class' => 'button'
));
echo form_close();
?>	

