<?php 
include('./db_connect.php');
?>

<style>
  /* Add this CSS code */
  .form-check-input:checked {
    border-color: #ff9100;
  }
  
  .form-check-input:checked::before {
    background-color: #ff9100;
  }
  .form-check-input.payment[type="radio"] {
    margin-top: 1.5rem;

  }

  .confirm-subscription-btn {
    height: 60px; 
    background: orange;
    border: none;
    color: #fff;
    font-size: 16px;
    width:100%;
    transition: all 0.3s ease;
  }

  .confirm-subscription-btn:hover{
    background:#f5b342;
  }

  .confirm-subscription-btn i {
    margin-left: 10px;
  }

  .confirm-btn{
    display: flex;
    justify-content:center;
  
  }
</style>

<section style="background-color: #eee;font-family:'Poppins', sans-serif;">
  <div class="container py-5">
    <div class="row d-flex justify-content-center">
      <div class="col-md-12 col-lg-10 col-xl-8">
        <div class="card">
          <div class="card-body p-md-5">
            <div>
              <h4>Upgrade your plan</h4>
              <p class="text-muted pb-2">
        
              </p>
            </div>

            <form action="payment_process.php" method="post">
              <?php
              // Check the user's subscription_id
              if (isset($_SESSION['login_subscription_id']) && $_SESSION['login_subscription_id'] == 1) {
                  // If subscription_id is 1 (Free Plan), show both options
                  echo '
                  <div class="px-3 py-4 border border-primary border-2 rounded mt-4 d-flex justify-content-between payment-plan" style="border:1px solid !important;border-color: #ff9100 !important;">
                    <div class="d-flex flex-row align-items-center">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="plan" id="plan_basic" value="basic" required>
                        <label class="form-check-label" for="plan_basic">
                          <span class="h5 mb-1">SoundScape Basic</span>
                          <!-- <span class="small text-muted">CHANGE PLAN</span> -->
                        </label>
                      </div>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                      <sup class="dollar font-weight-bold text-muted">₱</sup>
                      <span class="h2 mx-1 mb-0">59.00</span>
                      <span class="text-muted font-weight-bold mt-2">/ month</span>
                    </div>
                  </div>
                  ';
              }
              ?>
              
              <div class="px-3 py-4 border border-primary border-2 rounded mt-4 d-flex justify-content-between payment-plan"  style="border:1px solid !important;border-color: #ff9100 !important;">
                <div class="d-flex flex-row align-items-center">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan" id="plan_pro" value="pro" required>
                    <label class="form-check-label" for="plan_pro">
                      <span class="h5 mb-1">SoundScape Pro</span>
                      <!-- <span class="small text-muted">CHANGE PLAN</span> -->
                    </label>
                  </div>
                </div>
                <div class="d-flex flex-row align-items-center">
                  <sup class="dollar font-weight-bold text-muted">₱</sup>
                  <span class="h2 mx-1 mb-0">99.00</span>
                  <span class="text-muted font-weight-bold mt-2">/ month</span>
                </div>
              </div>

              <h4 class="mt-5">Payment details</h4>

              <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center">
                  <div class="form-check ">
                    <input class="form-check-input payment" type="radio" name="payment_method" id="payment_gcash" value="gcash">
                    <label class="form-check-label" for="payment_gcash">
                      <img src="images/gcash-logo.png" class="rounded" width="70" style="margin-right: 10px;" />
                      <span class="h5 mb-1">GCash</span>
                    </label>
                  </div>
                </div>
                <div>
                <input type="text" name="account_number" class="form-control" placeholder="Account Number" style="width: 180px;" />
                </div>
              </div>

              <div class="mt-2 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center">
                  <div class="form-check">
                    <input class="form-check-input  payment " type="radio" name="payment_method" id="payment_paypal" value="paypal" >
                    <label class="form-check-label" for="payment_paypal">
                      <img src="images/paypal-logo.png" class="rounded" width="70" style="margin-right: 10px;" />
                      <span class="h5 mb-1">PayPal</span>
                    </label>
                  </div>
                </div>
                <div>
                <input type="text" name="account_number2" class="form-control" placeholder="Account Number" style="width: 180px;" />
                </div>
              </div>

              <div class="form-outline">
                <label class="form-label" for="formControlLg" style="margin-top: 20px;font-weight: 400;">Email address</label>
                <input type="text" name="email" id="formControlLg" class="form-control form-control-lg" required/>

              </div>
              <div class="mt-3 confirm-btn">
                <button type="submit" class="confirm-subscription-btn">
                  Confirm Subscription <i class="fas fa-long-arrow-alt-right"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MDB -->
<script
type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
></script>
