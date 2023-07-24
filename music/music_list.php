<?php include 'db_connect.php' ?>
<style>
    .music-item:hover {
        background: rgb(110, 109, 109);
        background: radial-gradient(circle, rgba(110, 109, 109, 1) 0%, rgba(55, 54, 54, 1) 23%, rgba(28, 27, 27, 1) 56%);
    }

    * {
        font-family: 'Poppins' sans-serif !important;
    }

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

    .page-link {
        background: #222124 !important;
        color: white !important;
    }

    .page-item.active .page-link {
        background: orange !important;
        border-color: orange !important;
    }

    .dataTables_wrapper 
        div.dataTables_length select,
        .dataTables_wrapper 
        div.dataTables_filter input {
     color: white;
     background-color:#222124 !important;
}

    a.song_list_link:hover{
        color: orange !important;
    }
    
    .btn.playbtn_hover{
        background:orange !important;
         transition: 0.3s;
    }

    .btn.playbtn_hover:hover{
        border-color:orange;
        background:#ffb938 !important;
    }
</style>
<div class="col-lg-12">
        
   
    <!-- <button class="btn btn-primary" id="play_all" style="background-color: #f48c24; border-color: #f48c24;font-family: 'Poppins'!important;">Play All</button> -->
    <div class="table-responsive" style="margin-top:20px;background: #222124 !important;border-radius: 10px;padding: 30px;color: white;font-family: 'Poppins' !important;">
        
        <!-- <div class="d-flex justify-content-between align-items-center w-100">
            
            <?php if ($_SESSION['login_type'] == 1 || ($_SESSION['login_type'] == 2 && $_SESSION['login_subscription_id'] == 3)) : ?>
                <a class="btn btn-sm btn-primary  custom-btn" href="index.php?page=new_music" style="margin-bottom: 20px;background-color: #f98f1d !important; border-color: #f48c24; font-family: 'Poppins' !important;"><i class="fa fa-plus"></i> Add New</a>
            <?php endif; ?>
            </div> -->
        <table class="table table-striped" id="music-table">
            <thead>
                <tr>
                    <th>Play</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Genre</th>
                    <?php if ($_SESSION['login_type'] == 1 || ($_SESSION['login_type'] == 2 && $_SESSION['login_subscription_id'] == 3)) : ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $musics = $conn->query("SELECT u.*, g.genre FROM uploads u INNER JOIN genres g ON g.id = u.genre_id ORDER BY u.title ASC");
                while ($row = $musics->fetch_assoc()) :
                    $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                    unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                    $desc = strtr(html_entity_decode($row['description']), $trans);
                    $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
                ?>
                <tr>
                    <td>
                        <div class="btn bg-green rounded-circle d-flex justify-content-center align-items-center playbtn_hover" style="width: 2rem;height: 2rem;cursor: pointer;" onclick="play_music({0:{id:'<?php echo $row['id'] ?>',upath:'assets/uploads/<?php echo $row['upath'] ?>'}})">
                            <i class="fa fa-play"></i>
                        </div>
                    </td>
                    <td><a href="index.php?page=view_music&id=<?php echo $row['id'] ?>" class="song_list_link"style="color:white;"><img src="assets/uploads/<?php echo $row['cover_image'] ?>" alt="Music Cover" style="max-width: 50px;border-radius: 10px;margin-right: 10px;"><?php echo ucwords($row['title']) ?></a></td>
                    <td><?php echo ucwords($row['artist']) ?></td>
                    <td><?php echo $row['genre'] ?></td>
                    <?php if ($_SESSION['login_type'] == 1 || ($_SESSION['login_type'] == 2 && $_SESSION['login_subscription_id'] == 3)) : ?>

                        <td>
                            <?php if ($_SESSION['login_type'] == 1) : ?>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-tool py-1 dropdown-toggle" data-toggle="dropdown" title="Manage" style="background: #000000ab;">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu bg-dark">
                                        <a class="dropdown-item bg-dark" href="index.php?page=edit_music&id=<?php echo $row['id'] ?>">Edit</a>
                                        <a class="dropdown-item delete_music bg-dark" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
                                    </div>
                                </div>
                            <?php elseif ($_SESSION['login_type'] == 2 && $_SESSION['login_subscription_id'] == 3) : ?>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-tool py-1 dropdown-toggle" data-toggle="dropdown" title="Manage" style="background: #000000ab;">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu bg-dark">
                                    <a class="dropdown-item bg-dark" href="javascript:void(0)" onclick="downloadMusic(<?php echo $row['id'] ?>)">Download</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


</div>
<script>
    $(document).ready(function () {
        if (!$.fn.DataTable.isDataTable('#music-table')) {
            $('#music-table').DataTable({
                "order": [],
                "columnDefs": [{
                    "targets": [3],
                    "orderable": false,
                    "searchable": false
                }],
                "language": {
                    "sEmptyTable": "No data available in the table",
                    "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                    "sInfoFiltered": "(filtered from _MAX_ total entries)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Show _MENU_ entries",
                    "sLoadingRecords": "Loading...",
                    "sProcessing": "Processing...",
                    "sSearch": "Search:",
                    "sZeroRecords": "No matching records found",
                    "searchPlaceholder": "Search for songs",
                    "oPaginate": {
                        "sFirst": "First",
                        "sLast": "Last",
                        "sNext": "Next",
                        "sPrevious": "Previous"
                    },
                    "oAria": {
                        "sSortAscending": ": activate to sort column ascending",
                        "sSortDescending": ": activate to sort column descending"
                    }
                }
            });
        }
    });

    $(document).on('click', '.delete_music', function () {
        _conf("Are you sure to delete this music?", "delete_music", [$(this).attr('data-id')])
    });

    $('#manage_music').click(function () {
        uni_modal("New music", 'manage_music.php')
    });

    $('.edit_music').click(function () {
        uni_modal("New music", 'manage_music.php?id=' + $(this).attr('data-id'))
    });

    function delete_music($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_music',
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
        $('.music-item').each(function () {
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
        var count = $('.music-item:visible').length
        if (count > 0) {
            if ($('#ns').length > 0)
                $('#ns').remove()
        } else {
            var ns = $('<div class="col-md-12 text-center text-white" id="ns"><b><i>No data to be displayed.</i></b></b></div>')
            $('#music-table').parent().append(ns)
        }
    }

    $('#search').click(function () {
        _filter();
    });

    $('#filter').on('keypress', function (e) {
        if (e.which == 13) {
            _filter();
            return false;
        }
    });

    $('#filter').on('search', function () {
        _filter();
    });

    function play_music(src, index) {
    var keys = Object.keys(src);
    var current = index || 0;
    var audio = new Audio(src[current].upath);
    
    audio.addEventListener('ended', function () {
        if (current < keys.length - 1) {
            current++;
            audio.src = src[current].upath;
            audio.play();
        }
    });
    
    audio.play();
}

    function downloadMusic(id) {
        window.location.href = 'download.php?id=' + id;
    }
</script>