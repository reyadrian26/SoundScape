<?php include 'db_connect.php' ?>
<style>

	.card-hover{
		transition: 0.3s;
	}

    .card-hover:hover {
        background-color: #373535 !important;
    }
</style>
<div class="col-lg-12">
    <?php
    $title = isset($_GET['page']) ? ucwords(str_replace("_", ' ', $_GET['page'])) : "Home";
    ?>
    <h1 class="m-0 text-gradient-primary" style="font-family: 'Poppins', sans-serif !important;font-size: 25px;font-weight: 600;margin-top:  10px !important;margin-bottom:20px !important;"><?php echo $title ?></h1>
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="form-group" style="width:calc(50%) ">
            <div class="input-group">
                <input type="search" id="filter" class="form-control form-control-sm" placeholder="Search playlist using keyword" style="font-family: 'Poppins';background: #121212 !important;color: white;">
                <div class="input-group-append">
                    <button type="button" id="search" class="btn btn-sm btn-dark">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php if (!($_SESSION['login_type'] == 2 && $_SESSION['login_subscription_id'] == 1)) : ?>
            <button class="btn btn-sm btn-primary bg-gradient-primary custom-btn" type="button" id="manage_playlist" style="background: #f98f1d !important; border-color: #f48c24; font-family: 'Poppins' !important;"><i class="fa fa-plus"></i> Add New Playlist</button>
        <?php endif; ?>

    </div>

    <div class="row" id="playlist-list" style="font-family: 'Poppins' !important;margin-top:15px">
        <?php 
        $playlists = $conn->query("SELECT * FROM playlist ORDER BY id ASC");
        while ($row = $playlists->fetch_assoc()) :
        ?>
            <div class="card bg-black playlist-item my-2 mx-1 card-hover" data-id="<?php echo $row['id'] ?>" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
            	
					<div class="card-img-top flex-w-100 position-relative py-2 px-3">
					<?php if($_SESSION['login_type'] == 1 || $_SESSION['login_id'] == $row['user_id']): ?>
          				<div class="dropdown position-absolute" style="right:.5em;top:.5em">
            <button type="button" class="btn btn-tool py-1" data-toggle="dropdown" title="Manage" style="background: #000000ab;z-index: 1">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu bg-dark">
						<button class="dropdown-item manage_playlist bg-dark" data-id="<?php echo $row['id'] ?>" type="button">Manage List</button>
              			<button class="dropdown-item edit_playlist bg-dark" data-id="<?php echo $row['id'] ?>" type="button">Edit</button>
              			<button class="dropdown-item delete_playlist bg-dark" data-id="<?php echo $row['id'] ?>" type="button">Delete</button>
            </div>
          </div>
        <?php endif; ?>
				<a href="index.php?page=view_playlist&id=<?php echo $row['id'] ?>">    
						<img src="assets/uploads/<?php echo $row['cover_image'] ?>" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:4px;" alt="music Cover">
					
                </div>
                <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;">
                    <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;"><?php echo ucwords($row['title']) ?></h5>
                    <p class="card-text truncate text-white" style="color:#9c9c9c!important"><small><?php echo $row['description'] ?></small></p>
                </div>
				</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#list').dataTable()
        $('.delete_playlist').click(function () {
            _conf("Are you sure to delete this Playlist?", "delete_playlist", [$(this).attr('data-id')])
        })
        $('#manage_playlist').click(function (e) {
            e.preventDefault()
            uni_modal("New Playlist", 'manage_playlist.php')
        })
        $('.edit_playlist').click(function (e) {
            e.preventDefault()
            uni_modal("Edit Playlist", 'manage_playlist.php?id=' + $(this).attr('data-id'))
        })
        $('.manage_playlist').click(function (e) {
            e.preventDefault()
            uni_modal("Manage Playlist Music", 'manage_playlist_items.php?pid=' + $(this).attr('data-id'))
        })
    })
    check_list()

    function delete_playlist($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_playlist',
            method: 'POST',
            data: { id: $id },
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    $('.modal').modal('hide')
                    _redirect(document.href)
                    end_load()

                }
            }
        })
    }

    function _filter() {
        var _ftxt = $('#filter').val().toLowerCase()
        $('.playlist-item').each(function () {
            var _content = $(this).text().toLowerCase()
            if (_content.includes(_ftxt) == true) {
                $(this).toggle(true)
            } else {
                $(this).toggle(false)
            }
        })
        check_list()
    }

    function check_list() {
        var count = $('.playlist-item:visible').length
        if (count > 0) {
            if ($('#ns').length > 0)
                $('#ns').remove()
        } else {
            var ns = $('<div class="col-md-12 text-center text-white" id="ns"><b><i>No data to be displayed.</i></b></div>')
            $('#playlist-list').append(ns)
        }
    }

    $('#search').click(function () {
        _filter()
    })

    $('#filter').on('keypress', function (e) {
        if (e.which == 13) {
            _filter()
            return false;
        }
    })

    $('#filter').on('search', function () {
        _filter()
    })
</script>
