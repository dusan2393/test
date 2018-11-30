<?php include('../include/hf/header.php'); ?>
<?php require_once('../include/initialize.php'); ?>
<?php
$title = "Register";


if (isset($_POST['submit'])){
    $newUser = new User;
    
    if($newUser->attach_user($_POST['username'], $_POST['password'], $_POST['passwordConfirm'], $_POST['email'])){
        
        if ($newUser->create()){
            $session->message("success");
            header('Location: ' . $location);
            exit;
        } else {
            $session->message("Something goes wrong, contact administrator");
        }
        
    } else {
        $message = join("<br/>", $newUser->errors);
        $session->message($message);
        header('Location: ' . "register.php");
        exit;
    }
}



?>


<?php if (!empty($session->message)): ?>
        <div class="alert alert-info"><?php echo $session->message; ?></div>
<?php endif ?>

<div class="login-page">
  <div class="form">
<form action="register.php" class="form-horizontal" action='' method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Register</legend>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Username</label>
      <div class="controls">
        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
        <p class="help-block">Password should be at least 4 characters</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Password (Confirm)</label>
      <div class="controls">
        <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="" class="input-xlarge">
        <p class="help-block">Please confirm password</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <input type="submit" name="submit" id="submit" value="Register" class="btn btn-success">
      </div>
    </div>
  </fieldset>
</form>
</div>
  </div>

       
<?php include('../include/hf/footer.php'); ?>