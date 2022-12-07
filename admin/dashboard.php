<?php
include("includes/header.php");

$active = "dashboard";

include("includes/sidetop.php");

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                          <div class="card-body" style="background-color: #cda45e; color: white">
                            <div class="lead"><h4><b>Upcoming Appointments</b></h4></div>
                            <?php
                                $sql = "SELECT COUNT(*) as totalAppointments FROM appointments WHERE Status = 'Approved'";
                                $process = $db->query($sql);
                                $totalAppointments = $process->fetch_assoc()['totalAppointments'];
                                echo "<h2 class='card-title'>".$totalAppointments."</h2>";
                            ?>
                            <!-- <p class="small text-muted">Oct 1 - Dec 31,<i class="fa fa-globe"></i> Worldwide</p> -->
                        </div>
                    </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="card">
                          <div class="card-body" style="background-color: #153D28; color: white">
                            <div class="lead"><h4><b>Booked Events</b></h4></div>
                            <?php
                                $sql = "SELECT COUNT(*) as totalAppointments FROM appointments WHERE Status = 'EventBooked'";
                                $process = $db->query($sql);
                                $totalAppointments = $process->fetch_assoc()['totalAppointments'];
                                echo "<h2 class='card-title'>".$totalAppointments."</h2>";
                            ?>
                            <!-- <p class="small text-muted">Oct 1 - Dec 31,<i class="fa fa-globe"></i> Worldwide</p> -->
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                          <div class="card-body" style="background-color: #5f6944; color: white">
                            <div class="lead"><h4><b>Finished Events</b></h4></div>
                            <?php
                                $sql = "SELECT COUNT(*) as totalAppointments FROM appointments WHERE Status = 'Done'";
                                $process = $db->query($sql);
                                $totalAppointments = $process->fetch_assoc()['totalAppointments'];
                                echo "<h2 class='card-title'>".$totalAppointments."</h2>";
                            ?>
                            <!-- <p class="small text-muted">Oct 1 - Dec 31,<i class="fa fa-globe"></i> Worldwide</p> -->
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3>Appointments Today</h3>
                        <div class="appointment-list"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h3>Events Today</h3>
                        <div class="event-list"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    
</div>

<?php include("includes/footer.php") ?>

<script>
    function appointmentsToday(){
        $.ajax({
            url     : '../ajax.php?action=appointmentsToday',
            method  :   'POST',
            dataType:   'JSON',
            success: function (data) {
               $(".appointment-list").html(data.output);
            },
            error: function(res){
                console.log(res.responseText);
            }
        });
    } appointmentsToday();
    function eventsToday(){
        $.ajax({
            url     : '../ajax.php?action=eventsToday',
            method  :   'POST',
            dataType:   'JSON',
            success: function (data) {
               $(".event-list").html(data.output);
            },
            error: function(res){
                console.log(res.responseText);
            }
        });
    } eventsToday();

</script>