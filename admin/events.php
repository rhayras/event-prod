<?php
include("includes/header.php");

$active = "events";

include("includes/sidetop.php");

?>

<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Events</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Events</a></li>
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
        <div class="float-end">
            <a class="btn btn-primary" href="add-event.php">Add New</a>
        </div>
        <div class="clearfix"></div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="white-box">
                    <h4 class="form-title"><b>Event List</b></h4>
                    <div class="table-responsive mt-2">
                        <table class="table" id="table" >
                            <thead>
                                <th>Event</th>
                                <th>Description</th>
                                <th>Date Added</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM events ";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){
                                            $action = "<a href='edit-event.php?id=".$result['ID']."' class='btn btn-secondary btn-sm btn-edit'><i class='fa fa-edit'></i></a>";
                                            $action .= "<a href='javascript:void(0)' data-id='".$result['ID']."' class='text-white btn btn-danger btn-sm btn-delete'><i class='fa fa-trash-alt'></i></a>";
                                            echo "<tr>";
                                                echo "<td>".$result['Event']."</td>";
                                                echo "<td><small>".$result['Description']."</small></td>";
                                                echo "<td>".date('M d, Y h:i A',strtotime($result['DateAdded']))."</td>";
                                                echo "<td><center>".$action."</center></td>";
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

    $(document).on("click",".btn-delete",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "Event will be deleted",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=deleteEvent',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "events.php";
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

</script>