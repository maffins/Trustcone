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
  	<link rel="stylesheet" href="/app/webroot/css/dta.css">
    <link href="/app/webroot/css/bootstrap-datepicker.min.css" rel="stylesheet">

  	<!-- Latest compiled and minified JavaScript -->
      <?= $this->Html->script('jquery.min.js') ?>
  	<script src="/app/webroot/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

      <?= $this->Html->script('/app/webroot/js/moment.js') ?>
      <?= $this->Html->script('bootstrap-datepicker.min.js') ?>
      <?= $this->Html->script('jquery.dataTables.js') ?>

      <style type="text/css">
          body { padding: 10px 0px; }
          .textarea { vertical-align: top; }
          .error {font-weight: bold; color: red;}
          dd { clear: left; }

          .dataTables_filter {
              width: 25%;
              float: left;
              margin-top: -23px;
          }
          .dataTables_length {
              float: left;
          }
          th {
              color: black !important;
              vertical-align: text-top !important;
              border: 1px solid #fff862 !important;
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

          .col-md-3 {
              width: 20% !important;
          }
          h2 {
              background-color: #156F30 !important;
              color: #FFD700 !important;
              text-align: center;
          }
          .form-control {
              width: 30% !important;
              float: left !important;
          }
          label {
              float: left !important;
              color: black !important;
          }

          legend {
              color: black !important;
          }

          .table {
              background-color: white !important;
          }
          h1 {
              font-size: 27px !important;
          }
      </style>

  </head>

  <body style="background-color: #fff862">
    <div id="wrapper">
    <?php if (AuthComponent::user()):?>

      <?php endif; ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid" style="background-color: #DEE1DD; width: 99%px; margin: 0 auto">
                    <div class="col-lg-10" style="">

                        <?php
                        if( $this->request->params['controller'] == "pages" )
                        {
                        echo $this->element('mobile/header', ['controller' => $this->request->params['controller']]);
                        } else {
                        echo $this->element('mobile/header-cond', ['controller' => $this->request->params['controller'], 'type' => $this->request->params['pass'][0]]);
                        }
                        ?>
                      <?php //echo $this->element('mobile/header'); ?>
                      <?php echo $this->Session->flash(); ?>
                      <?php echo $this->fetch('content'); ?>                    
                    </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

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
  <?php echo $this->element('sql_dump'); ?>
</html>
