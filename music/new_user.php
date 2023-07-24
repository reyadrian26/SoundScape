
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
		<form action="edit_user.php?id=<?php echo isset($id) ? $id : ''; ?>" id="manage_user" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<b class="text-muted">Personal Information</b>
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Gender</label>
							<select class="custom-select custom-select-sm" name="gender">
							<option <?php echo  isset($gender) && $gender =='Female'?'selected' : "" ?>>Female</option>
							<option <?php echo  isset($gender) && $gender =='Male'?'selected' : "" ?>>Male</option>
							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Contact No.</label>
							<input type="text" name="contact" class="form-control form-control-sm" required value="<?php echo isset($contact) ? $contact : '' ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Address</label>
							<textarea name="address" id="" cols="30" rows="4" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
					<?php
if (isset($_FILES['img']) && $_FILES['img']['name'] != "") {
    $targetDir = "assets/uploads/"; // Directory where the uploaded image will be stored
    $fileName = basename($_FILES['img']['name']); // Get the name of the uploaded file
    $targetFilePath = $targetDir . $fileName; // Path of the uploaded file on the server

    // Check if the file is a valid image
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Invalid image format. Only JPG, JPEG, PNG, and GIF files are allowed.";
        exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFilePath)) {
        $profile_pic = $fileName; // Update the $profile_pic variable with the file name
    } else {
        // Handle the case when the file upload fails
        echo "Error uploading the file.";
        exit;
    }
}
?>

					

					<div class="form-group">
						<label for="" class="control-label">Profile Picture</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
					</div>

					<div class="form-group d-flex justify-content-center">
						<img src="<?php echo isset($profile_pic) ? 'assets/uploads/'.$profile_pic : '' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
					</div>
						<b class="text-muted">System Credentials</b>
						<?php if($_SESSION['login_type'] == 1): ?>
						<div class="form-group">
							<label for="" class="control-label">User Role</label>
							<select name="type" id="type" class="custom-select custom-select-sm">
								<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Subscriber</option>
								<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Admin</option>
							</select>
						</div>
						<?php else: ?>
							<input type="hidden" name="type" value="3">
						<?php endif; ?>
						<div class="form-group">
							<label class="label control-label">Subscription Plan</label>
							<select name="subscription_id" class="custom-select custom-select-sm">
								<?php
								$subscriptions = $conn->query("SELECT * FROM subscriptions")->fetch_all(MYSQLI_ASSOC);
								foreach ($subscriptions as $subscription) {
									$selected = isset($subscription_id) && $subscription_id == $subscription['id'] ? 'selected' : '';
									echo '<option value="' . $subscription['id'] . '" ' . $selected . '>' . $subscription['name'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($id) ? "required":'' ?>>
							<small><i><?php echo isset($id) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
						</div>
						<div class="form-group">
							<label class="label control-label">Confirm Password</label>
							<input type="password" class="form-control form-control-sm" name="cpass" <?php echo !isset($id) ? 'required' : '' ?>>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
	var pass = $('[name="password"]').val();
	var cpass = $('[name="cpass"]').val();
	if(cpass == '' || pass == ''){
		$('#pass_match').attr('data-status', '');
	}else{
		if(cpass == pass){
			$('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>');
		}else{
			$('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>');
		}
	}
});

function displayImg(input, _this) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#cimg').attr('src', e.target.result);
		};
		reader.readAsDataURL(input.files[0]);
	}
}

$('#manage_user').submit(function (e) {
  e.preventDefault();
  $('input').removeClass("border-danger");
  start_load();
  $('#msg').html('');
  if ($('[name="password"]').val() != '' && $('[name="cpass"]').val() != '') {
    if ($('#pass_match').attr('data-status') != 1) {
      if ($("[name='password']").val() != '') {
        $('[name="password"],[name="cpass"]').addClass("border-danger");
        end_load();
        return false;
      }
    }
  }

  console.log("Form submitted.");

  $.ajax({
    url: 'ajax.php?action=save_user',
    data: new FormData($(this)[0]),
    cache: false,
    contentType: false,
    processData: false,
    method: 'POST',
    type: 'POST',
    success: function (resp) {
      console.log("AJAX success:", resp);
      if (resp == 1) {
        alert_toast('Data successfully saved.', "success");
        _redirect('index.php?page=user_list');
        end_load();
      } else if (resp == 2) {
        $('#msg').html("<div class='alert alert-danger'>Email already exists.</div>");
        $('[name="email"]').addClass("border-danger");
        end_load();
      }
    },
    error: function (xhr, status, error) {
      console.log("AJAX error:", xhr, status, error);
      end_load();
    }
  });
});


</script>