<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Login | SoundScape</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>


<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0;
	    background: rgb(0,0,0);
		background: linear-gradient(338deg, rgba(0,0,0,1) 14%, rgba(54,36,36,1) 41%, rgba(130,120,120,1) 53%, rgba(0,0,0,1) 92%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%) !important;
		display: flex;
	}
	
	.bg-gradient-success.new-acc{
		text-decoration: underline;
	}

	.bg-gradient-success.new-acc:hover{
		color: #f3881f; 
	}

	h4,h6{
		font-family: 'Poppins' !important;
		font-weight: 600;
	}

	.swal2-title{
		margin-bottom: 10px !important;
	}

	.swal2-confirm.swal2-styled{
		background-color: orange !important;
	}

	.swal2-container.swal2-center.swal2-backdrop-show{
		font-family:'Poppins';
	}

	input[type=text]:focus {
  border: 1px solid orange;
}

input[type=password]:focus {
  border: 1px solid orange;
}
</style>

<body class="bg-light">
<!-- Image and text -->
<nav class="navbar navbar-light bg-light" style="background-color: black !important;height:13.5vh;">
<a href="./index.php?page=home" class="brand-link bg-black" data-toggle="" aria-expanded="true" style="background-color: black !important;border-bottom:none">
            <span class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center text-white font-weight-500" style="width: 38px;height:50px;font-size: 2rem;box-shadow: none !important"><b><img src="images/soundscape-logo2.png" style="width: 40px; margin-right: 5px;" alt=""></b></span>
            <span class="brand-text font-weight-light ">
            <i style="font-style: normal; font-family: 'Poppins', sans-serif; font-weight: 600; color: white;">
              Sound<span class="" style="color: #d6800f !important;" style="color: white !important;">Scape</span>
            </i>
              </span>
          </a>
</nav>

  <main id="main" style="
    background: rgb(0,0,0);
    background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(5,5,5,1) 35%, rgba(25,25,25,1) 100%);">	
  	<div class="container">
  		
  		<div class="col-md-8 offset-md-2 d-flex justify-content-center">
  			<div id="login-center" class="row justify-content-center align-self-center w-100" style="
    background-color: black;
    max-width: 734px;
    width: 100%;
    margin-top: 30px;
    padding-bottom: 50%;
    border-radius: 8px;
">
  			<div class="d-flex justify-content-center align-items-center w-100">
  				<span  class="m-4 p-2">
  				<h1 class="text-gradient-primary text-center" style=""><b><i class="fas fa-eadphones-alt text-gradient-primary"></i></b></h1>
  				<h1 class="" style="font-family: 'Poppins', sans-serif;color: white !important"><b>Log in to SoundScape</b></h1>

  				</span>
  			</div>
  			<div class="card col-sm-7" style="
    background-color: black;
">
  				<div class="card-body" style="
    background-color: black;
">
  					<form id="login-form" >
  						<div class="form-group">
						  <label for="exampleInputEmail1" style="color:white;font-family: 'Poppins', sans-serif;">Email address</label>
  							<input type="text" id="email" name="email" class="form-control" placeholder="Enter your email" style="background: transparent;font-family: 'Poppins', sans-serif; font-size: 14px;color:white;">
  						</div>
  						<div class="form-group">
						  <label for="exampleInputPassword1" style="color:white;font-family: 'Poppins', sans-serif;">Password</label>
  							<input type="password" id="password" name="password" class="form-control" placeholder="Password" style="background: transparent;font-family: 'Poppins', sans-serif;font-size: 14px;color:white;">
  						</div>
  						<center><button class="btn btn-block btn-wave btn-primary bg-gradient-primary login-btn" style="background: #f3881f !important;border:  none !important;border-radius: 500px;margin-top: 50px;font-family: 'Poppins', sans-serif;">Login</button></center>
  						<hr>

  						<center><button class="btn btn-block btn-wave btn-success bg-gradient-success new-acc" type="button" id="new_account" style="
    background: none !important;
    border-color: black;font-family: 'Poppins', sans-serif;
">Create New Account</button></center>
  					</form>
  				</div>
  			</div>
  			</div>
  		</div>
  	</div>

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document" style="margin-top:100px;">
      <div class="modal-content" style="
    min-height: 600px;
">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
         <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><b>&times;</b></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- PAGE assets/plugins -->
<!-- jQuery Mapael -->
<script src="assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/dist/js/pages/dashboard2.js"></script>
<!-- DataTables  & Plugins -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
	 window.start_load = function(){
	    $('body').prepend('<div id="preloader2"></div>')
	  }
	  window.end_load = function(){
	    $('#preloader2').fadeOut('fast', function() {
	        $(this).remove();
	      })
	  }
	 window.viewer_modal = function($src = ''){
	    start_load()
	    var t = $src.split('.')
	    t = t[1]
	    if(t =='mp4'){
	      var view = $("<video src='"+$src+"' controls autoplay></video>")
	    }else{
	      var view = $("<img src='"+$src+"' />")
	    }
	    $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
	    $('#viewer_modal .modal-content').append(view)
	    $('#viewer_modal').modal({
	            show:true,
	            backdrop:'static',
	            keyboard:false,
	            focus:true
	          })
	          end_load()  

	}
	  window.uni_modal = function($title = '' , $url='',$size=""){
	      start_load()
	      $.ajax({
	          url:$url,
	          error:err=>{
	              console.log()
	              alert("An error occured")
	          },
	          success:function(resp){
	              if(resp){
	                  $('#uni_modal .modal-title').html($title)
	                  $('#uni_modal .modal-body').html(resp)
	                  if($size != ''){
	                      $('#uni_modal .modal-dialog').addClass($size)
	                  }else{
	                      $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
	                  }
	                  $('#uni_modal').modal({
	                    show:true,
	                    backdrop:'static',
	                    keyboard:false,
	                    focus:true
	                  })
	                  end_load()
	              }
	          }
	      })
	  }
	  window._conf = function($msg='',$func='',$params = []){
	     $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
	     $('#confirm_modal .modal-body').html($msg)
	     $('#confirm_modal').modal('show')
	  }
	   window.alert_toast= function($msg = 'TEST',$bg = 'success' ,$pos=''){
	   	 var Toast = Swal.mixin({
	      toast: true,
	      position: $pos || 'top-end',
	      showConfirmButton: false,
	      timer: 5000
	    });
	      Toast.fire({
	        icon: $bg,
	        title: $msg
	      })
	  }
	  $('#new_account').click(function(){
    uni_modal("<div style='display: flex; align-items: center;'><span class='brand-image img-circle elevation-3 d-flex justify-content-center align-items-center text-white font-weight-500' style='width: 38px;height: 50px;font-size: 2rem;box-shadow: none !important; margin-right: 10px;'><b><img src='images/soundscape-logo2.png' style='width: 40px;' alt=''></b></span><div><h4 style='margin: 0;'>Sign Up</h4><span><h6 class='text-muted' style='margin: 0;'>It’s quick and easy.</h6></span></div></div>","signup.php","large");
})





	$('#login-form').submit(function(e){
    e.preventDefault();
    start_load();
    if($(this).find('.alert-danger').length > 0 )
      $(this).find('.alert-danger').remove();
    $.ajax({
      url:'ajax.php?action=login',
      method:'POST',
      data:$(this).serialize(),
      error:err=>{
        console.log(err);
        end_load();
      },
      success:function(resp){
        if(resp == 1){
          // Show SweetAlert message
          Swal.fire({
            icon: 'success',
            title: 'Login Successful',
            text: 'Welcome to SoundScape!',
            showConfirmButton: true,
            //timer: 1300
          }).then(() => {
            window.location.href = 'index.php?page=home';
          });
        }else{
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
          end_load();
        }
      }
    });
  });
	$('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        val = val.toLocaleString('en-US')
        $(this).val(val)
    })
</script>	
</html>