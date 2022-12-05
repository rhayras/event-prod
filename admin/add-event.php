<?php
include("includes/header.php");

$active = "events";

include("includes/sidetop.php");

if(isset($_POST['saveevent'])){
    
    $event = $db->escape_string(trim($_POST['event']));
    $description = $db->escape_string(trim($_POST['description']));
    $categories = $_POST['categories'];
    $inclussions = $_POST['inclussions'];

    $sql = "SELECT * FROM events WHERE Event = '".$event."'";
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Event already exist!')</script>";
    }else{
        $thumb=$_FILES['eventimage']['name'];
        $thumb_type=$_FILES['eventimage']['type'];
        $thumb_size=$_FILES['eventimage']['size'];
        $thumb_temp=$_FILES['eventimage']['tmp_name'];
        $thumb_store="../assets/img/event_thumbs/".$thumb; 

        move_uploaded_file($thumb_temp,$thumb_store);

        $insertSql = "INSERT INTO events (Event,Description,DateAdded,Image)
        VALUES ('".$event."','".$description."','".date('Y-m-d H:i:s')."','".$thumb."')";
        $processInsert = $db->query($insertSql);
        if($processInsert){
            $eventId = $db->insert_id;
            $insertPackage = "INSERT INTO packages (Event,Categories,Inclussions) VALUES 
            (".$eventId.",'".json_encode($categories)."','".json_encode($inclussions)."')";
            $processPackage = $db->query($insertPackage);
            if($processPackage){
                echo "<script>
                    alert('Event added successfully!');
                    setTimeout(function(){
                        window.location.href = 'events.php';
                    },1000);
                </script>";
            }else{
               echo $insertPackage; 
            }
        }else{
            echo $insertSql;
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
                <h4 class="page-title">Events</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Add Event</a></li>
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
                <div class="white-box">
                    <form method="POST" id="addEventForm" enctype="multipart/form-data" class="mt-2">
                        <h4 class="form-title"><b>Event Information</b></h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <span>Event Thumbnail</span><br/>
                                <img class="event-image" style="width:100%; height:315px;object-fit: cover;" />
                                <input type="file" name="eventimage" id="eventimage" class="form-control mt-2" required />
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Event</label>
                                    <input type="text" name="event" id="event" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <h4 class="form-title"><b>Event Package</b></h4>
                        <span>Please check all inclussion for package.</span>
                        <div class="accordion">
                        <?php
                            $sqlCategories = "SELECT * FROM categories";
                            $processCategories = $db->query($sqlCategories);
                            if($processCategories->num_rows > 0){
                                while($row = $processCategories->fetch_assoc()){
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" >
                                                <input class="form-check-input me-" name="categories[]" type="checkbox" value="<?php echo $row['ID']?>" data-bs-toggle="collapse" data-bs-target="#accordion_<?php echo $row['ID']?>" aria-controls="collapseOne" aria-expanded="false" data-id="<?php echo $row['ID']?>">
                                                <span style="margin-left:10px;margin-top:10px;"><?php echo $row['Category']?></span>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="accordion_<?php echo $row['ID']?>" class="accordion-collapse collapse" aria-labelledby="headingOne"  style="">
                                        <div class="accordion-body">
                                            <span><b>Inclusion:</b></span><br/>
                                            <?php
                                                $sqlInclussion = "SELECT * FROM offers WHERE Category = ".$row['ID'];
                                                $processInclussion = $db->query($sqlInclussion);
                                                if($processInclussion->num_rows > 0){
                                                    while($res = $processInclussion->fetch_assoc()){
                                                        ?>
                                                        <input type="checkbox" name="inclussions[]" class="inclussion_<?php echo $row['ID']?>" id="inclussion_<?php echo $res['ID']?>" value="<?php echo $res['ID']?>" />
                                                        <label for="inclussion_<?php echo $res['ID']?>"><?php echo $res['Offer'] ?></label>
                                                        <br/>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                        ?>
                        </div>

                        <br/><br/>
                        <div class="float-end">
                            <input type="submit" class="btn btn-primary" name="saveevent" value="Save Event" />
                        </div>
                        <div class="clearfix"></div>
                    </form>
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

    $(document).on("change",".form-check-input",function(){
        var id = $(this).val();
        if($(this).is(":checked")){

        }else{
            $(".inclussion_"+id).prop("checked",false);
        }
    });

</script>
