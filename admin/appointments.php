<?php
include("includes/header.php");

$active = "inclussions";

include("includes/sidetop.php");
?>
<style>
    @media (max-width: 767px) {
        .table-responsive .dropdown-menu {
            position: static !important;
        }
    }
    @media (min-width: 768px) {
        .table-responsive {
            overflow: visible;
        }
    }
</style>

<!-- Decline Modal -->
<div class="modal fade" id="declineModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="declineForm">
            <input type="hidden" name="id" id="appointmentId" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineModalLabel">Decline Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Decline Reason</label>
                        <textarea name="reason" class="form-control" rows="7" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-decline">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Info</h5>
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
                <h4 class="page-title">Appointments</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Appointments</a></li>
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
        <div class="row mt-2">
            <div class="col-md-12">
                <span><b>Filter</b></span>
                <form method="POST">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Event</label>
                                    <select class="form-control" name="event" id="event" onchange='this.form.submit()'>
                                        <option>All</option>
                                        <?php

                                            $sqlEvent = "SELECT * FROM events";
                                            $process = $db->query($sqlEvent);
                                            if($process->num_rows > 0){
                                                while($row = $process->fetch_assoc()){
                                                    $selected = (isset($_POST['event']) && $_POST['event'] == $row['ID']) ? "selected" : "";
                                                    echo "<option ".$selected." value='".$row['ID']."'>".$row['Event']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" id="status" onchange='this.form.submit()'>
                                        <option>All</option>
                                        <?php
                                            $sqlStatus = "SELECT DISTINCT(Status) as appointmentStatus FROM appointments";
                                            $process = $db->query($sqlStatus);
                                            if($process->num_rows > 0){
                                                while($row = $process->fetch_assoc()){
                                                    $selected = (isset($_POST['status']) && $_POST['status'] == $row['appointmentStatus']) ? "selected" : "";
                                                    echo "<option value='".$row['appointmentStatus']."' ".$selected.">".$row['appointmentStatus']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="white-box">
                    <h4 class="form-title"><b>Appointment List</b></h4>
                    <div class="table-responsive mt-2">
                        <table class="table" id="table" data-ordering="false">
                            <thead>
                                <th>Name</th>
                                <th>Event</th>
                                <th>Event Date</th>
                                <th>Appointment Info</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th style="text-align: center;"></th>
                            </thead>
                            <tbody>
                                <?php

                                    $eventFilter = (isset($_POST['event']) && $_POST['event'] != "All") ? " AND appointments.Event = ".$_POST['event'] : "";
                                    $statusFilter = (isset($_POST['status']) && $_POST['status'] != "All") ? " AND appointments.Status = '".$_POST['status']."'" : "";

                                    $sql = "SELECT appointments.*,events.Event as eventName,events.Status as eventStatus,places.Place FROM appointments 
                                        JOIN events ON events.ID = appointments.Event 
                                        JOIN places ON places.ID = appointments.AppointmentPlace WHERE 1=1 ".$eventFilter." ".$statusFilter." ORDER BY DateTimeAdded DESC";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){

                                            if(in_array($result['Status'],array("Approved","Declined"))){
                                                if($result['Status'] == "Approved"){
                                                    $action = '
                                                        <div class="dropdown">
                                                          <button type="button" data-bs-boundary="viewport"  class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                                Action
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item action-view" data-id="'.$result['ID'].'" href="javascript:void(0)">View</a></li>
                                                            
                                                            <li><a class="dropdown-item action-confirm" data-id="'.$result['ID'].'" href="javascript:void(0)">Confirm Event Date</a></li>
                                                            <li><a class="dropdown-item action-cancel" data-id="'.$result['ID'].'" href="javascript:void(0)">Cancel</a></li>
                                                          </ul>
                                                        </div>
                                                    ';
                                                }else{
                                                    $action = '
                                                        <div class="dropdown">
                                                          <button type="button" data-bs-boundary="viewport"  class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                                Action
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item action-view" data-id="'.$result['ID'].'" href="javascript:void(0)">View</a></li>
                                                          </ul>
                                                        </div>
                                                    ';
                                                }
                                                    
                                            }else{

                                                if($result['Status'] == "Pending"){
                                                    $action = '
                                                        <div class="dropdown">
                                                          <button type="button" data-bs-boundary="viewport"  class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                                Action
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item action-view" data-id="'.$result['ID'].'" href="javascript:void(0)">View</a></li>
                                                            <li><a class="dropdown-item action-approve" data-id="'.$result['ID'].'" href="javascript:void(0)">Approve</a></li>
                                                            <li><a class="dropdown-item action-decline" data-id="'.$result['ID'].'" href="javascript:void(0)">Decline</a></li>
                                                          </ul>
                                                        </div>
                                                    ';
                                                }elseif($result['Status'] == "EventBooked"){
                                                    $action = '
                                                        <div class="dropdown">
                                                          <button type="button" data-bs-boundary="viewport"  class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                                Action
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item action-view" data-id="'.$result['ID'].'" href="javascript:void(0)">View</a></li>
                                                            <li><a class="dropdown-item action-done" data-id="'.$result['ID'].'" href="javascript:void(0)">Done</a></li>
                                                          </ul>
                                                        </div>
                                                    ';
                                                }else{
                                                    $action = '
                                                        <div class="dropdown">
                                                          <button type="button" data-bs-boundary="viewport"  class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                                Action
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item action-view" data-id="'.$result['ID'].'" href="javascript:void(0)">View</a></li>
                                                          </ul>
                                                        </div>
                                                    ';
                                                }
                                            }
                                            
                                            $status = "";
                                            if($result['Status'] == "Pending") { $status = "<span class='badge bg-warning'>Pending</span>";}
                                            if($result['Status'] == "Approved") { $status = "<span class='badge bg-info'>Approved</span>";}
                                            if($result['Status'] == "Declined") { $status = "<span class='badge bg-danger'>Declined</span>";}
                                            if($result['Status'] == "EventBooked") { $status = "<span class='badge bg-info'>Date Booked</span>";}
                                            if($result['Status'] == "EventCancelled") { $status = "<span class='badge bg-danger'>Cancelled</span>";}
                                            if($result['Status'] == "Done") { $status = "<span class='badge bg-success'>Done</span>";}

                                            echo "<tr style='font-size: 13px !important;'>";
                                                echo "<td>".$result['FullName']."</td>";
                                                echo "<td>".$result['eventName']."</td>";
                                                echo "<td>".date('M d, Y',strtotime($result['EventDate']))."</td>";
                                                echo "<td>".date('M d, Y',strtotime($result['AppointmentDate']))." (".$result['AppointmentTime'].")<br/>".$result['Place']."</td>";
                                                echo "<td>".$result['Contact']."</td>";
                                                echo "<td>".$result['Email']."</td>";
                                                echo "<td>".date('M d, Y h:i A',strtotime($result['DateTimeAdded']))."</td>";
                                                echo "<td>".$status."</td>";
                                                echo "<td>".$action."</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>
                            </tbody>
                        </table>
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
    $("#table").DataTable();

    $(document).on("click",".btn-edit",function(){
        var id = $(this).data("id");
        var category = $(this).data("category");
        $(".form-title").html("Update Category");
        $("#categoryId").val(id);
        $("#category").val(category);
        $("#savecategory").hide();
        $("#updatecategory").show();
        $("#btnAddNew").show();
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    //approve
    $(document).on("click",".action-approve",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This appointment will be approved.",
            icon: 'question',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=approveAppointment',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            Swal.fire({
                                title: 'Great',
                                icon: 'success',
                                text: "Appointment Approved!",
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                     window.location.href = "appointments.php";
                                }
                            })

                        }else{
                            alert(data.msg);
                        }
                    },
                    error: function(res){
                        console.log(res.responseText);
                    }
                });
            }
        });
    });

    //decline
    $(document).on("click",".action-decline",function(){
        var id = $(this).data("id");
        $("#declineModal #appointmentId").val(id);
        $("#declineModal").modal("toggle");
    });

    $(document).on("submit","#declineForm",function(e){
        e.preventDefault();
        var formdata = $(this).serialize();
        $.ajax({
            url     : '../ajax.php?action=declineAppointment',
            method  :   'POST',
            dataType:   'JSON',
            data    :   formdata,
            beforeSend: function(){
                $(".btn-decline").prop("disabled",true);
                $(".btn-decline").html("Please wait...");
            },
            success: function (data) {
                if(data.success){
                    Swal.fire(
                      'Great',
                      'Appointment declined!',
                      'success'
                    );
                    setTimeout(function(){
                        window.location.href = "appointments.php";
                    },1500);
                }else{
                   Swal.fire(
                      'Ooopps...',
                      data.msg,
                      'error'
                    );
                   $(".btn-decline").prop("disabled",false);
                   $(".btn-decline").html("Submit");
                }
            },
            error: function(res){
                console.log(res.responseText);
                $(".btn-decline").prop("disabled",false);
                $(".btn-decline").html("Submit");
            }
        });
    });

    //view
    $(document).on("click",".action-view",function(){
        var id = $(this).data("id");
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
    });

    //event booked
    $(document).on("click",".action-confirm",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This event booking will be confirmed.",
            icon: 'question',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=bookedEvent',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            Swal.fire({
                                title: 'Great',
                                icon: 'success',
                                text: "Event booked!",
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                     window.location.href = "appointments.php";
                                }
                            })

                        }else{
                            alert(data.msg);
                        }
                    },
                    error: function(res){
                        console.log(res.responseText);
                    }
                });
            }
        });
    });

    //event cancelled
    $(document).on("click",".action-cancel",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This event booking will be cancelled.",
            icon: 'question',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=cancelBooking',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            Swal.fire({
                                title: 'Great',
                                icon: 'success',
                                text: "Event cancelled!",
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                     window.location.href = "appointments.php";
                                }
                            })

                        }else{
                            alert(data.msg);
                        }
                    },
                    error: function(res){
                        console.log(res.responseText);
                    }
                });
            }
        });
    });

    //event cancelled
    $(document).on("click",".action-done",function(){
        var id = $(this).data("id");
        $.ajax({
            url     : '../ajax.php?action=markAsDone',
            method  :   'POST',
            dataType:   'JSON',
            data    :   {id:id},
            success: function (data) {
                console.log(data);
                if(data.success){
                    Swal.fire({
                        title: 'Great',
                        icon: 'success',
                        text: "Event finished!",
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                             window.location.href = "appointments.php";
                        }
                    })

                }else{
                    alert(data.msg);
                }
            },
            error: function(res){
                console.log(res.responseText);
            }
        });
    });

</script>