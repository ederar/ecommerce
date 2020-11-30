<?php

session_start();

$pageTitle = '';

if (isset($_SESSION['username'])) {

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

        $stmt2 = $conn->prepare("SELECT * FROM categories");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
?>

        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">

            <div class="card"">
                <div class="card-header">
                    Categories
                </div>
                <ul class="list-group list-group-flush">
                    <?php 
                        foreach ($cats as $cat) {
                           echo '<li class="list-group-item">';
                           echo '<h3>' . $cat['Name'] . '</h3>';

                            if ($cat['Description'] == '') {
                                echo '<p> The Category Has No Description </p>';
                            }
                             else {
                                echo '<p>' . $cat['Description'] . '</p>';
                            }

                            if ($cat['Visibility'] == 0) {
                            echo  '<span class="visible"> Hidden </span>';
                           } 
                           if ($cat['Allow_comments'] == 0) {
                            echo  '<span class="comnts"> Comment Disabled </span>';
                           } 
                           if ($cat['Allow_ads'] == 0) {
                            echo  '<span class="adv"> Ads Disabled </span>';
                           } 
                           
                           echo '</li>';
                        }
                    ?>
                </ul>
            </div>

        </div>

    <?php
    } elseif ($do == 'add') {   ?>


        <h1 class="text-center">Add Category </h1>
        <div class="container">
            <form class="form-horizontal" action="?do=insert" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Category name:</label>
                    <div class="col-sm-10">
                        <input type="text" name="category" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Description :</label>
                    <div class="col-sm-10">
                        <input type="text" name="description" class="pass form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Ordering :</label>
                    <div class="col-sm-10">
                        <input type="text" name="order" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Visibility :</label>
                    <div class="col-sm-10">
                        <input type="radio" id="vis-yes" name="visibility" value="0" checked>
                        <label for="vis-yes">Yes</label>
                        <input type="radio" name="visibility" id="vis-no" value="1">
                        <label for="vis-no" class="control-label">No</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Allow Comments :</label>
                    <div class="col-sm-10">
                        <input type="radio" id="com-yes" name="comments" value="0" checked>
                        <label for="com-yes">Yes</label>
                        <input type="radio" name="comments" id="com-no" value="1">
                        <label for="com-no" class="control-label">No</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Allow Ads :</label>
                    <div class="col-sm-10">
                        <input type="radio" id="ads-yes" name="ads" value="0" checked>
                        <label for="ads-yes">Yes</label>
                        <input type="radio" name="ads" id="ads-no" value="1">
                        <label for="ads-no" class="control-label">No</label>
                    </div>
                </div>
                <div class="form-group row text-center">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="submit" value="Add New Category" class="form-control btn btn-primary">
                    </div>
                </div>
            </form>

        </div>



<?php
    } elseif ($do == 'insert') {
        //insert Data to Database

        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = $_POST['category'];
            $description = $_POST['description'];
            $ordering = $_POST['order'];
            $visibility = $_POST['visibility'];
            $comments = $_POST['comments'];
            $ads = $_POST['ads'];

            //Check If Category  Exist
            $check = checkItems('Name', 'categories', $name);

            if ($check > 0) {
                echo '<div class="text-center alert alert-danger" role="alert">' . 'This Category Already Exicte' . '</div>';
            } else {


                $stmt = $conn->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_comments, Allow_ads)
            VALUES(:name , :description, :order,:visible, :comments, :ads)");
                $stmt->execute(array(

                    ':name' => $name,
                    ':description' => $description,
                    ':order' => $ordering,
                    ':visible' => $visibility,
                    ':comments' => $comments,
                    ':ads' => $ads,

                ));

                echo '<div class="text-center alert alert-success" role="alert">' . $stmt->rowCount() . 'Record Inserted' . '</div>';
            }
        } else {
            echo '<div class="text-center alert alert-danger" role="alert"> You Can Not Browse This Page </div>';
        }

        echo '</div>';
    } elseif ($do == 'Edit') {
    } elseif ($do == 'Update') {
    } elseif ($do == 'Delete') {
    } elseif ($do == 'Activate') {
    }

    include $tmp . 'footer.php';
} else {

    header('Location: index.php');

    exit();
}
