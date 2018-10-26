
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>SSG | Log in</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/alertify.min.css'); ?>"/>
		<link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/default.min.css'); ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/semantic.min.css'); ?>"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/alertifyjs/css/themes/bootstrap.min.css'); ?>"/> 
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
		  	<div class="login-logo">
		    	<a href="#"><b>Infinit - o</b><br>Client Database</a>
		  	</div>
		  	<div class="login-box-body">
		    	<p class="login-box-msg">Sign in to start your session</p>
			    <form action="#" method="post" id="sign-in">
			      	<div class="form-group has-feedback">
				        <input type="text" class="form-control" placeholder="Username" id="username">
				        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			      	</div>
			      	<div class="form-group has-feedback">
				        <input type="password" class="form-control" placeholder="Password" id="password">
				        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			      	</div>
			      	<div class="row">
				        <!-- <div class="col-xs-8">
					        <div class="checkbox icheck">
					            <label>
					              <input type="checkbox"> Remember Me
					            </label>
					        </div>
				        </div> -->
				        <div class="col-xs-4 pull-right">
				          	<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				        </div>
			    	</div>
			    </form>
			    <a href="#">I forgot my password</a><br>
			    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
		  	</div>
		</div>
	</body>
	<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/custom/main.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/alertifyjs/alertify.js'); ?>"></script> 
	<script>
	  $(function () {
	    $('input').iCheck({
	      checkboxClass: 'icheckbox_square-blue',
	      radioClass: 'iradio_square-blue',
	      increaseArea: '20%' /* optional */
	    });
	  });
	</script>
</html>
