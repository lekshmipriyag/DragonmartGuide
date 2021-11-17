<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	
	<style>
		img {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 5px;
			width: 150px;
		}

		img:hover {
			box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
		}
</style>
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=li1rzf765fg4td9fk6hkuanxzbrlpvt6eo0ewzo38dzdotiw"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
</head>

<body>
<form action="" method="post">
<textarea name="raja">test ...</textarea>
<textarea name="raja2">test ...</textarea>
<input type="submit">
</form>
<?php
	print_r($_POST);
	?>
</body>
</html>