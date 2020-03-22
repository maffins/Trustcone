<!DOCTYPE html>
<html lang="en">
  <head>
	<title>
        Matjhabeng Local Municipality -
        Document Management System
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
      <script src="/app/webroot/js/jquery.min.js"></script>
      <script src="/app/webroot/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


      <script src="/app/webroot/js/moment.js"></script>
      <script src="/app/webroot/js/bootstrap-datepicker.min.js"></script>
      <script src="/app/webroot/js/jquery.dataTables.js"></script>
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

      </style>

  </head>

  <body style="background-color: #fff862">
    <div id="wrapper">
    <?php if( AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()):?>
        <!-- Sidebar -->
        <div id="sidebar-wrapper" style="display: none">

            <ul class="nav nav-pills nav-stacked">
                <li></li>
                <li style="color: #00A5E3">Matjhabeng</li>
                <li><a href="http://trustconetest.co.za/users/logout">Click here to Logout</a></li>

                <?php  if (AuthComponent::user()['user_type_id'] != 9) : ?>
                    <?php if (AuthComponent::user()['user_type_id'] == 2 || AuthComponent::user()['user_type_id'] == 3 || AuthComponent::user()['user_type_id'] == 11 || AuthComponent::user()['user_type_id'] == 10 ):?>
                    <li><?php echo $this->Html->link(__('Urgent Documents'), array('controller' => 'documents', 'action' => 'urguent')); ?> </li>
                    <?php endif?>
                    <?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
                    <li><?php echo $this->Html->link(__('Reports'), array('controller' => 'pages', 'action' => 'report')); ?> </li>
                    <?php endif?>
                    <?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
                    <li><?php echo $this->Html->link(__('Settings'), array('controller' => 'pages', 'action' => 'settings')); ?> </li>
                    <?php endif?>
                    <?php if (AuthComponent::user()['user_type_id'] != 6 && AuthComponent::user()['user_type_id'] != 15):?>
                        <li><?php echo $this->Html->link(__('Documents list'), array('controller' => 'documents', 'action' => 'index')); ?> </li>
                    <?php endif?>
                    <?php if (AuthComponent::user()['user_type_id'] == 1 || AuthComponent::user()['user_type_id'] == 8 || AuthComponent::user()['user_type_id'] == 7 || AuthComponent::user()['user_type_id'] == 12 || AuthComponent::user()['user_type_id'] == 13 ):?>
                     <li><?php echo $this->Html->link(__('Capture Document'), array('controller' => 'documents', 'action' => 'add')); ?> </li>
                    <?php endif?>
                    <li style="display:none "><?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index')); ?></li>
                <?php
                     $userSession = AuthComponent::user();
                      if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 || $userSession['user_type_id'] == 11 || $userSession['user_type_id'] == 10):
                ?>

                    <li><?php echo $this->Html->link(__('View Documents by directorates'), array('controller' => 'departments', 'action' => 'index')); ?> </li>
                    <?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
                        <li><?php echo $this->Html->link(__('Reports'), array('controller' => 'pages', 'action' => 'report')); ?> </li>
                          <li><?php echo $this->Html->link(__('Settings'), array('controller' => 'pages', 'action' => 'settings')); ?> </li>
                    <?php endif?>
                <?php
                 endif;
                ?>

                <?php endif ; ?>


            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <?php endif; ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid" style="background-color: #DEE1DD;">
                <div class="col-lg-12" style="">

                      <?php
                        if( $this->request->params['controller'] == "pages" )
                        {
                            echo $this->element('header', ['controller' => $this->request->params['controller']]);
                        } else {
                            echo $this->element('header-cond', ['controller' => $this->request->params['controller'], 'type' => $this->request->params['pass'][0]]);
                        }
                      ?>
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
  <!-- scripts_for_layout -->
<?php echo $scripts_for_layout; ?>
<!-- Js writeBuffer -->
<?php
if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
// Writes cached scripts
?>
</html>
