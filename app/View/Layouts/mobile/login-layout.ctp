<!DOCTYPE html>
<html lang="en">
  <head>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

  	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/app/webroot/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/webroot/css/lavish-bootstrap.css">
  	<link rel="stylesheet" href="/app/webroot/css/simple-sidebar.css">

  	<!-- Latest compiled and minified JavaScript -->
  	<script src="/app/webroot/js/jquery-1.12.0.min.js"></script>
  	<script src="/app/webroot/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
      <style type="text/css">
          body { padding: 70px 0px; }
          .textarea { vertical-align: top; }
          .error {font-weight: bold; color: red;}
          dd { clear: left; }

          .dataTables_filter {
              width: 25%;
              float: left;
              margin-top: -23px;
          }
          .dataTables_length {
              width: 35%;
              float: left;
          }
          th {
              color: black !important;
              vertical-align: text-top !important;
              border: 2px solid #fff862 !important;
          }

          a {
              color: black !important;
          }

          td {
              color: black !important;
          }

          #wrapper {
              padding-left: 0;
          }
          .btn-info {
              color: #FFD700 !important;
          }
          .btn-info:hover {
              color: #fff !important;
          }

          .btn {
              background-color: #156F30 !important;
          }
          input[type="submit"] {
              -webkit-appearance: button;
              cursor: pointer;
              color: #FFD700;
              background-color: #156F30 !important;
              border-color: #5a7c62;
              padding: 3px;
          }

          h2 {
              background-color: #156F30 !important;
              color: black;
              text-align: center;
          }
          .col-md-3 {
              width: 20% !important;
          }
          .panel-heading {
          padding: 0 !important;
          }
      </style>
    <style type="text/css">
    	body{ padding: 70px 0px; }
    </style>

  </head>

  <body style="background-color: #fff862">
    <div id="wrapper">
     
        <!-- Page Content -->
        <div id="page-content-wrapper-login" style="width: 75%; margin: 0 auto;position: relative">
            <div class="container-fluid" style="background-color: #DEE1DD;">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $this->element('mobile/header'); ?>
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->fetch('content'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        <br style="clear: both;" />
    </div>
    <!-- /#wrapper --> 
       <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
  </body>
  <br style="clear: both" />
  <?php echo $this->element('sql_dump'); ?>
</html>
