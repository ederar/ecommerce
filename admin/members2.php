<?php

session_start();

// redirect to dash board 
if (isset($_SESSION['username'])) {
    $pagetitle = 'members';
    include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

        if ($do == 'manage') {
            
        }elseif ($do == 'edit') { 
            
            $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval(['userID']) : 0 ;
                $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? ");
                $stmt->execute(array($userID));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();

                if ($stmt->rowCount() > 0) { ?>

            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Username :</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Password :</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Email :</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Full name :</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fullname" class="form-control">
                                </div>
                        </div>
                        <div class="form-group row text-center">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="submit" value="Save" class="form-control btn btn-primary">
                                </div>
                        </div>
                    </div>

            </div>
            <?php                
        } else {
            echo 'There is No ID';
        }              
      }    
      
    
}
else {
    header('location: index.php');
    exit();
}

