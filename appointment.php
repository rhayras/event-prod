<?php 
include("db.php");
include("includes/header.php");

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
  <!-- <a href="index.php#book-an-appointment" class="book-a-table-btn scrollto d-none d-lg-flex">Book an appointment</a> -->

</div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-10">
          <h1>Welcome to <span>The Events Production</span></h1>
          <h2>Let us handle your most important events in your life. We will make it remarkable in everyone's memory</h2>

         
        </div>
      </div>
    </div>
  </section><!-- End Hero -->
    <main id="main">

    <!-- ======= About Section ======= -->
    <section class="about">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Reservation</h2>
          <p>Book an Appointment</p>
        </div>
        <form method="POST" id="appointmentForm">
            <input type="hidden" name="eventDate" id="eventDate" />
            <input type="hidden" name="appointmentDate" id="appointmentDate" />

            <div class="d-flex align-items-start responsive-tab-menu">
                <!-- Tabs/Pills -->
                <ul class="nav flex-column nav-pills nav-tabs-dropdown me-3" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">
                <li class="nav-item">
                    <a class="nav-link text-start active" href="#" id="v-pills-eventdate-tab" data-bs-toggle="pill" data-bs-target="#v-pills-eventdate" role="tab" aria-controls="v-pills-eventdate" aria-selected="true">
                        Event Date
                    </a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link text-start" href="#" id="v-pills-appointment-tab" data-bs-toggle="pill" data-bs-target="#v-pills-appointment" role="tab" aria-controls="v-pills-appointment" aria-selected="false">
                        Appointment
                    </a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link text-start" href="#" id="v-pills-info-tab" data-bs-toggle="pill" data-bs-target="#v-pills-info" role="tab" aria-controls="v-pills-appointment" aria-selected="false">
                        Info
                    </a>
                </li>
            </ul>
                <!-- Tabbed Content -->
                <div class="tab-content responsive-tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-eventdate" role="tabpanel" aria-labelledby="v-pills-eventdate-tab" tabindex="0"><br/>
                        <h5 style="margin-left:50px;">1. Please select first your event's date</h5>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-6">
                                <div class="calendar" style="margin-bottom: 15px;"></div> 
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                   <label>Choose your event type </label>
                                   <select class="form-control" name="eventType" id="eventType"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;">
                                        <?php
                                        $sqlEvent = "SELECT * FROM events";
                                        $process = $db->query($sqlEvent);
                                        if($process->num_rows > 0){
                                            while($row = $process->fetch_assoc()){
                                                echo "<option style='color:black !important;' value='".$row['ID']."'>".$row['Event']."</option>";
                                            }
                                        }
                                    ?>
                                   </select>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-appointment" role="tabpanel" aria-labelledby="v-pills-appointment-tab" tabindex="0">
                        <br/>
                        <h5 style="margin-left:50px;">2. Please set the best date and time for your appointment.</h5>
                         <div class="row" style="margin-top: 20px;">
                            <div class="col-md-6">
                                <div class="appointment-calendar" style="margin-bottom: 15px;"></div> 
                            </div>
                            <div class="col-md-6">
                                <span class="text-white">Time</span><br/>
                                <div class="time-list"><div class="alert" style="padding:3px;">Select date first to see available time.</div></div><br/>

                                <div class="form-group">
                                    <label>Appointment Venue</label>
                                    <select class="form-control" name="place" id="place" style="background-color: transparent !important; border:2px solid #cda45e;color:white;">
                                        <?php
                                            $sqlPlace = "SELECT * FROM places";
                                            $processPlace = $db->query($sqlPlace);
                                            if($processPlace->num_rows > 0){
                                                while($rowPlace = $processPlace->fetch_assoc()){
                                                    echo "<option style='color:black !important;' value='".$rowPlace['ID']."'>".$rowPlace['Place']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-appointment-tab" tabindex="0">
                        <br/>
                        <h5 style="margin-left:50px;">3. Please enter some of your information.</h5>
                        <div class="container">
                            <div class="row"style="margin-top: 20px;margin-left:30px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" name="fullname" id="fullname" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" id="email" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="number" name="contact" id="contact" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" id="address" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                </div>
                            </div><br/>
                            <div class="float-end">
                                <button class="book-a-table-btn" style="background-color: transparent;">Submit Appointment</button>
                            </div>
                            <div class="clearfix"></div>
                       </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->

<?php include("includes/footer.php"); ?>
<script>
    $('.nav-tabs-dropdown')
  .on("click", ".nav-link:not('.active')", function (event) {
    $(this).closest('ul').removeClass("open");
  })
  .on("click", ".nav-link.active", function (event) {
    $(this).closest('ul').toggleClass("open");
  });
  function onClickHandler(date, obj) {
        /**
         * @date is an array which be included dates(clicked date at first index)
         * @obj is an object which stored calendar interal data.
         * @obj.calendar is an element reference.
         * @obj.storage.activeDates is all toggled data, If you use toggle type calendar.
         * @obj.storage.events is all events associated to this date
         */

        var $calendar = obj.calendar;
        var $box = $calendar.parent().siblings('.box').show();
        var text = 'You choose date ';

        if(date[0] !== null) {
            text += date[0].format('YYYY-MM-DD');
        }

        if(date[0] !== null && date[1] !== null) {
            text += ' ~ ';
        } else if(date[0] === null && date[1] == null) {
            text += 'nothing';
        }

        if(date[1] !== null) {
            text += date[1].format('YYYY-MM-DD');
        }

        $("#eventDate").val(text);
        // setTimeout(function(){
        //     $(".appointmentLink").click();
        // },1300);
    }

    // Default Calendar
    $('.calendar').pignoseCalendar({
        select: onClickHandler,
        theme: 'dark',
        minDate: "<?php echo date("Y-m-d", strtotime("+1 month")) ?>",
        // disabledDates: [
        //     '2022-12-08'
        // ]
    });

    function getTime(date, obj) {
        var $calendar = obj.calendar;
        var $box = $calendar.parent().siblings('.box').show();
        var text = 'You choose date ';

        if(date[0] !== null) {
            text += date[0].format('YYYY-MM-DD');
        }

        if(date[0] !== null && date[1] !== null) {
            text += ' ~ ';
        } else if(date[0] === null && date[1] == null) {
            text += 'nothing';
        }

        if(date[1] !== null) {
            text += date[1].format('YYYY-MM-DD');
        }

        $("#appointmentDate").val(text);

        $.ajax({
            url     : 'ajax.php?action=getAvailableTime',
            method  :   'POST',
            dataType:   'JSON',
            data    :   {date:text},
            success: function (data) {
                $(".time-list").html(data.output);
            },
            error: function(res){
                console.log(res.responseText);
            }
        });
    }

    $('.appointment-calendar').pignoseCalendar({
        select: getTime,
        theme: 'dark',
        minDate: "<?php echo date("Y-m-d", strtotime("+4 days")) ?>",
        // disabledDates: [
        //     '2022-12-08'
        // ]
    });

    $(document).on("submit","#appointmentForm",function(e){
        e.preventDefault();
        var formdata = $(this).serialize();
        
    });
</script>