<!DOCTYPE html>
<html>
<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <!-- Title -->
    <title>I Register Companies</title>
    <!-- Meta -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="google-site-verification" content="Ge-HTIz0hFBCHeWGk6uLoi58K1uM6A6XCJkBLRypH2s" />
    <!-- Favicon -->
    <link href="favicon.html" rel="shortcut icon">
    <!-- Bootstrap Core CSS -->
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('bootstrap-datepicker.css') ?>
    <!-- Template CSS -->
    <?= $this->Html->css('animate.css') ?>
    <?= $this->Html->css('font-awesome.css') ?>
    <?= $this->Html->css('nexus.css') ?>
    <?= $this->Html->css('responsive.css') ?>
    <?= $this->Html->css('custom.css') ?>
    <!-- Google Fonts-->
    <link href="http://fonts.googleapis.com/css?family=Lato:400,300" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
<style>
    .headers-label {
        width: 50%;
        float: left;
        font-size: 15px;
        background-color: #363539;
        border-radius: 0.25em;
        color: #ffffff;
        display: inline;
        font-weight: bold;
        line-height: 1;
        padding: 0.2em 0.6em 0.3em;
        vertical-align: baseline;
        white-space: nowrap;
        margin-top: 10px;
    }
    .headers-director-shareholders {
             width: 80%;
             float: left;
             font-size: 15px;
             border-radius: 0.25em;
             color: #ffffff;
             display: inline;
             font-weight: bold;
             line-height: 1;
             padding: 0.2em 0.6em 0.3em;
             vertical-align: baseline;
             white-space: nowrap;
             margin-top: 10px;
            background-color:#5BC0DE;
            border-color:#46B8DA;
            color:#FFFFFF;
         }

    .form-control {
        width: 40%;
        float: left;
    }
    label {
        width: 30%;
        float: left;
    }
    .input {
        margin: 5px 0 5px 0;
    }
</style>

    <!-- JS -->
    <?php echo $this->fetch('jquery.min') ?>
    <script type="text/javascript" src="/js/jquery.min.js" ></script>
    <?php echo $this->fetch('bootstrap.min') ?>
    <script type="text/javascript" src="/js/bootstrap.min.js" ></script>
    <?php echo $this->fetch('bootstrap-datepicker.min') ?>
    <script type="text/javascript" src="/js/bootstrap-datepicker.min.js" ></script>
    <?php echo $this->fetch('script') ?>
    <script type="text/javascript" src="/js/script.js" ></script>
    <!-- Isotope - Portfolio Sorting nnn-->
    <?php echo $this->fetch('jquery.isotope') ?>
    <script type="text/javascript" src="/js/jquery.isotope.js" ></script>
    <!-- Mobile Menu - Slicknav -->
    <?php echo $this->fetch('jquery.slicknav') ?>
    <script type="text/javascript" src="/js/jquery.slicknav.js" ></script>
    <!-- Animate on Scroll-->
    <?php echo $this->fetch('jquery.visible') ?>
    <script type="text/javascript" src="/js/jquery.visible.js" ></script>
    <!-- Slimbox2-->
    <?php echo $this->fetch('slimbox2') ?>
    <script type="text/javascript" src="/js/slimbox2.js" ></script>
    <!-- Modernizr -->
    <?php echo $this->fetch('modernizr.custom') ?>
    <script type="text/javascript" src="/js/modernizr.custom.js" ></script>
    <!-- End JS -->

</head>
<body>
<div id="pre_header" class="visible-lg"></div>
<div id="header" class="container">
    <div class="row">
        <!-- Logo -->
        <div class="logo">
            <a href="/" title="">
                <img src="/img/logo.png" alt="Logo" />
            </a>
        </div>
        <!-- End Logo -->
        <!-- Top Menu -->
        <div class="col-md-12 margin-top-30">
            <div id="hornav" class="pull-right visible-lg">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/pages/services">Services</a> </li>
                    <li><a href="/pages/regprocess">Registration process</a></li>
                    <li><span>Info</span>
                        <ul>
                            <li><a href="/pages/whyus"> Why use us</a></li>
                            <li><a href="/pages/aboutus">About us</a></li>
                            <li><a href="/pages/banking">Banking details</a></li>
                        </ul>
                    </li>
                    <li><a href="/pages/contactus">Contact us</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
        <!-- End Top Menu -->
    </div>
</div>
<!-- === END HEADER === -->
<!-- === BEGIN CONTENT === -->
<div id="content" class="container clearfix">
    <?= $this->Flash->render() ?>
    <div class="container clearfix" style="padding:15px 0 0 0;">
        <?= $this->fetch('content') ?>
    </div>
    <!-- === END CONTENT === -->
    <footer>
        <div id="base">
            <div class="container padding-vert-30">
                <div class="row">
                    <!-- Thumbs Gallery -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-10">Online paymens</h3>
                        <div class="thumbs-gallery">

                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image1.jpg">
                                <img src="/img/payfast.png" alt="payfast.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image2.jpg">
                                <img src="/img/payment-methods-masterpass.png" alt="payment-methods-masterpass.png">
                                <i></i></a>

                        <div style="display: none">
                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image3.jpg">
                                <img src="/img/thumbsgallery/thumbs/image3.jpg" alt="image3.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image4.jpg">
                                <img src="/img/thumbsgallery/thumbs/image4.jpg" alt="image4.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image6.jpg">
                                <img src="/img/thumbsgallery/thumbs/image6.jpg" alt="image6.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image7.jpg">
                                <img src="/img/thumbsgallery/thumbs/image7.jpg" alt="image7.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image8.jpg">
                                <img src="/img/thumbsgallery/thumbs/image8.jpg" alt="image8.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image9.jpg">
                                <img src="/img/thumbsgallery/thumbs/image9.jpg" alt="image9.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image92.jpg">
                                <img src="/img/thumbsgallery/thumbs/image92.jpg" alt="image92.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image94.jpg">
                                <img src="/img/thumbsgallery/thumbs/image94.jpg" alt="image94.jpg">
                                <i></i></a>


                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image95.jpg">
                                <img src="/img/thumbsgallery/thumbs/image95.jpg" alt="image95.jpg">
                                <i></i></a>

                            <a class="thumbBox" rel="lightbox-thumbs" href="/img/thumbsgallery/image96.jpg">
                                <img src="/img/thumbsgallery/thumbs/image96.jpg" alt="image96.jpg">
                                <i></i></a>
                        </div>

                        </div>			<div class="clearfix"></div>
                    </div>
                    <!-- End Thumbs Gallery -->
                    <!-- Contact Details -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-10">Contact Details</h3>
                        <p>3 Russel Road<br />
                            Brynston,<br />
                            Johannesburg,<br />
                            </p>
                        <p> <a href="mailto:info@iregistercompanies.co.za">info@iregistercompanies.co.za</a><br />
                             <a href="http://www.iregistercompanies.co.za/">www.iregistercompanies.co.za</a></p>
                    </div>
                    <!-- End Contact Details -->
                    <!-- Sample Menu -->
                    <div class="col-md-3 margin-bottom-20" >
                        <h3 class="margin-bottom-10">Menu</h3>
                        <ul class="menu">
                            <li>
                                <a class="fa-tasks" href="/pages/termsconditions" >Terms and conditions</a>
                            </li>
                            <li>
                                <a class="fa-users" href="#" >Blog</a>
                            </li>

                            <li>
                                <a class="fa-coffee" href="/pages/testimonials">Testimonials</a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>

                    </div>
                    <!-- End Sample Menu -->
                    <!-- Disclaimer -->
                    <div class="col-md-3 margin-bottom-20">
                        <h3 class="margin-bottom-10">Privacy policy</h3>
                        <p>All our client information is held is strict confidence, and is held securely. We will not distribute or give away your information to anyone.</p>
                        <div class="clearfix"></div>
                    </div>
                    <!-- End Disclaimer -->
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- Footer Menu -->
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div id="copyright" class="col-md-4">
                        <p>(c) 2016 I Register Companies</p>
                    </div>
                    <div id="footermenu" class="col-md-8">
                        <ul class="list-unstyled list-inline pull-right">
                            <li>
                                <a href="/pages/faq" target="" >FAQ</a>
                            </li>
                            <li>
                                <a href="/pages/regprocess" target="" >Registration process</a>
                            </li>
                            <li>
                                <a href="/pages/tendering" target="" >Tendering</a>
                            </li>
                            <li>
                                <a href="#" target="" >Resume</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

<!-- End Footer Menu -->
    <footer>
    </footer>
</body>
</html>
