<?php
include("includes/header.php");

$active = "inclussions";

include("includes/sidetop.php");


if(isset($_POST['saveinclussion'])){
    $category = $_POST['category'];
    $inclussion = $db->escape_string(trim($_POST['inclussion']));

    $sql = "SELECT * FROM offers WHERE Category = '".$category."' AND Offer = '".$inclussion."'";
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Inclussion already exist!');</script>";
    }else{
        $insert = "INSERT INTO offers (Category,Offer,`DateAdded`) VALUES ('".$category."','".$inclussion."','".date('Y-m-d H:i:s')."')";
        $processInsert = $db->query($insert);
        if($processInsert){
            echo "<script>alert('Inclussion saved successfully!');</script>";
        }else{
             echo "<script>alert(".$insert.");</script>";
        }
    }
}

if(isset($_POST['updateinclussion'])){
    $category = $_POST['category'];
    $inclussion = $db->escape_string(trim($_POST['inclussion']));
    $id = $_POST['id'];

    $sql = "SELECT * FROM offers WHERE Category = '".$category."' AND Offer = '".$inclussion."' AND ID != ".$id;
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Inclussion already exist!');</script>";
    }else{
        $update = "UPDATE offers set Category = '".$category."', Offer = '".$inclussion."' WHERE ID = ".$id;
        $processUpdate = $db->query($update);
        if($processUpdate){
            echo "<script>alert('Inclussion updated successfully!');</script>";
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
                <h4 class="page-title">Package Inclussions</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Package Inclussions</a></li>
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
            <a class="btn btn-primary" href="categories.php">Categories</a>
        </div>
        <div class="clearfix"></div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="white-box">
                    <form method="POST" id="inclussionForm">
                        <input type="hidden" name="id" id="inclussionId" />
                        <div class="row">
                            <div class="col-12">
                                <h4 class="form-title" style="font-weight:bold;">Add New Inclussion</h4>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category" id="category">
                                        <?php 
                                            $sql = "SELECT * FROM categories";
                                            $process = $db->query($sql);
                                            if($process->num_rows > 0){
                                                while($row = $process->fetch_assoc()){
                                                    echo "<option value='".$row['ID']."'>".$row['Category']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Inclussion</label>
                                    <input type="text" name="inclussion" id="inclussion" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="saveinclussion" id="saveinclussion" value="Save" class="btn btn-secondary" />
                                    <input type="submit" name="updateinclussion" id="updateinclussion" value="Save Change" class="btn btn-secondary" style="display: none;" />
                                    <a class="btn btn-primary" style="display: none;" id="btnAddNew" href="package-inclussion.php">Add New</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box">
                    <h4 class="form-title"><b>Inclussion List</b></h4>
                    <div class="table-responsive mt-2">
                        <table class="table" id="table" >
                            <thead>
                                <th>Category</th>
                                <th>Inclussion</th>
                                <th>Date Added</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT offers.*,categories.Category,categories.ID as categoryId FROM offers JOIN categories ON categories.ID = offers.Category ORDER BY categories.ID ASC";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){
                                            $action = "<a href='javascript:void(0)' data-id='".$result['ID']."' data-inclussion='".$result['Offer']."'data-category='".$result['categoryId']."' class='btn btn-secondary btn-sm btn-edit'><i class='fa fa-edit'></i></a>";
                                            $action .= "<a href='javascript:void(0)' data-id='".$result['ID']."' class='text-white btn btn-danger btn-sm btn-delete'><i class='fa fa-trash-alt'></i></a>";
                                            echo "<tr>";
                                                echo "<td>".$result['Category']."</td>";
                                                echo "<td>".$result['Offer']."</td>";
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

    $(document).on("click",".btn-edit",function(){
        var id = $(this).data("id");
        var category = $(this).data("category");
        var inclussion = $(this).data("inclussion");
        $(".form-title").html("Update Category");
        $("#inclussionId").val(id);
        $("#category").val(category);
        $("#inclussion").val(inclussion);
        $("#saveinclussion").hide();
        $("#updateinclussion").show();
        $("#btnAddNew").show();
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    $(document).on("click",".btn-delete",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "Inclussion will be deleted",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=deleteInclussion',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "package-inclussion.php";
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