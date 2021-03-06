<?php
session_start();
if($_SESSION['registration']){
    echo $_SESSION['registration'];
    $error='';

    $current_time = date("Y-m-d H:i:s");
    $last_login = array("last_login"=>$current_time);

    include_once 'database/actions.php';
    $obj = new DataOperations();

    if(isset($_POST['submit']))
    {
        $email = $obj->con->real_escape_string(htmlentities($_POST['email']));
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        if($password!=$confirm)
        {
            $error = "Passwords must match";
        }
        else if(strlen($password)<8){

            $error = "Password must be 8 characters or more";

        }
        else
        {
            $username = $_SESSION['registration'];
            $where=array('username'=>$username);
            $data=array('email'=>$email,'password'=>md5($password));

            $get_data = $obj->fetch_records('staff_accounts',$where);
            foreach($get_data as $row)
            {
                $account_type = $row['account'];
            }

            if($obj->update_record('staff_accounts',$where,$data))
            {
                if($account_type == 'teacher')
                {
                    $_SESSION['account']=$username;
                    header('location:teacherportal/index.php');
                }
                else if($account_type == 'librarian')
                {
                    $_SESSION['librarian_account']=$username;
                    header('location:librarian/index.php');
                }
            }
            else
            {
                $error = "Error updating account";
            }
        }
    }
}
else
{
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>STAFF MEMBER REGISTRATION</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Course Project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
    <link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="styles/contact_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">

    <?php include_once '../includes/head.php'?>

</head>
<body>

<div class="super_container">

    <!-- Header -->

    <?php include_once 'includes/navbar.php'?>

    <!-- Home -->

    <div class="home">
        <div class="home_background_container prlx_parent">
            <div class="home_background prlx" style="background-image:url(../images/search_background.jpg)"></div>
        </div>
        <div class="home_content">
            <h1>portal</h1>
        </div>
    </div>

    <!-- Register -->

    <div class="register" style="margin-top: -170px">

        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="row row-eq-height">
                        <!-- Contact Form -->
                        <div class="contact_form" style="padding-top: 20px">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class=" col-md-8"><h2 style="color: #8C4200;">Staff registration</h2></div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="contact_form_container">
                                    <?php
                                    if($error){
                                        $obj->errorDisplay($error);
                                    }
                                    ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input id="contact_form_name" class="input_field contact_form_name" type="email" placeholder="Email address"  name="email" required="required">
                                        <input id="contact_form_name" class="input_field contact_form_name" type="password" placeholder="Password (8 or more characters)"  name="password" required="required">
                                        <input id="contact_form_name" class="input_field contact_form_name" type="password" placeholder="Retype password"  name="confirm" required="required">
                                        <button id="contact_send_btn" type="submit" class="contact_send_btn trans_200" name="submit">Proceed</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>

    <!-- Elements -->



    <!-- Footer -->

    <?php include_once 'includes/footer.php'?>

</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/progressbar/progressbar.min.js"></script>
<script src="plugins/scrollTo/jquery.scrollTo.min.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="js/elements_custom.js"></script>

</body>
</html>