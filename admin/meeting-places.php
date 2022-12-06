<?php
include("includes/header.php");

$active = "inclussions";

include("includes/sidetop.php");

if(isset($_POST['saveplace'])){
    $place = $db->escape_string(trim($_POST['place']));

    $sql = "SELECT * FROM places WHERE Place = '".$place."'";
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Place already exist!');</script>";
    }else{
        $insert = "INSERT INTO places (Place) VALUES ('".$place."')";
        $processInsert = $db->query($insert);
        if($processInsert){
            echo "<script>alert('Place saved successfully!');</script>";
        }else{
             echo "<script>alert(".$insert.");</script>";
            // echo $insert
        }
    }

}

if(isset($_POST['updateplace'])){
    $place = $db->escape_string(trim($_POST['place']));
    $id = $_POST['id'];
    $sql = "SELECT * FROM places WHERE Place = '".$place."' AND ID != ".$id;
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Place already exist!');</script>";
    }else{
        $update = "UPDATE places set Place = '".$place."' WHERE ID = ".$id;
        $processUpdate = $db->query($update);
        if($processUpdate){
            echo "<script>alert('Place updated successfully!');</script>";
        }else{
             echo "<script>alert(".$update.");</script>";
        }
    }
}

?>

<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Meeting Places</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Meeting Places</a></li>
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
                    <form method="POST" id="placeForm">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="form-title" style="font-weight:bold;">Add New Place</h4>
                                <div class="form-group">
                                    <label>Place</label>
                                    <input type="hidden" name="id" id="placeId" />
                                    <input type="text" name="place" id="place" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="saveplace" id="saveplace" value="Save" class="btn btn-secondary" />
                                    <input type="submit" name="updateplace" id="updateplace" value="Save Change" class="btn btn-secondary" style="display: none;" />
                                    <a class="btn btn-primary" style="display: none;" id="btnAddNew" href="meeting-places.php">Add New</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box">
                    <h4 class="form-title"><b>Place List</b></h4>
                    <div class="table-responsive mt-2">
                        <table class="table" id="table" >
                            <thead>
                                <th>Place</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM places ";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){
                                            $action = "<a href='javascript:void(0)' data-id='".$result['ID']."' data-place='".$result['Place']."' class='btn btn-secondary btn-sm btn-edit'><i class='fa fa-edit'></i></a>";
                                            $action .= "<a href='javascript:void(0)' data-id='".$result['ID']."' class='text-white btn btn-danger btn-sm btn-delete'><i class='fa fa-trash-alt'></i></a>";
                                            echo "<tr>";
                                                echo "<td>".$result['Place']."</td>";
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
        var place = $(this).data("place");
        $(".form-title").html("Update place");
        $("#placeId").val(id);
        $("#place").val(place);
        $("#saveplace").hide();
        $("#updateplace").show();
        $("#btnAddNew").show();
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    $(document).on("click",".btn-delete",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "place will be deleted",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=deleteplace',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "meeting-places.php";
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