<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'init.php';

?>

    <div class="container text-center dash ">
        <h1>DashBoard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stats">
                    Total Members
                    <span><a href="members.php"> <?php echo countItems("userID", "users") ?> </a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats">
                    Pending Members
                    <span><a href="members.php?do=manage&page=pending"><?php echo checkItems("RegStatus", "users", "RegStatus = 0") ?> </a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats">
                    Total items
                    <span>2690</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats">
                    Total Comments
                    <span>1500</span>
                </div>
            </div>
        </div>
    </div>
    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-user"></i> Latest 5 Members
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php $latest = latestItems("username", "users", "userID");

                                foreach ($latest as $user) {
                                    echo '<li class="list-group-item">' . $user['username'] . '</li>';
                                }

                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-tag"></i> Latest 5 Items
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                    test
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    include $tmp . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
