<?php include('../include/hf/header.php'); ?>
<?php require_once('../include/initialize.php'); ?>
<?php 

if (isset($_POST['submit'])){
    
    $find_user = new User;
    $user = $find_user->authenticate($_POST['username'], $_POST['password']);

    if (!empty($user)){
        $session->login($user);
        
        header('Location: ' . "index.php");
        exit;
        
    } else {
        $message = join("<br/>", $find_user->errors);
		echo($message);
        $session->message("Wrong password or username.");
    }
    
}

?>



<?php if (!empty($session->message)): ?>
        <div class="alert alert-info"><?php echo $session->message; ?></div>
<?php endif ?>

<div class="login-page">
<div class="form">
<form action="login.php" class="form-horizontal" action='' method="POST">
<fieldset>
<div id="legend">
<legend class="">Please login</legend>
</div>
<div class="control-group">
<!-- Username -->
<label class="control-label"  for="username">Username</label>
<div class="controls">
<input type="text" id="username" name="username" placeholder="" class="input-xlarge">
</div>
</div>


<div class="control-group">
<!-- Password-->
<label class="control-label" for="password">Password</label>
<div class="controls">
<input type="password" id="password" name="password" placeholder="" class="input-xlarge">
</div>
</div>


<div class="control-group">
<!-- Button -->
<div class="controls">
<input type="submit" name="submit" id="submit" value="Login" class="btn btn-success">
</div>
</div>
</fieldset>
</form>
</div>
</div>
       
<?php include('../include/hf/footer.php'); ?>