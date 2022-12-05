<?php
include("includes/header.php");

$active = "inclussions";

include("includes/sidetop.php");

if(isset($_POST['savecategory'])){
    $category = $db->escape_string(trim($_POST['category']));

    $sql = "SELECT * FROM categories WHERE Category = '".$category."'";
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Category already exist!');</script>";
    }else{
        $insert = "INSERT INTO categories (Category,`DateAdded`) VALUES ('".$category."','".date('Y-m-d H:i:s')."')";
        $processInsert = $db->query($insert);
        if($processInsert){
            echo "<script>alert('Category saved successfully!');</script>";
        }else{
             echo "<script>alert(".$insert.");</script>";
        }
    }

}

if(isset($_POST['updatecategory'])){
    $category = $db->escape_string(trim($_POST['category']));
    $id = $_POST['id'];
    $sql = "SELECT * FROM categories WHERE Category = '".$category."' AND ID != ".$id;
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Category already exist!');</script>";
    }else{
        $update = "UPDATE categories set Category = '".$category."' WHERE ID = ".$id;
        $processUpdate = $db->query($update);
        if($processUpdate){
            echo "<script>alert('Category updated successfully!');</script>";
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
                <h4 class="page-title">Categories</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Categories</a></li>
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
            <a class="btn btn-primary" href="package-inclussion.php">Package Inclussions</a>
        </div>
        <div class="clearfix"></div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="white-box">
                    <form method="POST" id="categoryForm">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="form-title" style="font-weight:bold;">Add New Category</h4>
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="hidden" name="id" id="categoryId" />
                                    <input type="text" name="category" id="category" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="savecategory" id="savecategory" value="Save" class="btn btn-secondary" />
                                    <input type="submit" name="updatecategory" id="updatecategory" value="Save Change" class="btn btn-secondary" style="display: none;" />
                                    <a class="btn btn-primary" style="display: none;" id="btnAddNew" href="categories.php">Add New</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="white-box">
                    <h4 class="form-title"><b>Category List</b></h4>
                    <div class="table-responsive mt-2">
                        <table class="table" id="table" >
                            <thead>
                                <th>Category</th>
                                <th>Date Added</th>
                                <th style="text-align: center;">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM categories ";
                                    $process = $db->query($sql);
                                    if($process->num_rows > 0){
                                        while($result = $process->fetch_assoc()){
                                            $action = "<a href='javascript:void(0)' data-id='".$result['ID']."' data-category='".$result['Category']."' class='btn btn-secondary btn-sm btn-edit'><i class='fa fa-edit'></i></a>";
                                            $action .= "<a href='javascript:void(0)' data-id='".$result['ID']."' class='text-white btn btn-danger btn-sm btn-delete'><i class='fa fa-trash-alt'></i></a>";
                                            echo "<tr>";
                                                echo "<td>".$result['Category']."</td>";
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
        $(".form-title").html("Update Category");
        $("#categoryId").val(id);
        $("#category").val(category);
        $("#savecategory").hide();
        $("#updatecategory").show();
        $("#btnAddNew").show();
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    $(document).on("click",".btn-delete",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "Category will be deleted",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=deleteCategory',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "categories.php";
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