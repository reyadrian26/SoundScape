<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<form action="" id="signup">
		<div class="col-lg-12">
			<div class="row" style="font-family: 'Poppins' !important;">
				<div class="col-md-6">
				<div id="msg"></div>
					<div class="row" >
						
							<div class="form-group col-md-6">
								<label for="subscription" class="text-muted" style="font-size: 12.8px">First Name</label>
								<input type="text" class="form-control" placeholder="First name" name='firstname'>
							</div>
							<div class="form-group col-md-6">
							<label for="subscription" class="text-muted" style="font-size: 12.8px">Last Name</label>
								<input type="text" class="form-control" placeholder="Last name" name='lastname'>
							</div>
					</div>
					<div class="row">
							<div class="form-group col-md-12">
							<label for="subscription" class="text-muted" style="font-size: 12.8px">Email</label>
								<input type="email" class="form-control" placeholder="Email" name='email'>
							</div>
					</div>
					<div class="row">
							<div class="form-group col-md-12">
							<label for="subscription" class="text-muted" style="font-size: 12.8px">Password</label>
								<input type="password" class="form-control" placeholder="Password" name='password'>
							</div>
					</div>
						<label for="subscription" class="text-muted" style="font-size: 12.8px">Gender</label>
						<div class="row">
							<div class="form-group col-md-4">
								<div class="d-flex w-100 justify-content-between p-1 border rounded align-items center" style="padding: 10px !important;">
									<label for="gfemale" style="margin-left: 15px;margin-bottom: 0px;">Male</label>
									<div class="form-check d-flex w-100 justify-content-end">
						             	<input class="form-check-input" type="radio" id="gmale" name="gender" value="Male">
						            </div>
								</div>
				        	</div>
				            <div class="form-group col-md-4">
								<div class="d-flex w-100 justify-content-between p-1 border rounded align-items center"style="padding: 10px !important;">
									<label for="gmale" style="margin-left: 15px;margin-bottom: 0px;">Female</label>
									<div class="form-check d-flex w-100 justify-content-end">
						             	<input class="form-check-input" type="radio" id="gfemale" name="gender" value="Female">
						            </div>
								</div>
				            </div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<label for="subscription" class="text-muted" style="font-size: 12.8px">Subscription Plan:</label>
								<select class="form-control" id="subscription" name="subscription_id">
								<option value="1" selected>Free Plan</option>
								</select>
							</div>
						</div>

					</div>
					<div class="col-md-6">
							<div class="form-group">
								<input type="text" name="contact" class="form-control form-control-sm" required="" placeholder="Contact">
							</div>
							<div class="form-group">
								<textarea id="" cols="30" rows="4" name="address" class="form-control" placeholder="Address"></textarea>
							</div>
						<div class="form-group">
						<label for="" class="control-label">Profile Picture</label>
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="pp" accept="image/*" onchange="displayImgProfile(this,$(this))">
		                      <label class="custom-file-label" for="customFile">Choose file</label>
		                    </div>
						</div>
						<div class="form-group d-flex justify-content-center rounded-circle" style="margin-bottom: 10px;">
							<img src="" alt="" id="profile" class="img-fluid img-thumbnail rounded-circle" style="max-width: calc(50%)">
						</div>
					</div>

			</div>
		</div>
						<div class="row justify-content-center">
							<button class="btn btn-block btn-success col-sm-5 align-self-center" style="background: #f3881f !important;border-radius:500px;border:none;margin-top: 20px;"><b>Sign Up</b></button>
						</div>
	</form>
</div>
<style>
	#uni_modal .modal-footer{
		display:none
	}
</style>
<script>
	$('#signup').submit(function(e){
  e.preventDefault();
  $('#msg').html('');
  start_load();
  var formData = new FormData($(this)[0]);
  formData.append('subscription_id', $('#subscription').val()); // Add the selected subscription plan ID to the form data
  $.ajax({
    url: "ajax.php?action=signup",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    method: 'POST',
    type: 'POST',
    success: function(resp){
      if(resp == 1){
        // Registration successful
        Swal.fire({
          icon: 'success',
          title: 'Registration Successful',
          text: 'Welcome to SoundScape!',
          showConfirmButton: true,
          //timer: 1300
        }).then(() => {
          location.replace("index.php?page=home");
        });
      }else if(resp == 2){
        $('#msg').html("<div class='alert alert-danger'>Email already exists.</div>");
        end_load();
      }
    }
  });
});

	function displayImgProfile(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#profile').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>
