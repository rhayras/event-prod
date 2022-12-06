<?php 
include("db.php");
include("includes/header.php");
include("includes/topbar.php");
?>


<!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-10">
          <h1>Welcome to <span>The Events Production</span></h1>
          <h2>Let us handle your most important events in your life. We will make it remarkable in everyone's memory</h2>

          <div class="btns">
            <a href="#about" class="btn-menu animated fadeInUp scrollto">About Us</a>
            <a href="#book-an-appointment" class="btn-book animated fadeInUp scrollto">Book an appointment</a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
      	
        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
            <div class="about-img">
              <img src="assets/img/corporate-3.jpg" alt="" style="min-height: 400px;object-fit: cover;">
            </div>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
          	<h3>Who are we?</h3>
            <p class="mt-4" style="text-align: justify;text-indent: 10%;line-height: 40px;font-size:18px;font-family: 'Playfair Display', serif;"><span style="color: #cda45e;text-decoration: underline;">The Events Production</span> is a management that create and develop a small and/or large-scale personal or corporate events such as festivals, conference, ceremonies,weddings, debut, formal parties, corporate, or conventions. 
            </p>
            <p style="text-align: justify;text-indent: 10%;line-height: 40px;;font-size:18px;font-family: 'Playfair Display', serif;">It involves studying the brand, identifying its target audience, diversing the event concept, and coordinating the technical aspects before actually launching the event.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Events Section ======= -->
    <section id="events" class="events">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Events</h2>
          <p>Organize Your Events with our Team!</p>
        </div>

        <div class="events-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                <?php
                $eventSql = "SELECT events.*,packages.Categories,packages.Inclussions,packages.ID as packageId FROM events JOIN packages ON events.ID = packages.Event";
                $processEvent = $db->query($eventSql);
                if($processEvent->num_rows > 0){
                    while($row = $processEvent->fetch_assoc()){
                        ?>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="col-lg-6">
                                    <img src="assets/img/event_thumbs/<?php echo $row['Image']?>" class="img-fluid" alt="">
                                </div>
                                <div class="col-lg-6 pt-4 pt-lg-0 content">
                                    <h3><?php echo $row['Event']?></h3>
                                    <p class="fst-italic">
                                        <?php echo $row['Description']?>
                                    </p><br/>
                                    <a href="view-event.php?event=<?php echo $row['ID']?>" class="book-a-table-btn">View Event Package</a>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->
                        <?php
                    }
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Events Section -->

    <!-- ======= Book A Appointment Section ======= -->
    <section id="book-an-appointment" class="book-an-appointment">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Reservation</h2>
          <p>Book an Appointment</p>
        </div>
        <h5>Handling the Stress so Your Event is a Success! Book your appointment with us now!</h5><br/>
        <a href="appointment.php" class="book-a-table-btn" style="margin-left: -6px;">BOOK NOW</a>
      </div>
    </section><!-- End Book A Appointment Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Testimonials</h2>
          <p>What they're saying about us</p>
        </div>

        <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">

      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Gallery</h2>
          <p>Some photos from Our Events</p>
        </div>
      </div>

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">
        <?php
            $sqlImage = "SELECT * FROM gallery ORDER BY rand()";
            $processImage = $db->query($sqlImage);
            if($processImage->num_rows > 0){
                while($row = $processImage->fetch_assoc()){
                    ?>
                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item" style="height: 300px;">
                          <a href="assets/img/gallery/<?php echo $row['image']?>" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="assets/img/gallery/<?php echo $row['image']?>" alt="" class="img-fluid" style="height: 100%;object-fit: cover;">
                          </a>
                        </div>
                      </div>
                    <?php
                }
            }

        ?>
        </div>

      </div>
    </section><!-- End Gallery Section -->

  </main><!-- End #main -->

<?php include("includes/footer.php"); ?>
