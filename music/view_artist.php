<?php
include 'db_connect.php';

// Fetch the artist information based on the artist ID
$artistId = $_GET['id'];
$artistQuery = $conn->query("SELECT * FROM artists WHERE id = $artistId")->fetch_assoc();

// Fetch the uploads associated with the artist
$uploadsQuery = $conn->query("SELECT * FROM uploads WHERE artist_id = $artistId");

// Check if the artist exists
if ($artistQuery) {
    // Extract the artist information
    $artistName = $artistQuery['name'];
    $profileImg = $artistQuery['profile_img'];
?>

<div class="col-lg-12">
    <div class="row">
        <div class="col-md-4">
            <center>
                <div class="d-flex img-thumbnail bg-gradient-1 position-relative" style="padding: 0;border: none;width: 12rem;margin-bottom: 10px;">
                    <img src="assets/uploads/<?php echo $profileImg ?>" alt="" style="object-fit: cover;max-width: 100%;height:14rem;border-radius:4px;">
                    <span class="position-absolute" style="bottom:.5em;left:.5em"><div class=" bg-green rounded-circle d-flex justify-content-center align-items-center" style="width: 2rem;height: 2rem;cursor: pointer;" onclick="play_music('assets/uploads/<?php echo $upath ?>')"><i class="fa fa-play"></i></div></span>
                </div>
            </center>
            <div>
            </div>
        </div>
        <div class="col-md-8">
            <h5 class="text-white">Artist: <?php echo ucwords($artistName); ?></h5>
            <h6 class="text-white border-bottom border-primary"><b class="text-white">Uploads:</b></h6>
            <?php
            // Check if the artist has uploads
            if ($uploadsQuery->num_rows > 0) {
                while ($upload = $uploadsQuery->fetch_assoc()) {
                    $uploadTitle = $upload['title'];
                    $uploadDescription = $upload['description'];
            ?>
            <div>
                <h6 class="text-white">Title: <?php echo ucwords($uploadTitle); ?></h6>
                <div class="text-white">
                    <?php echo html_entity_decode($uploadDescription); ?>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="text-white">No uploads found.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php
} else {
    echo '<p class="text-white">Artist not found.</p>';
}
?>
