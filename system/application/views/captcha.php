<html>
<head>
<title>My Form</title>

</head>
<body>

<?php echo $this->validation->error_string; ?>

<?php echo form_open('captchas'); ?>

<h5>Username</h5>
<?php echo $this->validation->user_error; ?>
<input type="text" name="user" value="<?php echo ($this->validation->user) ;?>"  size="50" />
<br/>
<?php echo $image;?>
<br/>
<?php echo $this->validation->captcha_error; ?>
<input type="text" name="captcha" value="" />
<br/>
<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>  