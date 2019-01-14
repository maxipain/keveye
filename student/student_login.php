<?php
session_start();
$_SESSION['student-login']='';
$_SESSION['student-registration']='';
include 'functions/actions.php';
$obj=new DataOperations();
$error='';
if(isset($_POST['login']))
{
    $admission = $obj->con->real_escape_string(htmlentities($_POST['username']));
    $password = md5($_POST['password']);

    $where = array("AdmissionNumber"=>$admission,"password"=>$password);
    $get_student = $obj->fetch_records("student",$where);

    if($get_student)
    {
        foreach($get_student as $row)
        {
            $account=$row['account'];
            $security_question=$row['security_question'];
        }

        if($account!="active")
        {
            $error = "Your student portal account has been locked. Contact the administrator for more details";
        }
        if(empty($security_question))
        {
            $_SESSION['student-registration']=$admission;
            header('location:registration.php');
        }
        else if($security_question)
        {
            $_SESSION['student_login']=$admission;
            header('location:dashboard.php');
        }
    }
    else
    {
        $error = "Invalid admission number or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Course Project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
    <link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="styles/contact_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">

    <?php include_once '../includes/head.php' ?>

</head>
<body>

<div class="super_container">

    <!-- Header -->

    <?php include_once 'includes/navbar.php' ?>

    <!-- Home -->

    <div class="home">
        <div class="home_background_container prlx_parent">
            <div class="home_background prlx" style="background-image:url(../images/course_9.jpg)"></div>
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
                        <div class="col-md-3"></div>
                        <div class=" col-md-6"><h2 style="color: #8C4200;">Student's portal</h2></div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="contact_form_container">
                        <?php
                        if($error){
                           $obj->errorDisplay($error);
                        }
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input id="contact_form_name" class="input_field contact_form_name" type="number" placeholder="admission number"  data-error="Name is required." name="username" required="required">
                            <input id="contact_form_name" class="input_field contact_form_name" type="password" placeholder="password"  data-error="Name is required." name="password" required="required">
                            <br/>
                            <button id="contact_send_btn" type="submit" class="contact_send_btn trans_200" name="login">Login</button>
                            <a href="passwordreset.php" style="margin-top: 8px;">Forgot password?</a>
                            
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