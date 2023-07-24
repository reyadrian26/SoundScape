<?php 
include('./db_connect.php');
?>

<!-- Add the SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    .card-body{
        height: 400px;
        font-family: 'Poppins';

    }
    .card1:hover {
      /* background:#00ffb6; */
      /* border:1px solid #00ffb6; */
    }

    .card1:hover .list-group-item{
      background:#00ffb6 !important
    }

    .card2:hover {
      /* background:#00C9FF; */
      /* border:1px solid #00C9FF; */
    }

    .card2:hover .list-group-item{
      background:#00C9FF !important
    }


    .card3:hover {
      /* background:#ff95e9; */
      /* border:1px solid #ff95e9; */
    }

    .card3:hover .list-group-item{
      background:#ff95e9 !important
    }


    .card:hover .btn-outline-dark{
      color:white;
      background:#212529;
    }
    
   h5.card-title{
        font-weight: 600;
    } 

    .symbol{
        font-family: 'Poppins', sans-serif;
    }

    .swal2-popup {
        font-size: 12px;
    }

    .swal2-icon.swal2-info{
        border-color: #ff9100 !important;
        color: black !important;
    }

    .swal2-styled.swal2-confirm{
        background: #ff9100;
    }

    ul.li-subscription{
        margin-bottom:60px;
        list-style-type: none;
        padding-left:5px;
    }

    ul.li-subscription li{
        margin-bottom: 10px;
        
    }

    .fa-solid.fa-check{
        margin-right:10px;
    }
    
    .muted{
        color: lightgray;
    }
  
   
</style>

<script>
    // Function to show the SweetAlert message
    function showSubscriptionAlert(plan) {
        let message = '';
        
        if (plan === 'Free') {
            message = "You are already subscribed to our SoundScape Free Plan.";
        } else if (plan === 'Basic') {
            message = "You are already subscribed to our SoundScape Basic Plan.";
        } else if (plan === 'Pro') {
            message = "You are already subscribed to our SoundScape Pro Plan.";
        }
        
        Swal.fire({
            title: message,
            text: 'Please contact your administrator to manage your subscription.',
            icon: "info",
            customClass: {
                popup: "swal2-popup",
            },
        });
    }
</script>

<div class="container-fluid">
    <?php
    $title = isset($_GET['page']) ? ucwords(str_replace("_", ' ', $_GET['page'])) : "Home";
    ?>
    <h1 class="m-0 text-gradient-primary" style="font-family: 'Poppins', sans-serif !important;font-size: 25px;font-weight: 600;margin-top:  10px !important;"><?php echo $title ?></h1>
    <div class="container p-5">

        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card card1 h-100">
                    <div class="card-body" style="color: black !important;">
                        <h5 class="card-title">SoundScape Free</h5>
                        <br><br>
                        <span class="h2"><span class="symbol">₱</span> 0.00</span>/month
                        <br><br>
                        <ul class="li-subscription">
                            <li><i class="fas fa-solid fa-check"></i>Free access to songs</li>
                            <li><i class="fas fa-solid fa-check"></i>Access to playlists</li>
                            <li class="muted"><i class="fas fa-solid fa-check"></i>Create and modify playlists</li>
                            <li class="muted"><i class="fas fa-solid fa-check"></i>Download songs</li>
                            <li class="muted"><i class="fas fa-solid fa-check"></i>Upload your own tracks</li>
                        </ul>
                        <div class="d-grid my-3">
                            <?php
                            // Check if the user's subscription_id is 3 (Pro Plan)
                            if (isset($_SESSION['login_id']) && $_SESSION['login_subscription_id'] == 3) {
                                // Show SweetAlert if the user is already subscribed to Pro Plan
                                echo '
                                <button class="btn btn-outline-dark btn-block" onclick="showSubscriptionAlert(\'Pro\')">Select</button>
                                ';
                            } else if (isset($_SESSION['login_id']) && $_SESSION['login_subscription_id'] == 2) {
                                // Show SweetAlert if the user is already subscribed to Basic Plan
                                echo '
                                <button class="btn btn-outline-dark btn-block" onclick="showSubscriptionAlert(\'Basic\')">Select</button>
                                ';
                            } else {
                                // Otherwise, show the normal Select button
                                echo '<button class="btn btn-outline-dark btn-block" onclick="showSubscriptionAlert(\'Free\')">Select</button> ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card card2 h-100">
                    <div class="card-body">
                        <h5 class="card-title">SoundScape Basic</h5>
                        <br><br>
                        <span class="h2"><span class="symbol">₱</span> 59.00</span>/month
                        <br><br>
                        <ul class="li-subscription">
                            <li><i class="fas fa-solid fa-check"></i>Free access to songs</li>
                            <li><i class="fas fa-solid fa-check"></i>Access to playlists</li>
                            <li><i class="fas fa-solid fa-check"></i>Create and modify playlists</li>
                            <li class="muted"><i class="fas fa-solid fa-check"></i>Download songs</li>
                            <li class="muted"><i class="fas fa-solid fa-check"></i>Upload your own tracks</li>
                        </ul>
                        <div class="d-grid my-3">
                            <?php
                            // Check if the user's subscription_id is 3 (Pro Plan)
                            if (isset($_SESSION['login_id']) && $_SESSION['login_subscription_id'] == 3) {
                                // Show SweetAlert if the user is already subscribed to Pro Plan
                                echo '
                                <button class="btn btn-outline-dark btn-block" onclick="showSubscriptionAlert(\'Pro\')">Select</button>
                                ';
                            } else if (isset($_SESSION['login_id']) && $_SESSION['login_subscription_id'] == 2) {
                                // Show SweetAlert if the user is already subscribed to Basic Plan
                                echo '
                                <button class="btn btn-outline-dark btn-block" onclick="showSubscriptionAlert(\'Basic\')">Select</button>
                                ';
                            } else {
                                // Otherwise, show the normal Select button
                                echo '<a href="./index.php?page=payment" class="btn btn-outline-dark btn-block">Select</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card card3 h-100">
                    <div class="card-body">
                        <h5 class="card-title">SoundScape Pro</h5>
                        <br><br>
                        <span class="h2"><span class="symbol">₱</span> 99.00</span>/month
                        <br><br>
                        <ul class="li-subscription">
                            <li><i class="fas fa-solid fa-check"></i>Free access to songs</li>
                            <li><i class="fas fa-solid fa-check"></i>Access to playlists</li>
                            <li><i class="fas fa-solid fa-check"></i>Create and modify playlists</li>
                            <li><i class="fas fa-solid fa-check"></i>Download songs</li>
                            <li><i class="fas fa-solid fa-check"></i>Upload your own tracks</li>
                        </ul>
                        <div class="d-grid my-3">
                            <?php
                            // Check if the user's subscription_id is 3 (Pro Plan)
                            if (isset($_SESSION['login_id']) && $_SESSION['login_subscription_id'] == 3) {
                                // Show SweetAlert if the user is already subscribed to Pro Plan
                                echo '
                                <button class="btn btn-outline-dark btn-block" onclick="showSubscriptionAlert(\'Pro\')">Select</button>
                                ';
                            } else if (isset($_SESSION['login_id']) && $_SESSION['login_subscription_id'] == 2) {
                                // Show the normal Select button
                                echo '<a href="./index.php?page=payment" class="btn btn-outline-dark btn-block">Select</a>';
                            } else {
                                // Otherwise, show the normal Select button
                                echo '<a href="./index.php?page=payment" class="btn btn-outline-dark btn-block">Select</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>