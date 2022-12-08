<?php
include("includes/header.php");

$active = "inclussions";

include("includes/sidetop.php");



$event = isset($_POST['event']) ? $_POST['event'] : "";
$from = isset($_POST['from']) ? $_POST['from'] : "";
$to = isset($_POST['to']) ? $_POST['to'] : "";

$eventFilter = ($event != "" && $event != "all") ? " AND events.ID = ".$event." " : "";

$dateFilter = ($from != "" && $to != "") ? " AND Date(appointments.DateTimeAdded) BETWEEN '".date('Y-m-d',strtotime($from))."' AND '".date('Y-m-d',strtotime($to))."' " : "";



?>

<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Reports</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Reports</a></li>
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
                <div class="white-box">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Event</label>
                                <select class="form-control" name="event" id="event">
                                    <option value="all">All</option>
                                    <?php
                                        $sql = "SELECT * FROM events";
                                        $process = $db->query($sql);
                                        if($process->num_rows > 0){
                                            while($row = $process->fetch_assoc()){
                                                $selected = ($event == $row['ID']) ? "selected" : "";
                                                echo "<option value='".$row['ID']."' ".$selected.">".$row['Event']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From</label>
                                    <input type="date" name="from" id="from" class="form-control" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : "" ?>" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="date" name="to" id="to" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : "" ?>" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><br/>
                                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-md" style="width: 100%;margin-top:5px;" value="Filter" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="white-box">
                    <div class="table-responsive mt-2">

                        <table class="table table-bordered" id="table" >
                            <thead>
                                <th>Event</th>
                                <th>Total Pending</th>
                                <th>Total Approved</th>
                                <th>Total Cancelled</th>
                                <th>Total Done</th>
                                <th>Total Booked</th>
                            </thead>
                            <tbody>
                                <?php

                                    $where = " WHERE 1=1 ".$eventFilter." ".$dateFilter;
                                    $sql = "SELECT events.Event as eventName,  COUNT(CASE WHEN appointments.Status = 'Approved' then 1 else NULL end) as TOTALAPP,COUNT(CASE WHEN appointments.Status = 'Pending' then 1 else NULL end) as TOTALPEN,COUNT(CASE WHEN appointments.Status = 'EventCancelled' then 1 else NULL end) as TOTALCAN ,COUNT(CASE WHEN appointments.Status = 'Done' then 1 else NULL end) as TOTALDONE,COUNT(CASE WHEN appointments.Status = 'EventBooked' then 1 else NULL end) as TOTALBOOKED FROM appointments JOIN events ON events.ID = appointments.Event ".$where." GROUP BY appointments.Event";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){
                                            echo "<tr>";
                                                echo "<td>".$result['eventName']."</td>";
                                                echo "<td>".$result['TOTALPEN']."</td>";
                                                echo "<td>".$result['TOTALAPP']."</td>";
                                                echo "<td>".$result['TOTALCAN']."</td>";
                                                echo "<td>".$result['TOTALDONE']."</td>";
                                                echo "<td>".$result['TOTALBOOKED']."</td>";
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr><td colspan='6'>No Data Found</td></td>";
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
    // $("#table").DataTable();

</script>