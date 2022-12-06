<?php 
include("db.php");
include("includes/header.php");


$event = isset($_GET['event']) ? $_GET['event'] : "";
if($event == "") { echo "<script>window.location.href = 'index.php';</script>"; }

$eventInfo = array();
$eventSql = "SELECT events.*,packages.Categories,packages.Inclussions,packages.ID as packageId FROM events JOIN packages ON events.ID = packages.Event WHERE events.ID = ".$event;
$processEvent = $db->query($eventSql);
if($processEvent->num_rows == 0){
    echo "<script>window.location.href = 'index.php';</script>";
}else{
    $eventInfo = $processEvent->fetch_assoc();
}

$categoriesSql = "SELECT * FROM categories WHERE ID IN (".implode(',',json_decode($eventInfo['Categories'],true)).")";
$processCategories = $db->query($categoriesSql);

$inclussions = implode(',',json_decode($eventInfo['Inclussions'],true));


?>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-cente">
<div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

  <!-- <h1 class="logo me-auto me-lg-0"><a href="index.php">The Events Production</a></h1> -->
  <!-- Uncomment below if you prefer to use an image logo -->
   <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.jpg" alt="" class="img-fluid"></a>

  <nav id="navbar" class="navbar order-last order-lg-0">
    <ul>
      <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
      <li><a class="nav-link scrollto" href="index.php#about">About</a></li>
      <li><a class="nav-link scrollto" href="index.php#events">Events</a></li>
      <li><a class="nav-link scrollto" href="index.php#testimonials">Feedbacks</a></li>
      <li><a class="nav-link scrollto" href="index.php#gallery">Gallery</a></li>
      <!-- <li><a class="nav-link scrollto" href="#contact">Contact</a></li> -->
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
  </nav><!-- .navbar -->
  <a href="index.php#book-an-appointment" class="book-a-table-btn scrollto d-none d-lg-flex">Book an appointment</a>

</div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-10">
          <h1>Welcome to <span>The Events Production</span></h1>
          <h2>Let us handle your most important events in your life. We will make it remarkable in everyone's memory</h2>

          <div class="btns">
            <a href="index.php#book-an-appointment" class="btn-book animated fadeInUp scrollto">Book an appointment</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section class="about">
      <div class="container" data-aos="fade-up">
      	
        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
            <div class="about-img">
              <img src="assets/img/event_thumbs/<?php echo $eventInfo['Image']?>" alt="" style="min-height: 400px;object-fit: cover;">
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
          	<h3><?php echo $eventInfo['Event']?></h3>
            <p class="mt-4" style="text-align: justify;text-indent: 10%;line-height: 40px;font-size:18px;font-family: 'Playfair Display', serif;">
                <?php echo $eventInfo['Description']?>
            </p>
          </div>
        </div><br/><br/>
        <center>
            <h2>Package</h2><br/>
            <div class="row">
                <?php
                    while($row = $processCategories->fetch_assoc()){
                        ?>
                        <div class="col-md-3">
                            <h4 style="color: #cda45e;"><?php echo $row['Category']?></h4>
                        <?php

                        $sqlInclussions = "SELECT * FROM offers WHERE Category = ".$row['ID']." AND ID IN (".$inclussions.") ";
                        $processInclussions = $db->query($sqlInclussions);
                        if($processInclussions->num_rows > 0){
                            echo "<ul>";
                            while($res = $processInclussions->fetch_assoc()){
                                echo "<li><span class='text-white'>".$res['Offer']."</span></li>";
                            }
                            echo "</ul>";
                        }
                        ?>
                        </div>
                        <?php
                    }

                ?>
            </div>

        </center>
        <div class="row mt-2">
            <div class="col-lg-12"></div>
        </div>
      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->

<?php include("includes/footer.php"); ?>