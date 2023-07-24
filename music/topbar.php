<style>

@media (max-width: 768px)
    {
      .topbar-text{
      font-size: 12px;
      
    }

    .badge-pill{
      font-size:12px;
    }
  }
</style>


<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-primary navbar-dark bg-dark border-primary" style="border-color: #222124 !important ; background-color: #222124 !important;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <?php if(isset($_SESSION['login_id'])): ?>
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <?php endif; ?>
    <li class="nav-link">
      <a></a>
    </li>
    <li>
      <a class="nav-link" href="./index.php?page=home" role="button" style="margin-left: -50px; color: #d6800f;">
        <large class="topbar-text">
          <b style="font-family: 'Poppins', sans-serif;">SoundScape: <span style="color: #D7D6D3;">Where Music Meets Innovation</span></b>
        </large>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto align-items-center">
    <?php
    // Check the subscription_id
    if (isset($_SESSION['login_id'])) {
      $subscription_id = $_SESSION['login_subscription_id'];
      if ($subscription_id == 1 || $subscription_id == 2) {
        // Visible for subscription_id 1 or 2
        echo '<a class="btn btn-primary" href="./index.php?page=subscription_plans" style="background-image: linear-gradient(90deg, rgba(255,145,0,1) 0%, rgba(255,141,0,1) 0%, rgba(255,119,0,1) 100%); !important; border-color: #f48c24;font-weight:700; font-family: \'Poppins\' !important; border-radius: 500px;"></i> Get SoundScape Pro</a>';
      } else if ($subscription_id == 3) {
        // Hidden for subscription_id 3
        echo '<a class="btn btn-primary" href="" style="background-color: #f98f1d !important; border-color: #f48c24; font-family: \'Poppins\' !important; font-weight:700 !important; border-radius: 500px; display: none;"></i> Get SoundScape Pro</a>';
      }
    }
    ?>

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
        <span>
          <div class="d-flex badge-pill align-items-center bg-gradient-primary p-1" style="background: #222124 !important;font-family: 'Poppins';">
            <?php if(isset($_SESSION['login_profile_pic']) && !empty($_SESSION['login_profile_pic'])): ?>
              <div class="rounded-circle mr-1" style="width: 25px;height: 25px;top:-5px;left: -40px">
                <img src="assets/uploads/<?php echo $_SESSION['login_profile_pic'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
              </div>
            <?php else: ?>
              <span class="fa fa-user mr-2"></span>
            <?php endif; ?>
            <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
            <span class="fa fa-angle-down ml-2"></span>
          </div>
        </span>
      </a>
      <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
        <button class="dropdown-item" type="button" id="my_profile"><i class="fa fa-id-card"></i> Profile</button>
        <button class="dropdown-item" type="button" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</button>
        <button class="dropdown-item" onclick="location.href='ajax.php?action=logout'"><i class="fa fa-power-off"></i> Logout</button>
      </div>
    </li>
  </ul>
</nav>
<script>
  $('#manage_my_account').click(function() {
    uni_modal("Manage Account", "manage_account.php", "large")
  })
  $('#my_profile').click(function() {
    uni_modal("Profile", "view_user.php?id=<?php echo $_SESSION['login_id'] ?>")
  })
</script>
<!-- /.navbar -->
