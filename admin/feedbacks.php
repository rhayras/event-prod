<?php
include("includes/header.php");

$active = "feedbacks";

include("includes/sidetop.php");

?>

<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Feedbacks</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Feedbacks</a></li>
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
                    <h4 class="form-title"><b>Feedbacks List</b></h4>
                    <div class="table-responsive mt-2">
                        <table class="table" id="table" >
                            <thead>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Date Added</th>
                                <th>Feedback</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT *FROM feedbacks";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){
                                           $action = "<a href='javascript:void(0)' class='hide-feedback' data-id='".$result['ID']."' title='Hide to Website'><i class='fa fa-toggle-on'></i></a>";


                                            if($result['Status'] == 0){
                                                $action = "<a href='javascript:void(0)' class='display-feedback' data-id='".$result['ID']."' title='Display to Website'><i class='fa fa-toggle-off'></i></a>";
                                            }
                                            echo "<tr>";
                                                echo "<td>".$result['Email']."</td>";
                                                echo "<td>".$result['Fullname']."</td>";
                                                echo "<td>".date('M d, Y h:i A',strtotime($result['DateAdded']))."</td>";
                                                echo "<td>".$result['Feedback']."</td>";
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

    $(document).on("click",".display-feedback",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This will be shown to website.",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=showFeedback',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "feedbacks.php";
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

    $(document).on("click",".hide-feedback",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "This will be hidden to website.",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=hideFeedback',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "feedbacks.php";
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