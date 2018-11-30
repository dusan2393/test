<?php include('../include/hf/header.php'); ?>
<?php require_once('../include/initialize.php'); ?>
<?php 

if ($session->is_logged_in()){
    $user = User::find_by_id($session->user_id());
    $similar = User::search_users($user->username);
    //var_dump($similar);
} else {
    /*
    header('Location: ' . "login.php");
    exit;
    */
}


if (isset($_POST['submit'])){
    if (isset($_POST['searchText']) && !empty($_POST['searchText'])){
        $searched = User::search_users($_POST['searchText']);
        
    } else {
        $session->message("fill search field");
    }
}
?>
<style>
    body{
        background: white;
    }
</style>
<div class="row">
    <div class="alert alert-info">
        <div class=""> 

            <?php
            if (!empty($user)){
                echo "Welcome, " . ucfirst($user->username); 
            ?>
         </div>
        
        <div class="">
            <table class='table table-hover' style="width:300px; ">

                <thead>
                    <tr><th>Id</th><th>Username</th><th>email</th>
                </thead>

                <tbody>
                    <tr>
                        <th><?php echo htmlentities($user->id); ?></th>
                        <th><?php echo htmlentities($user->username); ?></th>
                        <th><?php echo htmlentities($user->email); ?></th>
                    </tr>
                <tbody>

            </table>
            <?php
            } else {
                echo "Error loging you in.";
            }
        ?>
        </div>
    </div>
    
</div><!-- #row -->

<?php if (!empty($session->message)): ?>
        <div class="alert alert-danger"><?php echo $session->message; ?></div>
<?php endif ?>

<div style="margin:auto; padding:auto; width:800px;">
    
    <form action="index.php" method="post">
        <div class="row">
            <div class=" col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                    <input type="text" class="form-control " placeholder="Search" name="searchText"/>
                    <div class="input-group-btn">
                        <button class="btn btn-primary" type="submit" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class='row'>
        
        <div class='col-sm-6 col-md-6 col-lg-6' >

            <p>Similar results:</p>
            <?php
            if(!empty($searched)){ 
                foreach ($searched as $found){

                    echo htmlentities($found->username) . " / " . htmlentities($found->email) . "<br>";
                }    
            } 
            ?>
        </div>
            
        <div class='col-sm-6 col-md-6 col-lg-6' >
            <p>Similar to you:</p>
            <?php
            if(!empty($similar)){ 
                foreach ($similar as $simUser){
                    echo htmlentities($simUser->username) . " / " . htmlentities($simUser->email) . "<br>";
                }    
            } 
            ?>

            
        </div>
</div><!-- container -->  
<?php include('../include/hf/footer.php'); ?>