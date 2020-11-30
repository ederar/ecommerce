<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {

            $query = 'AND RegStatus = 0';
        }

        // Select Users From DATABASE 
        $stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
        $stmt->execute();
        $rows = $stmt->fetchAll();


?>

        <h1 class="text-center">Manage Members </h1>

        <div class="container">
            <table class="table .table-responsive text-center table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Registre Date</th>
                        <th scope="col">Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<th>" . $row['userID'] . "</th>";
                        echo "<th>" . $row['username'] . "</th>";
                        echo "<th>" . $row['email'] . "</th>";
                        echo "<th>" . $row['FullName'] . "</th>";
                        echo "<th>" . $row['date'] . "</th>";
                        echo "<th>";
                        echo    '<a class="btn btn-success" href="?do=edit&userID=' . $row['userID'] . '"><i class="far fa-edit"> </i> Edit</a>';
                        echo    '   <a onclick="confirmDelete()" class="btn btn-danger confirm" href="?do=delete&userID=' . $row['userID'] . '"><i class="fas fa-user-times"></i> Delete</a>';

                        if ($row['RegStatus'] == 0) {
                            echo    '   <a class="btn btn-primary"  href="?do=activate&userID=' . $row['userID'] . '"><i class="fas fa-user-check"></i> Activat</a>';
                        }

                        echo "</th>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
            <a class="btn btn-primary" href="?do=add"><i class="fas fa-plus"></i> ADD New Memeber</a>
        </div>
    <?php

    } elseif ($do == 'add') { //ADD Members
    ?>


        <h1 class="text-center">Add Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=insert" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Username :</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Password :</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="pass form-control" required="required">
                        <i class="show-pass fa fa-eye fa-2x "></i>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Email :</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Full name :</label>
                    <div class="col-sm-10">
                        <input type="text" name="FullName" class="form-control">
                    </div>
                </div>
                <div class="form-group row text-center">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="submit" value="Add New Member" class="form-control btn btn-primary">
                    </div>
                </div>
            </form>

        </div>

        <?php

    } elseif ($do == 'insert') {
        //
        echo '<div class="container">';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // GET Variables From The Form Form
            $username = $_POST['username'];
            $email = $_POST['email'];
            $FullName = $_POST['FullName'];
            $password = $_POST['password'];
            $hashpass = sha1($_POST['password']);

            // Validate The Form 
            $formsError = array();
            if (strlen($username) < 3) {
                $formsError[] = ' Username Must be More Than 2 Characters ';
            }

            if (empty($username)) {
                $formsError[] = ' Username Cant Be Empty ';
            }

            if (empty($password)) {
                $formsError[] = ' Password Cant Be Empty ';
            }
            if (empty($email)) {
                $formsError[] =  ' Email Cant Be Empty ';
            }
            if (empty($FullName)) {
                $formsError[] =  ' Full Name Cant Be Empty ';
            }

            foreach ($formsError as $error) {

                echo '<div class="text-center alert alert-danger" role="alert">' . $error . '</div>';
            }


            if (empty($formsError)) {

                // Check If user Existe
                $check = checkItems("username", "users", $username);

                if ($check > 0) {
                    echo '<div class="text-center alert alert-danger" role="alert">' . 'This Username Already Exicte' . '</div>';
                } else {
                    // Insert Into DataBase with this info 
                    $stmt = $conn->prepare('INSERT INTO 
                users(username, password,email,FullName,Regstatus,date)
                VALUES(:user, :pass, :email, :fullname, 1, now())');
                    $stmt->execute(array(

                        'user' => $username,
                        'pass' => $hashpass,
                        'email' => $email,
                        'fullname' => $FullName,
                    ));

                    echo '<div class="text-center alert alert-success" role="alert">' . $stmt->rowCount() . 'Record Inserted' . '</div>';
                }
            }
        } else {
            echo '<div class="text-center alert alert-danger" role="alert"> You Can Not Browse This Page </div>';
        }
        //end Of Container
        echo '</div>';
    } elseif ($do == 'edit') {

        $userID = $_GET['userID'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? ");
        $stmt->execute(array($userID));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {  ?>

            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="userID" value="<?php echo $userID ?>">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Username :</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Password :</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>">
                            <input type="password" name="newpassword" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Email :</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Full name :</label>
                        <div class="col-sm-10">
                            <input type="text" name="FullName" value="<?php echo $row['FullName'] ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <div class="col-sm-10 offset-sm-2">
                            <input type="submit" value="Save" class="form-control btn btn-primary">
                        </div>
                    </div>
                </form>

            </div>

<?php
        } else {
            echo 'There is No ID';
        }
    } elseif ($do == 'update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center"> Update Members </h1>';
            echo '<div class="container">';
            // GET Variables From The Form Form
            $id = $_POST['userID'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $FullName = $_POST['FullName'];
            $password = '';
            // Update Password
            if (empty($_POST['newpassword'])) {
                $password = $_POST['oldpassword'];
            } else {
                $password = sha1($_POST['newpassword']);
            }

            // Validate The Form 
            $formsError = array();
            if (strlen($username) < 3) {
                $formsError[] = ' Username Must be More Than 2 Characters ';
            }

            if (empty($username)) {
                $formsError[] = ' Username Cant Be Empty ';
            }
            if (empty($email)) {
                $formsError[] =  ' Email Cant Be Empty ';
            }
            if (empty($FullName)) {
                $formsError[] =  ' Full Name Cant Be Empty ';
            }

            foreach ($formsError as $error) {

                echo '<div class="text-center alert alert-danger" role="alert">' . $error . '</div>';
            }


            if (empty($formsError)) {
                // Update The DataBase with this info 
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, FullName = ?, password = ? WHERE userID = ?");
                $stmt->execute(array($username, $email, $FullName, $password, $id));

                echo '<div class="text-center alert alert-success" role="alert">' . $stmt->rowCount() . 'Row Updated' . '</div>';
            }
        } else {
            echo '<br>';
            echo '<div class="text-center alert alert-danger" role="alert"> You Cant Browse This Page </div>';
        }
        //end Of Container
        echo '</div>';
    } elseif ($do == 'delete') {


        echo '<h1 class="text-center"> Delete Members </h1>';
        echo '<div class="container">';

        $userID = isset($_GET['userID']);
        $stmt = $conn->prepare("DELETE  FROM users WHERE userID = ? ");
        $stmt->execute(array($userID));
        $count = $stmt->rowCount();
        if ($count > 0) {

            echo '<div class="alert alert-success" role="alert">
                The Members Is Deleted !
                </div>';
        }

        // Container End
        echo '</div>';
    } elseif ($do == 'activate') {

        echo '<h1 class="text-center"> Activate Members </h1>';
        echo '<div class="container">';
        $userID = $_GET['userID'];
        $stmt = $conn->prepare("UPDATE users SET RegStatus = 1 WHERE userID = ?");
        $stmt->execute(array($userID));
        $count = $stmt->rowCount();
        echo $count;
        if ($count > 0) {

            echo '<div class="alert alert-success" role="alert">
            The Members Is Activated  !
            </div>';
        }
    }


    include $tmp . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
