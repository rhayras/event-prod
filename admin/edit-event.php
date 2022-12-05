<?php
include("includes/header.php");

$active = "events";

$event = isset($_GET['id']) ? $_GET['id'] : "";
if($event == "") { echo "<script>window.location.href = 'events.php';</script>"; }

$eventSql = "SELECT events.*,packages.Categories,packages.Inclussions,packages.ID as packageId FROM events JOIN packages ON events.ID = packages.Event WHERE events.ID = ".$event;
$processEvent = $db->query($eventSql);
$eventInfo = $processEvent->fetch_assoc();

$defaultImage = "../assets/img/event_thumbs/".$eventInfo['Image'];

$categories = json_decode($eventInfo['Categories'],true);
$inclussions = json_decode($eventInfo['Inclussions'],true);


include("includes/sidetop.php");

if(isset($_POST['updateevent'])){
    
    $event = $db->escape_string(trim($_POST['event']));
    $description = $db->escape_string(trim($_POST['description']));
    $categories = $_POST['categories'];
    $inclussions = $_POST['inclussions'];
    $id = $_POST['eventId'];
    $packageId = $_POST['packageId'];

    $sql = "SELECT * FROM events WHERE Event = '".$event."' AND ID != ".$id;
    $process = $db->query($sql);
    if($process->num_rows > 0){
        echo "<script>alert('Event already exist!')</script>";
    }else{

        $thumb=$_FILES['eventimage']['name'];

        $eventUpdateSql = "UPDATE events set Event = '".$event."',Description = '".$description."' ";
        if($thumb != ""){
            $thumb_type=$_FILES['eventimage']['type'];
            $thumb_size=$_FILES['eventimage']['size'];
            $thumb_temp=$_FILES['eventimage']['tmp_name'];
            $thumb_store="../assets/img/event_thumbs/".$thumb; 
            move_uploaded_file($thumb_temp,$thumb_store);
            $eventUpdateSql .= ", Image = '".$thumb."'";
        }

        $eventUpdateSql .= " WHERE ID = ".$id;
        $processEventUpdate = $db->query($eventUpdateSql);
        if($processEventUpdate){
            $packageSql = "UPDATE packages set Categories = '".json_encode($categories)."', Inclussions = '".json_encode($inclussions)."' 
            WHERE ID =".$packageId;
            $updatePackage = $db->query($packageSql);
            if($updatePackage){
                echo "<script>
                    alert('Event updated successfully!');
                    setTimeout(function(){
                        window.location.href = 'events.php';
                    },1000);
                </script>";
            }else{
                echo $packageSql;
            }
        }else{
            echo $eventUpdateSql;
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
                    <form method="POST" id="updateEventForm" enctype="multipart/form-data" class="mt-2">
                        <input type="hidden" name="eventId" value="<?php echo $event ?>" />
                        <input type="hidden" name="packageId" value="<?php echo $eventInfo['packageId'] ?>" />
                        <h4 class="form-title"><b>Event Information</b></h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <span>Event Thumbnail</span><br/>
                                <img class="event-image" src="<?php echo $defaultImage; ?>" style="width:100%; height:315px;object-fit: cover;" />
                                <input type="file" name="eventimage" id="eventimage" class="form-control mt-2"  />
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Event</label>
                                    <input type="text" name="event" id="event" class="form-control" value="<?php echo $eventInfo['Event']?>" />
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="10"><?php echo $eventInfo['Description']?></textarea>
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
                                    $selectCategory = (in_array($row['ID'], $categories)) ? "checked" : "";
                                    $showInclussions = (in_array($row['ID'], $categories)) ? "show" : "";
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" >
                                                <input class="form-check-input me-" <?php echo $selectCategory; ?>  name="categories[]" type="checkbox" value="<?php echo $row['ID']?>" data-bs-toggle="collapse" data-bs-target="#accordion_<?php echo $row['ID']?>" aria-controls="collapseOne" aria-expanded="false" data-id="<?php echo $row['ID']?>">
                                                <span style="margin-left:10px;margin-top:10px;"><?php echo $row['Category']?></span>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="accordion_<?php echo $row['ID']?>" class="accordion-collapse collapse <?php echo $showInclussions; ?>" aria-labelledby="headingOne"  style="">
                                        <div class="accordion-body">
                                            <span><b>Inclusion:</b></span><br/>
                                            <?php
                                                $sqlInclussion = "SELECT * FROM offers WHERE Category = ".$row['ID'];
                                                $processInclussion = $db->query($sqlInclussion);
                                                if($processInclussion->num_rows > 0){
                                                    while($res = $processInclussion->fetch_assoc()){
                                                        $selectInclussion = (in_array($res['ID'], $inclussions)) ? "checked" : "";
                                                        ?>
                                                        <input type="checkbox" <?php echo $selectInclussion; ?> name="inclussions[]" class="inclussion_<?php echo $row['ID']?>" id="inclussion_<?php echo $res['ID']?>" value="<?php echo $res['ID']?>" />
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
                            <input type="submit" class="btn btn-primary" name="updateevent" value="Save Event" />
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
            $(".event-image").attr("src","<?php echo $defaultImage?>");
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
