<?php 
include("db.php");

$email = isset($_GET['eid']) ? base64_decode($_GET['eid']) : "";

if(isset($_POST['submit'])){

  $email = $_POST['email'];
  $feedback = $db->escape_string(trim($_POST['feedback']));
  $fullName = $db->escape_string(trim($_POST['fullName']));

  $insert = "INSERT INTO feedbacks (Email,Fullname,Feedback,DateAdded) VALUES ('".$email."','".$fullName."','".$feedback."','".date('Y-m-d H:i:s')."')";
  $process = $db->query($insert);
  if($process){
    echo "<script>
      alert('Thank you! We appreciate your time taking this feedkback!');
      setTimeout(function(){
        window.close();
      },2000);
    </script>";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>The Events Production</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.jpg" rel="icon">
  <link href="assets/img/logo.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/calendar/css/pignose.calendar.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Restaurantly - v3.1.0
  * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<main>
    <br/><br/>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <center>
                    <img class="img-responsive" src="assets/img/email-banner.jpg" style="width:100%;height:200px; object-fit: cover;" /><br/><br/>
                    <h1 style="color: #cda45e !important;">Feedback Form</h1>
                    <h5 >Please fill up this form. We appreciate your time to take this feedback. Thank you</h5><br/>
                    <form method="POST" id="feedbackForm">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                        <div class="form-group">
                          <label>Full Name</label>
                          <input type="text" name="fullName" class="form-control" style="background-color: transparent !important; border:2px solid #cda45e;color:white;"/><br/>
                        </div>
                        <div class="form-group">
                          <label>Feedback & Suggestions:</label>
                          <textarea class="form-control" rows="5" name="feedback" style="background-color: transparent !important; border:2px solid #cda45e;color:white;"></textarea>
                        </div>
                        <div class="form-group">
                          <br/>
                          <input type="submit" name="submit" class="book-a-table-btn" style="background-color: transparent;" value="Submit" />
                        </div>
                    </form>
                    <br/>
                </center>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</main><!-- End #main -->

