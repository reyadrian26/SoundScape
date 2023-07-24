<?php
include 'db_connect.php';
$qry = $conn->query("SELECT u.*,g.genre FROM uploads u inner join genres g on g.id = u.genre_id where u.id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k=='title')
		$k = 'mtitle';
	$$k = $v;
}
?>

<div class="col-lg-12" style="font-family:'Poppins', sans-serif;margin-top:60px;padding-right:80px;">
	<div class="row">
		<div class="col-md-4">
			<center>
				<div class="d-flex img-thumbnail bg-gradient-1 position-relative" style="padding: 0;border: none;width: 12rem;margin-bottom: 10px;">
					<img src="assets/uploads/<?php echo $cover_image ?>" alt="" style="object-fit: cover;max-width: 100%;height:14rem;border-radius:4px;">
					<span class="position-absolute" style="bottom:.5em;left:.5em"><div class=" bg-green rounded-circle d-flex justify-content-center align-items-center" style="width: 2rem;height: 2rem;cursor: pointer;" onclick="play_music('assets/uploads/<?php echo $upath ?>')"><i class="fa fa-play"></i></div></span>
				</div>
			</center>
			<div>
			</div>
		</div>
		<div class="col-md-8">
			<h6 style="color: white;">Song</h6>
			<h5 class="text-white" style="font-size:45px; font-weight:700;"> <?php echo ucwords($mtitle); ?></h5>
			<h6 class="text-white">Artist: <?php echo ucwords($artist); ?></h6>
			<h6 class="text-white">Genre: <?php echo ucwords($genre); ?></h6>
			
			<h6 class="text-white border-bottom border-primary" style="border:none !important;margin-top:30px;"><b class="text-white">Description:</b></h6>
			<h6 class="text-white border-bottom border-primary" style="border-color: orange !important;"><b class="text-white"></b></h6>
			<div class="text-white" style="line-height:1.8;margin-top:20px;margin-bottom:40%;">
				<?php echo strip_tags(html_entity_decode($description)); ?>
            </div>
		</div>
	</div>
</div>