<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM genres where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
    if($k=='title')
        $k = 'ptitle';
    $$k = $v;
}
?>
<style>
    #music-table_wrapper {
        border: none;
    }

    #music-table th {
        border-top: none;
        border-bottom: 1px solid gray;
        font-weight: 500;
    }

    #music-table td {
        border: none;
    }

    #music-table td:first-child {
        width: 30px;
        max-width: 30px;
    }

    .btn.bg-green{
        background:orange !important;
        transition: 0.3s;
    }

    .btn.bg-green:hover{
        border-color:orange;
        background:#ffb938 !important;
    }

</style>

<div class="col-lg-12">
    <div class="row">
        <div class="col-md-4">
            <center>
                <div class="d-flex img-thumbnail bg-gradient-1 position-relative" style="padding: 0;border: none;width: 12rem;margin-bottom: 10px;">
                    <img src="assets/uploads/<?php echo $cover_photo ?>" alt="" style="object-fit: cover;max-width: 100%;height:14rem">
                    <span class="position-absolute" style="bottom:.5em;left:.5em"><div class="btn bg-green rounded-circle d-flex justify-content-center align-items-center" style="width: 2rem;height: 2rem;cursor: pointer;" onclick="play_playlist()"><i class="fa fa-play"></i></div></span>
                </div>
            </center>
            <div>
            </div>
            <div>
            </div>
        </div>
        <div class="col-md-8" style="font-family: 'Poppins', sans-serif;">
            <h5 class="text-white">Genre: <?php echo ucwords($genre); ?></h5>
            <!-- <h6 class="text-white border-bottom border-primary"><b class="text-white">Description:</b></h6> -->
            <div class="text-white">
                <?php echo html_entity_decode($description) ?>
            </div>
			
            
        </div>
    </div>
    <div class="d-flex justify-content-end mb-3" style="justify-content: end !important;">
                <div class="input-group" style="width: 300px;">
                    <input type="text" id="search-input" class="form-control" placeholder="Search for songs" style="color:white;padding:5px;background: #121212 !important;border: 1px solid gray;border-radius: 2px;">
                    <div class="input-group-append">
                        <span class="input-group-text" style="background-color: #343a40;border-color: #343a40;color: white;border-radius: 1px;"><i class="fa fa-search"></i></span>
                    </div>
                </div>
    </div>
    <table class="table bg-black" id="music-table" style="margin-top: 20px;background: #222124 !important;border-radius: 10px;font-family: 'Poppins', sans-serif !important;">
                <thead style="color: #b1b1b1;">
                    <tr>
                        <th>Play</th>
                        <th>Title</th>
                        <th>Artist</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 0;
                    $items = $conn->query("SELECT * FROM uploads WHERE genre_id = $id");
                    if ($items->num_rows > 0):
                        while($row = $items->fetch_assoc()):
                    ?>
                        <tr class="pitem" data-queue="<?php echo $i ?>" data-id="<?php echo $row['id'] ?>" data-upath="<?php echo $row['upath'] ?>">
                            <td>
                                <span class="btn bg-green bg-gradient-success rounded-circle d-flex justify-content-center align-items-center" style="width:30px;height:30px;z-index:2" onclick="play_playlist(<?php echo $i ?>)">
                                    <div class="fa fa-play text-white"></div>
                                </span>
                            </td>
                            <td>
                                <?php echo ucwords($row['title']) ?>
                            </td>
                            <td>
                                <?php echo ucwords($row['artist']) ?>
                            </td>
                        </tr>
                    <?php 
                            $i++;
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="3" class="text-center">No songs found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
</div>

<script>

$('#search-input').on('input', function() {
    var searchText = $(this).val().toLowerCase();
    $('.pitem').each(function() {
        var title = $(this).find('td:eq(1)').text().toLowerCase();
        var artist = $(this).find('td:eq(2)').text().toLowerCase();
        if (title.indexOf(searchText) === -1 && artist.indexOf(searchText) === -1) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });
});

function play_playlist($i = 0){
    var src = {}
    $('.pitem').each(function(){
        var id = $(this).attr('data-id')
        var upath = $(this).attr('data-upath')
        var q = $(this).attr('data-queue')
        src[q] = {id:id,upath:'assets/uploads/'+upath}
    })
    console.log(src)
    play_music(src,$i)
}
$('#manage_plist').click(function(e){
    e.preventDefault()
    uni_modal("Mange Playlist Music",'manage_playlist_items.php?pid=<?php echo $id ?>')
})
</script>
