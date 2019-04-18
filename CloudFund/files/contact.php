<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<link rel="stylesheet" type="text/css" href="static/contact.css">
</head>
<body>

	<?php include 'navbar.php'; ?>

	<?php include 'modals.php'; ?>

<section class="content container-fluid">
		<div class="contact-section">
            <div class="container">
              <h2>Contact Us</h2>
              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <form id="ContactForm" class="form-horizontal" autocomplete="off">
                    <div class="form-group">
                      <label for="ContactName">Name</label>
                      <input type="text" class="form-control" id="ContactName" placeholder="Please enter your full name">
                    </div>
                    <div class="form-group">
                      <label for="ContactEmail">Email</label>
                      <input type="email" class="form-control" id="ContactEmail" placeholder="Please enter your email">
                    </div>
                    <div class="form-group ">
                      <label for="ContactText">Your Message</label>
                     <textarea class="form-control" rows="5" id="ContactText" placeholder="Do you have any feedback? Please do let us know"></textarea> 
                    </div>
					<div class="col-xs-12">
						<button id="submitContactButton" type="submit" class="btn btn-default center-block">Send Message!</button>
					</div>
				  </form>

                  <hr>
				  <h3 id="submitResult"></h3>
                  <!--  <h3>Our Social Sites</h3>
                  <ul class="list-inline banner-social-buttons">
                    <li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-twitter"> <span class="network-name">Twitter</span></i></a></li>
                    <li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-facebook"> <span class="network-name">Facebook</span></i></a></li>
                    <li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-youtube-play"> <span class="network-name">Youtube</span></i></a></li>
                  </ul>-->
                </div>
              </div>
            </div>
        </div>	
   </section>
<?php include 'footer.php'; ?>
<script src="static/contact.js"></script>
</body>
</html>