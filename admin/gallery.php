<?php
include("includes/header.php");

$active = "gallery";

include("includes/sidetop.php");

if(isset($_POST['submit'])){
    
    $event = $_POST['event'];
    
    $thumb=$_FILES['eventimage']['name'];

    $check = "SELECT * FROM gallery WHERE Category = ".$event." AND image = '".$thumb."'";
    $process = $db->query($check);
    if($process->num_rows == 0){
        $thumb_type=$_FILES['eventimage']['type'];
        $thumb_size=$_FILES['eventimage']['size'];
        $thumb_temp=$_FILES['eventimage']['tmp_name'];
        $thumb_store="../assets/img/gallery/".$thumb; 

        move_uploaded_file($thumb_temp,$thumb_store);

        $insertSql = "INSERT INTO gallery (Category,Image)
        VALUES ('".$event."','".$thumb."')";
        $processInsert = $db->query($insertSql);
        if($processInsert){
            
        }else{
            echo $insertSql;
        }
    }
}

?>

<style>
    .content {
         position: relative;
         margin: auto;
         overflow: hidden;
    }
     .content .content-overlay {
         background: rgba(0, 0, 0, 0.7);
         position: absolute;
         height: 99%;
         width: 100%;
         left: 0;
         top: 0;
         bottom: 0;
         right: 0;
         opacity: 0;
         -webkit-transition: all 0.4s ease-in-out 0s;
         -moz-transition: all 0.4s ease-in-out 0s;
         transition: all 0.4s ease-in-out 0s;
    }
     .content:hover .content-overlay {
         opacity: 1;
    }
     .content-image {
         width: 100%;
    }
     .content-details {
         position: absolute;
         text-align: center;
         padding-left: 1em;
         padding-right: 1em;
         width: 100%;
         top: 50%;
         left: 50%;
         opacity: 0;
         -webkit-transform: translate(-50%, -50%);
         -moz-transform: translate(-50%, -50%);
         transform: translate(-50%, -50%);
         -webkit-transition: all 0.3s ease-in-out 0s;
         -moz-transition: all 0.3s ease-in-out 0s;
         transition: all 0.3s ease-in-out 0s;
    }
     .content:hover .content-details {
         top: 50%;
         left: 50%;
         opacity: 1;
    }
     .content-details h3 {
         color: #fff;
         font-weight: 500;
         letter-spacing: 0.15em;
         margin-bottom: 0.5em;
         text-transform: uppercase;
    }
     .content-details p {
         color: #fff;
         font-size: 0.8em;
    }
     .fadeIn-bottom {
         top: 80%;
    }
     .fadeIn-top {
         top: 20%;
    }
     .fadeIn-left {
         left: 20%;
    }
     .fadeIn-right {
         left: 80%;
    }
     
</style>
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="gallertForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalLabel" style="color: #153D28;">Add Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"  style="color: black !important;">
                   <div class="form-group">
                       <label>Select Event</label>
                       <select class="form-control" name="event" id="event">
                           <?php 
                            $sql = "SELECT * FROM events";
                            $process = $db->query($sql);
                            if($process->num_rows > 0){
                                while($row = $process->fetch_assoc()){
                                    echo "<option value='".$row['ID']."'>".$row['Event']."</option>";
                                }
                            }
                           ?>
                       </select>
                   </div>
                   <div class="form-group">
                        <label>Image</label>
                        <img class="event-image" style="width:100%; height:200px;object-fit: cover;" />
                        <input type="file" name="eventimage" id="eventimage" class="form-control mt-2" required />
                   </div>
                </div>
                <div class="modal-footer">
                    <input  type="submit" class="btn btn-primary btn-save" name="submit" value="Save Image" style="padding-left:30px;padding-right:30px;" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Gallery</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Gallery</a></li>
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
            <button class="btn btn-primary mb-2 btn-add">Add New</button>
        </div>
        <div class="clearfix"></div>
        <div class="white-box">
            <div class="row">
               <?php
                $sqlImage = "SELECT * FROM gallery";
                $processImage = $db->query($sqlImage);
                if($processImage->num_rows > 0){
                    while($res = $processImage->fetch_assoc()){
                        ?>
                        <div class="content col-md-4 mb-2">
                            <a href="javascript:void(0)">
                              <div class="content-overlay"></div>
                              <img class="content-image" src="../assets/img/gallery/<?php echo $res['image']?>">
                              <div class="content-details fadeIn-bottom">
                                <button class="btn btn-primary btn-sm btn-delete" data-id="<?php echo $res['ID']?>"> Delete</button>
                              </div>
                            </a>
                          </div>
                        <!-- <div class="col-md-4 mb-2">
                            <img style="width:100%; height:250px;object-fit: cover;" src="../assets/img/gallery/<?php echo $res['image']?>" />
                        </div> -->
                        <?php
                    }
                }else{
                    echo "<h5>No Image Found</h5>";
                }

               ?>
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
    $(document).on("click",".btn-add",function(){
        $("#galleryModal").modal("toggle");
    });

    $(document).on('change','#eventimage',function(){
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            alert("Only image files are allowed!");
            $(this).val(null);
            $(".event-image").removeAttr("src");
        }else{
            readURL(this,'event-image');
        }
    });


    $(document).on("click",".btn-delete",function(){
        var id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "Image will be deleted",
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : '../ajax.php?action=deleteImage',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {id:id},
                    success: function (data) {
                        if(data.success){
                            window.location.href = "gallery.php";
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