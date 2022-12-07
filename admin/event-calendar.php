<?php
include("includes/header.php");

$active = "inclussions";

include("includes/sidetop.php");
?>

<link rel="stylesheet" type="text/css" href="plugins/bower_components/fullcalendar/main.min.css" />
<style>
    .fc .fc-button-primary,.fc .fc-button-primary:hover{
        background-color: #153D28 !important;
        border: 1px solid #153D28 !important;
    }
    .fc-daygrid-event{
        background-color: #cda45e !important;
        border: 1px solid #cda45e !important;
    }
</style>
<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Event Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Event Calendar</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Event Calendar</a></li>
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
        <div class="clearfix"></div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="white-box">
                     <div id='calendar'></div>
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
<script src="plugins/bower_components/fullcalendar/main.js"></script>
<script>

    function loadCalendar(){
        $.ajax({
            url     : '../ajax.php?action=bookedDatesCalendar',
            method  :   'POST',
            dataType:   'JSON',
            success: function (data) {
                console.log(data);
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    // initialDate: '2020-09-12',
                    navLinks: true, 
                    selectMirror: true,
                    eventClick: function(info) {
                        var id = info.event.id;
                        $.ajax({
                            url     : '../ajax.php?action=viewAppointment',
                            method  :   'POST',
                            dataType:   'JSON',
                            data    :   {id:id},
                            success: function (data) {
                                $("#viewAppointmentModal .modal-body").html(data.output);
                                $("#viewAppointmentModal").modal("toggle");
                            },
                            error: function(res){
                                console.log(res.responseText);
                            }
                        });
                    },
                    dayMaxEvents: true, // allow "more" link when too many events
                    events: data.events
                });
                calendar.render();
            },
            error: function(res){
                console.log(res.responseText);
            }
        });
    } loadCalendar();


</script>