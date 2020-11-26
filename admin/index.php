<?php 
session_start();
$nonav = '';
$pagetitle = 'Login';
if (isset($_SESSION['username'])) {
    header('location: dashboard.php');
} 

include 'init.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedpass = sha1($password);
    

    $stmt = $conn->prepare("SELECT userID, username, password FROM users WHERE username = ? AND password = ? AND GroupID = 1 LIMIT 1");
    $stmt->execute(array($username, $hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['ID'] = $row['userID'];
        header('location: dashboard.php');
        exit();
     }
}

?>

<div id="login">
        <h3 class="text-center text-white pt-5">Admin Login</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form class="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md text-center" value="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
include $tmp . 'footer.php';
?>