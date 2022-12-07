<?php 
include("db.php");
include("includes/header.php");

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
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
                    <a class="nav-link text-start active eventdateLink" href="javascript:void(0)" id="v-pills-eventdate-tab" data-bs-toggle="pill" data-bs-target="#v-pills-eventdate" role="tab" aria-controls="v-pills-eventdate" aria-selected="true" data-index="1">
                        Event Date
                    </a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link text-start appointmentLink" href="javascript:void(0)" id="v-pills-appointment-tab" data-bs-toggle="pill" data-bs-target="#v-pills-appointment" role="tab" aria-controls="v-pills-appointment" aria-selected="false" data-index="2">
                        Appointment
                    </a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link text-start infoLink" href="javascript:void(0)" id="v-pills-info-tab" data-bs-toggle="pill" data-bs-target="#v-pills-info" role="tab" aria-controls="v-pills-info" aria-selected="false" data-index="3">
                        Info
                    </a>
                </li>
            </ul>

                <!-- Tabbed Content -->
                <div class="tab-content responsive-tab-content" id="v-pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="v-pills-eventdate" role="tabpanel" aria-labelledby="v-pills-eventdate-tab" tabindex="0"><br/>
                        <h5 style="margin-left:50px;">1. Please select first your event's date. <b>*</b></h5>
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
                        <h5 style="margin-left:50px;">2. Please set the best date and time for your appointment. <b>*</b></h5>
                         <div class="row" style="margin-top: 20px;">
                            <div class="col-md-6">
                                <div class="appointment-calendar" style="margin-bottom: 15px;"></div> 
                            </div>
                            <div class="col-md-6">
                                <span class="text-white">Time <b>*</b></span><br/>
                                <div class="time-list"><div class="alert" style="padding:3px;">Select date first to see available time.</div></div><br/>

                                <div class="form-group">
                                    <label>Appointment Venue <b>*</b></label>
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
                            <div class="row"style="margin-top: 20px;">
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Full Name <b>*</b></label>
                                        <input type="text" name="fullname" id="fullname" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email <b>*</b></label>
                                        <input type="text" name="email" id="emailadd" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Contact Number <b>*</b></label>
                                        <input type="number" name="contact" id="contact" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                    <div class="form-group">
                                        <label>Address <b>*</b></label>
                                        <input type="text" name="address" id="address" class="form-control"  style="background-color: transparent !important; border:2px solid #cda45e;color:white;" />
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div><br/>
                            <div class="float-end">
                                <button class="book-a-table-btn btn-submit" style="background-color: transparent;">Submit Appointment</button>
                            </div>
                            <div class="clearfix"></div>
                       </div>
                    </div>
                    <br/>
                    <div class="float-end">
                        <button id="previous"  type="button" style="background-color: transparent;color:#cda45e !important; border:none;font-size:30px;">
                            <i class="fa fa-less-than"></i>
                        </button>
                        <button id="next" type="button" style="background-color: transparent;color:#cda45e !important; border:none;font-size:30px;">
                            <i class="fa fa-greater-than"></i>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <br/>
                
            </div>
        </form>
      </div>
    </section><!-- End About Section -->

  </main><!-- End #main -->

<?php include("includes/footer.php"); ?>
<script>

    function showPrev(n){
        if(parseInt(n) == 1){
            $("#previous").hide();
        }else{
            $("#previous").show();
        }
    }

    function showNext(n){
        if(parseInt(n) == 3){
            $("#next").hide();
        }else{
            $("#next").show();
        }
    }

    showPrev(1);
    showNext(1);

   $('#next').on('click', function(event) {
    

    var mytabs =$("#v-pills-tab");
        oCuurentActive = $("#v-pills-tab li > a.active");      
      NextID = (parseInt($(oCuurentActive).attr('data-index')) + 1);

      // $(mytabs).find("li a").addClass('disabled');   
      $(mytabs).find("li a").removeClass('active');   
      $(mytabs).find("li a[data-index='"+NextID+"']").removeClass("disabled").addClass('active');

      if(oCuurentActive.hasClass('eventdateLink')){
        $(".tab-pane").removeClass("active");
        $(".tab-pane").removeClass("show");
        $("#v-pills-appointment").addClass("active");
        $("#v-pills-appointment").addClass("show");
      }

      if(oCuurentActive.hasClass('appointmentLink')){
        $(".tab-pane").removeClass("active");
        $(".tab-pane").removeClass("show");
        $("#v-pills-info").addClass("active");
        $("#v-pills-info").addClass("show");
      }

        showPrev(NextID);
        showNext(NextID);

    });

    $('#previous').on('click', function(event) {  
        var mytabs =$("#v-pills-tab");
        var  oCuurentActive = $("#v-pills-tab li > a.active");
        PreviousID = (parseInt($(oCuurentActive).attr('data-index')) - 1);
        // $(mytabs).find("li a").addClass('disabled');
        $(mytabs).find("li a").removeClass('active');   
        $(mytabs).find("li a[data-index='"+(PreviousID)+"']").removeClass("disabled").addClass('active');

        if(oCuurentActive.hasClass('appointmentLink')){
            $(".tab-pane").removeClass("active");
            $(".tab-pane").removeClass("show");
            $("#v-pills-eventdate").addClass("active");
            $("#v-pills-eventdate").addClass("show");
        }

          if(oCuurentActive.hasClass('infoLink')){
            $(".tab-pane").removeClass("active");
            $(".tab-pane").removeClass("show");
            $("#v-pills-appointment").addClass("active");
            $("#v-pills-appointment").addClass("show");
          }

        showPrev(PreviousID);
        showNext(PreviousID);
    });

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
        var text = '';

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

    function loadCalendar(){
        $.ajax({
            url     : 'ajax.php?action=bookedDates',
            method  :   'POST',
            dataType:   'JSON',
            success: function (data) {
               // Default Calendar
                $('.calendar').pignoseCalendar({
                    select: onClickHandler,
                    theme: 'dark',
                    minDate: "<?php echo date("Y-m-d", strtotime("+1 month")) ?>",
                    disabledDates: data.bookedDates
                });
            },
            error: function(res){
                console.log(res.responseText);
            }
        });
    } loadCalendar();

    

    function getTime(date, obj) {
        var $calendar = obj.calendar;
        var $box = $calendar.parent().siblings('.box').show();
        var text = '';

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
        var err = 0;

        if($("#eventDate").val() == ""){err = 1;}
        if($("#appointmentDate").val() == ""){err = 1;}
        if($("#fullname").val() == ""){err = 1;}
        if($("#emailadd").val() == ""){err = 1;}
        if($("#contact").val() == ""){err = 1;}
        if($("#address").val() == ""){err = 1;}

        console.log($("#eventDate").val());
        console.log($("#appointmentDate").val());
        console.log($("#fullname").val());
        console.log($("#emailadd").val());
        console.log($("#contact").val());
        console.log($("#address").val());

        if(err == 1){
            Swal.fire(
              'Ooopps...',
              'Fields with ( * ) are required!',
              'error'
            );
        }else{
            $.ajax({
                url     : 'ajax.php?action=saveAppointment',
                method  :   'POST',
                dataType:   'JSON',
                data    :   formdata,
                beforeSend: function(){
                    $(".btn-submit").prop("disabled",true);
                    $(".btn-submit").html("Please wait...");
                },
                success: function (data) {
                    if(data.success){
                        setTimeout(function(){
                            window.location.href = "appointment-success.php";
                        },1500);
                    }else{
                       Swal.fire(
                          'Ooopps...',
                          data.msg,
                          'error'
                        );
                       $(".btn-submit").prop("disabled",false);
                       $(".btn-submit").html("Submit Appointment");
                    }
                },
                error: function(res){
                    console.log(res.responseText);
                    $(".btn-submit").prop("disabled",false);
                    $(".btn-submit").html("Submit Appointment");
                }
            });
        }
    });
</script>