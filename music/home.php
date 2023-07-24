<?php 
  include('db_connect.php')
?>


<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->

<style>
	.music-item:hover{
		background: rgb(110,109,109);
		background: radial-gradient(circle, rgba(110,109,109,1) 0%, rgba(55,54,54,1) 23%, rgba(28,27,27,1) 56%);
	}
	*{
		font-family: 'Poppins' sans-serif !important;
	}

  .btn-link{
    margin-right: 20px;
  }

  #audio-player{
    bottom: 0rem !important: ;
    background-color: #111213 !important;
    font-family: 'Poppins' !important;
    left: 0 !important;
    position: fixed !important;
    right: 0 !important;
    z-index: 1040 !important;
  }

  iframe{
    margin-right: -10px;
  }

  .card-title.w-100{
    font-size: 20px;
    font-weight: 700;
    color: white;
    margin-bottom: 10px;
  }
  
  .btn.bg-green{
        background:orange !important;
        transition: 0.3s;
    }

    .btn.bg-green:hover{
        border-color:orange;
        background:#ffb938 !important;
    }

    .card-title.w-100{
      font-size: 16px;
    }

    .music-item {
    width: 14.5vw;
    cursor: pointer;
    background: #1d1d1d;
    border-radius: 10px;
    padding-top: 5px;
    box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);
    margin: 2px;
  }

  .card-img-top img {
    object-fit: cover;
    max-width: 100%;
    height: 26vh;
    border-radius: 10px;
  }

  .card-title.w-100 {
    font-size: 16px;
    margin-bottom: 10px;
  }

  .card-subtitle {
    margin-bottom: 0;
  }

  
  @media (max-width: 768px) {
    .row{
      display:block;
    }

    .card.music-item{
    width:10vw !important;
    margin-left: 50px !important;
    }

    h5,h6{
      font-size:10px;
    }
  
}

  

  @media (max-width: 1079px) { 
    
    .card.music-item{

      display:flex;
    width:60vw !important;
    margin-left: 50px !important;
}
  }
  

 
</style>

<script>
  $(document).ready(function() {
    $('#list').dataTable()
    $('.delete_music').click(function() {
      _conf("Are you sure to delete this music?", "delete_music", [$(this).attr('data-id')])
    })
    $('#manage_music').click(function() {
      uni_modal("New music", 'manage_music.php')
    })
    $('.edit_music').click(function() {
      uni_modal("New music", 'manage_music.php?id=' + $(this).attr('data-id'))
    })
    check_list()
  })

  function delete_music($id) {
    start_load()
    $.ajax({
      url: 'ajax.php?action=delete_music',
      method: 'POST',
      data: {
        id: $id
      },
      success: function(resp) {
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
    $('.music-item').each(function() {
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
      var ns = $('<div class="col-md-12 text-center text-white" id="ns"><b><i>No data to be displayed.</i></b></div>')
      $('#music-list').append(ns)
    }
  }

  $('#search').click(function() {
    _filter()
  })

  $('#filter').on('keypress', function(e) {
    if (e.which == 13) {
      _filter()
      return false;
    }
  })

  $('#filter').on('input', function() {
    _filter()
  })

  $('#play_all').click(function() {
    var _src = {};
    var i = 0
    $('.music-item').each(function() {
      _src[i++] = {
        id: $(this).attr('data-id'),
        upath: 'assets/uploads/' + $(this).attr('data-upath')
      }
    })
    play_music(_src)
  })
  
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->

<!-------------------- ADMIN HOME PAGE ------------------------->

<!-- Info boxes -->
<?php if ($_SESSION['login_type'] == 1) { ?>
  <div class="row" style="font-family: 'Poppins', sans-serif;">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-black border border-primary" style="background-color: #111213 !important; border: none !important;">
        <span class="info-box-icon bg-primary elevation-1" style="background-color: #111213 !important;"><i class="fas fa-th-list text-gradient-primary"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Genres</span>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM genres")->num_rows; ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-black border border-primary" style="background-color: #111213 !important; border: none !important;">
        <span class="info-box-icon bg-primary elevation-1" style="background-color: #111213 !important;"><i class="fas fa-music text-gradient-primary"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Songs</span>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM uploads")->num_rows; ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-black border border-primary" style="background-color: #111213 !important; border: none !important;">
        <span class="info-box-icon bg-primary elevation-1" style="background-color: #111213 !important;"><i class="fas fa-list text-gradient-primary"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Playlists</span>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM playlist")->num_rows; ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-black border border-primary" style="background-color: #111213 !important; border: none !important;">
        <span class="info-box-icon bg-primary elevation-1" style="background-color: #111213 !important;"><i class="fas fa-users text-gradient-primary"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Users</span>
          <span class="info-box-number">
            <?php echo $conn->query("SELECT * FROM users where type = 2")->num_rows; ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>

<!-- <div class="row" style="font-family: 'Poppins', sans-serif;">
  <div class="col-12 col-sm-6 col-md-3">
    
          <?php echo $conn->query("SELECT * FROM uploads where user_id ={$_SESSION['login_id']} ")->num_rows; ?>
      
     
 
    </div> 
    
  </div>
 
  <div class="col-12 col-sm-6 col-md-3">
    
          <?php echo $conn->query("SELECT * FROM playlist where user_id ={$_SESSION['login_id']}")->num_rows; ?>
       
    </div> 

  </div>
</div> -->
<?php } ?>


<!-------------------- USER HOME PAGE ------------------------->


<?php if ($_SESSION['login_type'] == 2) { ?>

  

<div class="col-lg-12">




<div class="col-lg-12">
<div class="d-flex justify-content-between align-items-center">
  <h6 style="margin-top: -20px;margin-bottom: 2px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">RECOMMENDED FOR YOU</h6>
  <a href="./index.php?page=music_list" class="btn btn-link" style="margin-top: -10px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;margin-bottom: 15px;">See All</a>
</div>
<div class="row" id="music-list" style="font-family: 'Poppins' !important;margin-top:-15px">
  <?php 
    $songIds = [35, 36, 37, 64, 40]; // Song IDs in the desired order
    $songIdsString = implode(',', $songIds);
    
    $musics = $conn->query("SELECT u.*, g.genre 
                            FROM uploads u 
                            INNER JOIN genres g ON g.id = u.genre_id 
                            WHERE u.id IN ($songIdsString)
                            ORDER BY FIELD(u.id, $songIdsString)");
    while($row = $musics->fetch_assoc()):
      $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
      unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
      $desc = strtr(html_entity_decode($row['description']), $trans);
      $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
  ?>
    <div class="card bg-black music-item my-2 mx-1" data-id="<?php echo $row['id'] ?>" data-upath="<?php echo $row['upath'] ?>" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
      
      <div class="card-img-top flex-w-100 position-relative py-2 px-3">
        <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_id'] == $row['user_id']): ?>
          <div class="dropdown position-absolute" style="right:.5em;top:.5em">
            <button type="button" class="btn btn-tool py-1" data-toggle="dropdown" title="Manage" style="background: #000000ab;z-index: 1">
              <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu bg-dark">
              <a class="dropdown-item bg-dark" data-id="<?php echo $row['id'] ?>" href="index.php?page=edit_music&id=<?php echo $row['id'] ?>">Edit</a>
              <a class="dropdown-item delete_music bg-dark" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
            </div>
          </div>
        <?php endif; ?>
        <span class="position-absolute" style="bottom:.5em;left:.5em;z-index: 2">
          <div class= "btn bg-green rounded-circle d-flex justify-content-center align-items-center" style="width: 2rem;height: 2rem;cursor: pointer;" onclick="play_music({0:{id:'<?php echo $row['id'] ?>',upath:'assets/uploads/<?php echo $row['upath'] ?>'}})">
            <i class="fa fa-play"></i>
          </div>
        </span>
        <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>">
          <img src="assets/uploads/<?php echo $row['cover_image'] ?>" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:4px;" alt="music Cover">
        
      </div>
      <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;" >
        <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;"><?php echo ucwords($row['title']) ?></h5>
        <h6 class="card-subtitle mb-2 text-muted w-100">Artist: <?php echo ucwords($row['artist']) ?></h6>
        <!-- <p class="card-text truncate text-white" style="color:#9c9c9c!important"><small><?php echo strip_tags($desc) ?></small></p> -->
      </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  // Add event listeners for hover effect
  var cards = document.getElementsByClassName("card");
  for (var i = 0; i < cards.length; i++) {
    cards[i].addEventListener("mouseover", function() {
      this.style.backgroundColor = "#373535";
    });
    cards[i].addEventListener("mouseout", function() {
      this.style.backgroundColor = "#1d1d1d";
    });
  }
</script>




<div class="col-lg-12">
  <div class="d-flex justify-content-between align-items-center">
    <h6 style="margin-top: 30px;margin-bottom: 2px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">TOP SONGS</h6>
    <a href="./index.php?page=music_list" class="btn btn-link" style="margin-top: 20px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">See All</a>
  </div>
  <div class="row" id="music-list" style="font-family: 'Poppins' !important;">
    <?php 
      $songIds = [31, 30, 32, 33, 34]; // Song IDs in the desired order
      $songIdsString = implode(',', $songIds);
      
      $musics = $conn->query("SELECT u.*, g.genre 
                              FROM uploads u 
                              INNER JOIN genres g ON g.id = u.genre_id 
                              WHERE u.id IN ($songIdsString)
                              ORDER BY FIELD(u.id, $songIdsString)");
      while($row = $musics->fetch_assoc()):
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
        $desc = strtr(html_entity_decode($row['description']), $trans);
        $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
    ?>
    <div class="card bg-black music-item my-2 mx-1" data-id="<?php echo $row['id'] ?>" data-upath="<?php echo $row['upath'] ?>" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
       
        <div class="card-img-top flex-w-100 position-relative py-2 px-3">
          <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_id'] == $row['user_id']): ?>
            <div class="dropdown position-absolute" style="right:.5em;top:.5em">
              <button type="button" class="btn btn-tool py-1" data-toggle="dropdown" title="Manage" style="background: #000000ab;z-index: 1">
                <i class="fa fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu bg-dark">
                <a class="dropdown-item bg-dark" data-id="<?php echo $row['id'] ?>" href="index.php?page=edit_music&id=<?php echo $row['id'] ?>">Edit</a>
                <a class="dropdown-item delete_music bg-dark" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
              </div>
            </div>
          <?php endif; ?> 
          <span class="position-absolute" style="bottom:.5em;left:.5em;z-index: 2">
            <div class="btn bg-green rounded-circle d-flex justify-content-center align-items-center" style="width: 2rem;height: 2rem;cursor: pointer;" onclick="play_music({0:{id:'<?php echo $row['id'] ?>',upath:'assets/uploads/<?php echo $row['upath'] ?>'}})">
              <i class="fa fa-play"></i>
            </div>
          </span>
          <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>"> 
            <img src="assets/uploads/<?php echo $row['cover_image'] ?>" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:10px;" alt="music Cover">
          
        </div>
        <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;" >
          <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;"><?php echo ucwords($row['title']) ?></h5>
          <h6 class="card-subtitle mb-2 text-muted w-100">Artist: <?php echo ucwords($row['artist']) ?></h6>
          <!-- <p class="card-text truncate text-white" style="color:#9c9c9c!important"><small><?php echo strip_tags($desc) ?></small></p> -->
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  // Add event listeners for hover effect
  var cards = document.getElementsByClassName("card");
  for (var i = 0; i < cards.length; i++) {
    cards[i].addEventListener("mouseover", function() {
      this.style.backgroundColor = "#373535";
    });
    cards[i].addEventListener("mouseout", function() {
      this.style.backgroundColor = "#1d1d1d";
    });
  }
</script>


<div class="col-lg-12">
  <div class="d-flex justify-content-between align-items-center">
    <h6 style="margin-top: 30px;margin-bottom: 2px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">TRENDING ARTISTS  </h6>
    <!-- <a href="./index.php?page=music_list" class="btn btn-link" style="margin-top: 20px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">See All</a> -->
  </div>
  <div class="row" id="music-list" style="font-family: 'Poppins' !important;">

    <div class="card bg-black music-item my-2 mx-1" data-id="" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
      <div class="card-img-top flex-w-100 position-relative py-2 px-3">
        <!-- <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>"> -->
          <img src="images/theweeknd-profile.jpg" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:50% !important;" alt="music Cover">
        </a>
      </div>
      <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;">
        <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;">The Weeknd</h5>
        <h6 class="card-subtitle mb-2 text-muted w-100">Artist</h6>
      </div>
    </div>

    <div class="card bg-black music-item my-2 mx-1" data-id="" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
      <div class="card-img-top flex-w-100 position-relative py-2 px-3">
        <!-- <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>"> -->
          <img src="images/EdSheeran-profile.jpg" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:50% !important;" alt="music Cover">
        </a>
      </div>
      <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;">
        <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;">Ed Sheeran</h5>
        <h6 class="card-subtitle mb-2 text-muted w-100">Artist</h6>
      </div>
    </div>

    <div class="card bg-black music-item my-2 mx-1" data-id="" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
      <div class="card-img-top flex-w-100 position-relative py-2 px-3">
        <!-- <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>"> -->
          <img src="images/TaylorSwift-Profile.jpg" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:50% !important;" alt="music Cover">
        </a>
      </div>
      <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;">
        <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;">Taylor Swift</h5>
        <h6 class="card-subtitle mb-2 text-muted w-100">Artist</h6>
      </div>
    </div>

    <div class="card bg-black music-item my-2 mx-1" data-id="" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
      <div class="card-img-top flex-w-100 position-relative py-2 px-3">
        <!-- <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>"> -->
          <img src="images/JustinBieber-profile.jpg" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:50% !important;" alt="music Cover">
        </a>
      </div>
      <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;">
        <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;">Justin Bieber</h5>
        <h6 class="card-subtitle mb-2 text-muted w-100">Artist</h6>
      </div>
    </div>

    <div class="card bg-black music-item my-2 mx-1" data-id="" style="width:14.5vw;cursor:pointer;background: #1d1d1d;border-radius: 10px;padding-top: 5px;box-shadow: 0px 3px 3px 0px rgba(0, 0, 0, 0.57);">
      <div class="card-img-top flex-w-100 position-relative py-2 px-3">
        <!-- <a href="index.php?page=view_music&id=<?php echo $row['id'] ?>"> -->
          <img src="images/SamSmith-profile.jpg" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:50% !important;" alt="music Cover">
        </a>
      </div>
      <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;">
        <h5 class="card-title w-100" style="color: white;margin-bottom: 10px;">Sam Smith</h5>
        <h6 class="card-subtitle mb-2 text-muted w-100">Artist</h6>
      </div>
    </div>
  </div>
</div>

<script>
  // Add event listeners for hover effect
  var cards = document.getElementsByClassName("card");
  for (var i = 0; i < cards.length; i++) {
    cards[i].addEventListener("mouseover", function() {
      this.style.backgroundColor = "#373535";
    });
    cards[i].addEventListener("mouseout", function() {
      this.style.backgroundColor = "#1d1d1d";
    });
  }
</script>




<div class="col-lg-12">
  <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 10px;">
      <h6 style="margin-top: 30px;margin-bottom: 2px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">TOP PLAYLISTS</h6>
      <a href="./index.php?page=music_list" class="btn btn-link" style="margin-top: 20px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">See All</a>
  </div>
  
    <?php 
      $musics = $conn->query("SELECT u.*, g.genre 
                              FROM uploads u 
                              INNER JOIN genres g ON g.id = u.genre_id 
                              ORDER BY u.play_count DESC 
                              LIMIT 5");
      while($row = $musics->fetch_assoc()):
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
        $desc = strtr(html_entity_decode($row['description']), $trans);
        $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
    ?>
    
        <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_id'] == $row['user_id']): ?>
          
        <?php endif; ?>
        
       
      
    <?php endwhile; ?>


 
      
    <div style="margin-right: 30px;display: flex;justify-content: flex-start;gap: 7px;">
        <div class="iframe-container" style="border-radius: 10px;background: #1d1d1d;padding: 12px;width: 14.5vw;/* margin-right:-23px; */">
          <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1523959981&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"style="border-radius: 10px;"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/sc-playlists" title="Discovery Playlists" target="_blank" style="color: #cccccc; text-decoration: none;">Discovery Playlists</a> · <a href="https://soundcloud.com/sc-playlists/sets/indie-chill" title="Indie Chill" target="_blank" style="color: #cccccc; text-decoration: none;">Indie Chill</a></div>
        </div>  
        <div class="iframe-container" style="border-radius: 10px;background: #1d1d1d;padding: 12px;width: 14.5vw;/* margin-right:-23px; */">
          <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1601325487&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"style="border-radius: 10px;"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/sc-playlists" title="Discovery Playlists" target="_blank" style="color: #cccccc; text-decoration: none;">Discovery Playlists</a> · <a href="https://soundcloud.com/sc-playlists/sets/hip-hop-therapy" title="Hip Hop Therapy" target="_blank" style="color: #cccccc; text-decoration: none;">Hip Hop Therapy</a></div>
        </div>
        <div class="iframe-container" style="border-radius: 10px;background: #1d1d1d;padding: 12px;width: 14.5vw;/* margin-right:-23px; */">
          <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1523960011&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"style="border-radius: 10px;"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/sc-playlists" title="Discovery Playlists" target="_blank" style="color: #cccccc; text-decoration: none;">Discovery Playlists</a> · <a href="https://soundcloud.com/sc-playlists/sets/moonlight-soul" title="Moonlight Soul" target="_blank" style="color: #cccccc; text-decoration: none;">Moonlight Soul</a></div>
        </div>
        <div class="iframe-container" style="border-radius: 10px;background: #1d1d1d;padding: 12px;width: 14.5vw;/* margin-right:-23px; */">
        <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1523959804&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"style="border-radius: 10px;"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/sc-playlists" title="Discovery Playlists" target="_blank" style="color: #cccccc; text-decoration: none;">Discovery Playlists</a> · <a href="https://soundcloud.com/sc-playlists/sets/lo-fi-chill-beats" title="lo-fi chill beats" target="_blank" style="color: #cccccc; text-decoration: none;">Lo-Fi chill beats</a></div>
        </div>
        <div class="iframe-container" style="border-radius: 10px;background: #1d1d1d;padding: 12px;width: 14.5vw;/* margin-right:-23px; */">
        <iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/1523959795&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"style="border-radius: 10px;"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/sc-playlists" title="Discovery Playlists" target="_blank" style="color: #cccccc; text-decoration: none;">Discovery Playlists</a> · <a href="https://soundcloud.com/sc-playlists/sets/soulful-bedtime-wind-down" title="Bedtime Soul" target="_blank" style="color: #cccccc; text-decoration: none;">Bedtime Soul</a></div>
        </div>
    </div> 
</div>

<style>
  .card {
    transition: background-color 0.3s ease;
    
  }

  .card.genre{
    transition: filter 0.3s ease;
  }
  .card.genre:hover {
    filter: brightness(0.8); /* Lighten the background color */
  }
</style>

<div class="col-lg-12">
  <div class="d-flex justify-content-between align-items-center">
    <h6 style="margin-top: 30px;margin-bottom: 2px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">BROWSE BY GENRE</h6>
    <a href="./index.php?page=music_list" class="btn btn-link" style="margin-top: 20px;font-family: 'Poppins', sans-serif !important;font-weight: 600;color:white;">See All</a>
  </div>
  <div class="row" id="music-list" style="font-family: 'Poppins' !important;">
    <?php 
      $genres = $conn->query("SELECT * FROM genres ORDER BY id ASC LIMIT 10");
      $gradients = array(
        'linear-gradient(90deg, rgba(234,87,129,1) 0%, rgba(244,103,122,1) 0%, rgba(247,128,144,1) 96%)',
        'linear-gradient(90deg, rgba(205,66,59,1) 0%, rgba(223,82,75,1) 0%, rgba(235,92,84,1) 96%)',
        'linear-gradient(90deg, rgba(61,69,194,1) 0%, rgba(109,87,214,1) 0%, rgba(154,103,232,1) 96%)',
        'linear-gradient(90deg, rgba(217,135,75,1) 0%, rgba(233,159,84,1) 0%, rgba(247,180,91,1) 96%)',
        'linear-gradient(90deg, rgba(230,144,184,1) 0%, rgba(228,137,178,1) 0%, rgba(247,148,91,1) 96%)',
        'linear-gradient(90deg, rgba(231,123,81,1) 0%, rgba(241,145,87,1) 0%, rgba(237,117,34,1) 96%)',
        'linear-gradient(90deg, rgba(58,81,152,1) 0%, rgba(77,109,192,1) 0%, rgba(100,137,231,1) 96%)',
        'linear-gradient(90deg, rgba(65,67,84,1) 0%, rgba(92,98,122,1) 0%, rgba(83,95,144,1) 97%)',
        'linear-gradient(90deg, rgba(127,106,88,1) 0%, rgba(143,118,98,1) 0%, rgba(170,125,90,1) 97%)',
        'linear-gradient(90deg, rgba(13,152,157,1) 0%, rgba(0,192,185,1) 0%, rgba(0,203,184,1) 97%)'
      ); // Define an array of different gradient values
      $gradientIndex = 0; // Initialize the index for selecting gradients from the array
      $genreId = 1; // Initialize the genre ID
      while($row = $genres->fetch_assoc()):
    ?>
    <a href="./index.php?page=view_genre&id=<?php echo $genreId ?>">
      <div class="card bg-black music-item my-2 mx-1 genre" data-id="<?php echo $row['id'] ?>" style="background: <?php echo $gradients[$gradientIndex]; ?>;width:14.5vw;cursor:pointer;border-radius: 10px;padding-top: 5px;">
        <!-- <div class="card-img-top flex-w-100 position-relative py-2 px-3">
          <img src="<?php echo $row['cover_photo'] ?>" class="card-img-top" style="object-fit: cover;max-width: 100%;height:26vh;border-radius:10px;" alt="Genre Cover">
        </div> -->
        <div class="card-body border-top border-primary" style="min-height:12vh;border: none !important;" >
          <h5 class="card-title w-100" style="margin-top: 10px;color: white;margin-bottom: 10px;"><?php echo ucwords($row['genre']) ?></h5>
          <!-- <p class="card-text text-white"><?php echo $row['description'] ?></p> -->
        </div>
      </div>
    </a>
    <?php 
      $gradientIndex++; // Increment the gradient index to select the next gradient from the array
      if ($gradientIndex >= count($gradients)) {
        $gradientIndex = 0; // Reset the gradient index if it exceeds the number of gradients in the array
      }
      $genreId++; // Increment the genre ID for the next card
      endwhile; 
    ?>
  </div>
</div>





<?php } ?>
