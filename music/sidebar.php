  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>

    <!-- <link rel="stylesheet" href="~/custom-style.css"> -->
  </head>
 <style>
    .nav-subscriptions:focus {
  background-color: #ff9100 !important;
  color: white !important;
}

.main-sidebar{
  z-index: 1031;
}
    
  </style>
  <body>
      <aside class="main-sidebar sidebar-dark-navy bg-black elevation-4" style="background-color: #222225 !important;">
        <div class="dropdown">
        <a href="./index.php?page=home" class="brand-link bg-black" data-toggle="" aria-expanded="true" style="background-color: #222225 !important;border-bottom:none">
            <span class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center text-white font-weight-500" style="width: 38px;height:50px;font-size: 2rem;box-shadow: none !important"><b><img src="images/soundscape-logo2.png" style="width: 40px; margin-right: 5px;" alt="SoundScape Logo"></b></span>
            <span class="brand-text font-weight-light ">
            <i style="font-style: normal; font-family: 'Poppins', sans-serif; font-weight: 600;">
              Sound<span class="" style="color: #d6800f !important;" style="color: white !important;">Scape</span>
            </i>
              </span>
          </a>
          <div class="dropdown-menu" style="">
            <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Manage Account</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="ajax.php?action=logout">Logout</a>
          </div>
        </div>
        <div class="sidebar" style="font-family: 'Roboto', sans-serif;">
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item dropdown">
            <?php if ($_SESSION['login_type'] == 1): ?>
              <a href="./index.php?page=home" class="nav-link nav-home nav-active">
                <i class="nav-icon fas fa-home icon-custom"></i>
                <p style="font-family: 'Poppins', sans-serif;">
                  Dashboard
                </p>
              </a>
            <?php else: ?>
              <a href="./index.php?page=home" class="nav-link nav-home nav-active">
                <i class="nav-icon fas fa-home icon-custom"></i>
                <p style="font-family: 'Poppins', sans-serif;">
                  Home
                </p>
              </a>
            <?php endif; ?>
          </li>
              <li class="nav-item">
                <a href="#" class="nav-link nav-is-tree nav-edit_music nav-view_music">
                  <i class="nav-icon fa fa-music icon-custom"></i>
                  <p style="font-family: 'Poppins', sans-serif;">
                    Songs
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <?php if ($_SESSION['login_type'] == 1 || ($_SESSION['login_type'] == 2 && $_SESSION['login_subscription_id'] == 3)) : ?>
                    <li class="nav-item">
                      <a href="./index.php?page=new_music" class=" ml-1 nav-link nav-new_music tree-item">
                        <i class="fas fa-angle-right nav-icon"></i>
                        <p class="" style="font-family: 'Poppins', sans-serif;">Add New</p>
                      </a>
                    </li>
                  <?php endif; ?>
                  <li class="nav-item">
                    <a href="./index.php?page=music_list" class=" ml-1 nav-link nav-music_list tree-item">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p class="" style="font-family: 'Poppins', sans-serif;">List</p>
                    </a>
                  </li>
                </ul>
            </li>

            
              <li class="nav-item">
                    <a href="./index.php?page=playlist" class="nav-link nav-playlist tree-item">
                      <i class="fas fa-list nav-icon  icon-custom"></i>
                      <p style="font-family: 'Poppins', sans-serif;">Playlist</p>
                    </a>
              </li> 
              <li class="nav-item">
                    <a href="./index.php?page=genre_list" class="nav-link nav-genre_list tree-item">
                      <i class="fas fa-th-list nav-icon  icon-custom"></i>
                      <p style="font-family: 'Poppins', sans-serif;">Genre</p>
                    </a>
              </li>  
              <?php if($_SESSION['login_type'] == 1): ?>
              <li class="nav-item">
                    <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                      <i class="fas fa-users nav-icon  icon-custom"></i>
                      <p style="font-family: 'Poppins', sans-serif;">Users</p>
                    </a>
              </li> 
              <?php endif; ?>
              <?php if($_SESSION['login_type'] == 2): ?>
              <li class="nav-item">
                    <a href="./index.php?page=subscription_plans" class="nav-link nav-subscriptions tree-item">
                    <i class="fa fa-credit-card nav-icon icon-custom"></i>
                      <p style="font-family: 'Poppins', sans-serif;">Subscriptions</p>
                    </a>
              </li> 
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </aside>
  </body>

  <script>
  	$(document).ready(function(){
  		var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		if($('.nav-link.nav-'+page).length > 0){
  			$('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
      $('.manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id='+$(this).attr('data-id'))
      })
  	})
  </script>

  </html>
  
  
  