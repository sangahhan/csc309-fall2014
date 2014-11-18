<h1>New Product</h1>

<?php 
echo "<p>" . anchor('store/index','Back') . "</p>";

echo form_open_multipart('store/create');

echo form_label('Name'); 
echo form_error('name');
echo form_input('name',set_value('name'),"required");

echo form_label('Description');
echo form_error('description');
echo form_input('description',set_value('description'),"required");

echo form_label('Price');
echo form_error('price');
echo form_input('price',set_value('price'),"required");

echo form_label('Photo');

if(isset($fileerror))
	echo $fileerror;	
?>
<label class="file-upload">
	<input type="file" name="userfile" size="20"  />
</label>

<?php 	

echo form_submit('submit', 'Create', 'class="button"');
echo form_close();
?>	

