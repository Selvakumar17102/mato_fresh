<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['submit'])){
        if($_POST['name'] && $_POST['email'] && $_POST['phone'] && $_POST['message']){
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $phone = strip_tags($_POST['phone']);
            $message = strip_tags($_POST['message']);

            require("b2b/PHPMailer/src/PHPMailer.php");
            require("b2b/PHPMailer/src/SMTP.php");
            require("b2b/PHPMailer/src/Exception.php");
    
            $mail = new PHPMailer(true);
    
            try {
                $mail->isSMTP();                                          //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
                $mail->Username   = 'ubintegritysolutions@gmail.com';     //SMTP username
                $mail->Password   = 'nebwxmpbuncrievg';                   //SMTP password
                $mail->SMTPSecure = 'ssl';                                //Enable implicit TLS encryption
                $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('ubintegritysolutions@gmail.com', "$name - $email");
                $mail->addAddress('info@matofresh.com');

                //Content
                $mail->isHTML(true);                                      //Set email format to HTML
                $mail->Subject = 'Contact - MatoFresh';
                $mail->Body = "<html>
                                    <body>
                                        <table rules='all' style='border: 1px solid #666' cellpadding='10'>
                                            <tr>
                                                <td> <strong>Name:</strong> </td>
                                                <td> $name </td>
                                            </tr>
                                            <tr>
                                                <td> <strong>Mobile Number:</strong> </td>
                                                <td> $phone </td>
                                            </tr>
                                            <tr>
                                                <td> <strong>Email:</strong> </td>
                                                <td> $email </td>
                                            </tr>
                                            <tr>
                                                <td> <strong>Message:</strong> </td>
                                                <td> $message </td>
                                            </tr>
                                        </table>
                                    </body>
                                </html>";
    
                $mail->send();
?>
                <script>
                    alert("Your message has been sent successfully. We will contact you soon.");
                    window.location.href="index.php";
                </script>
<?php
            } catch (Exception $e) {
?>
                <script>
                    alert("Your message not sent try again.");
                    window.location.href="index.php";
                </script>
<?php
            }
        } else{
?>
            <script>
                alert("Please enter all the field.");
                window.location.href="index.php";
            </script>
<?php
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Order Vegetable, Fruits, Exotic Vegetables online</title>
	<meta content="MatoFresh delivers fresh Vegetables, Fruits, Exotic Vegetables to your home. We serve in select areas in Hyderabad." name="descriptison">
	<meta content="MatoFresh" name="keywords">
	<meta name="google-site-verification" content="YkLqI4pCMN0JRw5aXCXSvLB2PN_P-VSANA-hZfQTn9M">

	<link href="assets/img/favicon.png" rel="png">
	<link href="assets/img/favicon.ico" rel="icon">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
	<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
	<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
	<link href="assets/vendor/aos/aos.css" rel="stylesheet">

	<link href="assets/css/style.css" rel="stylesheet">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179986905-1"></script>
</head>
<body>
<main id="main">
	<section id="hero">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 pt-lg-0 order-1 order-lg-1 d-flex align-items-center" style="margin-bottom: 20px;">
					<div data-aos="zoom-out">
						<center><img style="height: 100px;margin-bottom: 20px;background: #fff;" src="assets/img/logo.png" alt=""></center>
						<h1><center>Fresh from Farm - <span>Delivered to your Home</span></center></h1>
						<h2><center>Same day delivery*!</center></h2>
						<h2><center>Order through our <b style="color: #fff;">Mobile app</b> now!</center></h2>
						<div class="text-center">
							<a href="https://play.google.com/store/apps/dev?id=7536629920875802700"><img style="height: 80px" src="assets/img/playstore.png" alt=""></a>
						</div>
					</div>
				</div>
				<div class="col-lg-5 order-2 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
					<img src="assets/img/hero-img.png" class="img-fluid animated">
				</div>
			</div>
		</div>
		<svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
			<defs>
				<path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
			</defs>
			<g class="wave1">
				<use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
			</g>
			<g class="wave2">
				<use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
			</g>
			<g class="wave3">
				<use xlink:href="#wave-path" x="50" y="9" fill="#fff">
			</g>
		</svg>

	</section><!-- End Hero -->
	
	<!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">

        <div class="row">
         
		  <div class="col-xl-5 aos-init aos-animate" data-aos="fade-right">
            <center><img src="assets/img/1.png" class="img-fluid" alt=""></center>
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5" data-aos="fade-left">
            <h3>Why order from Mato Fresh?</h3>

            <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>Fresh Vegetables and Fruits, fresh from the farm</a></h4>
            </div>

            <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>Wide range of varieties</a></h4>
            </div>

            <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>Exclusive Exotic vegetable delivery</a></h4>
            </div>
			
			<div class="icon-box" data-aos="zoom-in" data-aos-delay="400">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>100% safe and hygienic delivery</a></h4>
            </div>

            <div class="icon-box" data-aos="zoom-in" data-aos-delay="500">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>Same day delivery to select locations*</a></h4>
            </div>

            <div class="icon-box" data-aos="zoom-in" data-aos-delay="600">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>Premium Vegetables at an Unbeatable price</a></h4>
            </div>
			
			<div class="icon-box" data-aos="zoom-in" data-aos-delay="700">
              <div class="icon"><i class="bx bxs-heart"></i></div>
              <h4 class="title"><a>Delivery at your doorsteps</a></h4>
            </div>

          </div>
        </div>

      </div>
	  </section>
	  
	  <section id="details" class="details" style="padding: 20px 0;">
      <div class="container">	
		<div class="section-title" data-aos="fade-up" style="padding-bottom: 0px;">
          <p style="text-align: center;">Products</p>
		</div>	  
	  <div class="row content">
		<div class="col-md-12 pt-1 order-2 order-md-1" data-aos="fade-up" >
            <p class="font-italic" style="text-align: center;font-size: 18px;">
              The best and fresh Online store and supermarket to order fresh vegetables, fresh fruits, and
exotic vegetables in Hyderabad. We also deliver the best grocery items to your home in the
Hyderabad region! Top-quality and fresh products at an unmatchable prices. Buy now at store
price and get free home delivery for orders above Rs. 500.
            </p>
			</div>
          <div class="col-md-4 pt-3 order-2 order-md-1" data-aos="fade-up">
			<h3>Exotic Vegetables</h3>
            <ul class="pt-3">
				<li><i class="icofont-check"></i>Avacado(butter Fruit)</li>
				<li><i class="icofont-check"></i>Broccoli</li>
				<li><i class="icofont-check"></i>Brussel Sprouts</li>
				<li><i class="icofont-check"></i>Baby Corn (peeled)</li>
				<li><i class="icofont-check"></i>Baby Carrot</li>
				<li><i class="icofont-check"></i>Celery</li>
				<li><i class="icofont-check"></i>Chinese Cabbage</li>
				<li><i class="icofont-check"></i>Capsicum Red</li>
				<li><i class="icofont-check"></i>Capsicum Yellow</li>
				<li><i class="icofont-check"></i>Dhill Leaves</li>
				<li><i class="icofont-check"></i>Leeks</li>
				<li><i class="icofont-check"></i>Galangal(thai Ginger)</li>
				<li><i class="icofont-check"></i>Leetuce Romaine</li>
				<li><i class="icofont-check"></i>Lettuce Rocket</li>
				<li><i class="icofont-check"></i>Lettuce Leafy</li>
				<li><i class="icofont-check"></i>Lettuce Curle</li>
				<li><i class="icofont-check"></i>Lettuce Lolorosa</li>
				<li><i class="icofont-check"></i>Lettuce Iceberg(ball)</li>
				<li><i class="icofont-check"></i>Pakchoy</li>
				<li><i class="icofont-check"></i>Parsely</li>
				<li><i class="icofont-check"></i>Red Cabbage</li>
				<li><i class="icofont-check"></i>Haricots Verts Beans</li>
				<li><i class="icofont-check"></i>Red Radish Long</li>
				<li><i class="icofont-check"></i>Tomato Cherry</li>
				<li><i class="icofont-check"></i>Zucchini Green</li>
				<li><i class="icofont-check"></i>Zucchini Yellow</li>
				<li><i class="icofont-check"></i>Rosemary</li>
				<li><i class="icofont-check"></i>Thyme</li>
				<li><i class="icofont-check"></i>Basil</li>
				<li><i class="icofont-check"></i>Fennel</li>
				<li><i class="icofont-check"></i>Lemon Grass</li>
				<li><i class="icofont-check"></i>European Cucumber</li>
				<li><i class="icofont-check"></i>Paneer Grapes Seed</li>
				<li><i class="icofont-check"></i>Strawberry</li>
				<li><i class="icofont-check"></i>Mushroom</li>
             </ul>
          </div>
		  <div class="col-md-4 pt-3 order-2 order-md-1" data-aos="fade-up">
			<h3>Vegetables</h3>
            <ul class="pt-3">					
				<li><i class="icofont-check"></i>Big Onion</li>
				<li><i class="icofont-check"></i>Ladies finger</li>
				<li><i class="icofont-check"></i>Tomato</li>
				<li><i class="icofont-check"></i>Cauliflower</li>
				<li><i class="icofont-check"></i>Carrot</li>
				<li><i class="icofont-check"></i>Raw banana</li>
				<li><i class="icofont-check"></i>Banana-stem</li>
				<li><i class="icofont-check"></i>Beans</li>
				<li><i class="icofont-check"></i>Beetroot</li>
				<li><i class="icofont-check"></i>Bitter Gourd</li>
				<li><i class="icofont-check"></i>Bottle Gourd</li>
				<li><i class="icofont-check"></i>Brinjal</li>
				<li><i class="icofont-check"></i>Cabbage</li>
				<li><i class="icofont-check"></i>Coconut</li>
				<li><i class="icofont-check"></i>Colocasia</li>
				<li><i class="icofont-check"></i>Cucumber</li>
				<li><i class="icofont-check"></i>Elephant-foot</li>
				<li><i class="icofont-check"></i>Fresh-ginger</li>
				<li><i class="icofont-check"></i>Fresh-radish</li>
				<li><i class="icofont-check"></i>Green-peas</li>
				<li><i class="icofont-check"></i>Lemon</li>
				<li><i class="icofont-check"></i>Raw Mango</li>
				<li><i class="icofont-check"></i>Potato</li>
				<li><i class="icofont-check"></i>Pumpkin</li>
				<li><i class="icofont-check"></i>Peerkangai</li>
				<li><i class="icofont-check"></i>Snake-gourd</li>
				<li><i class="icofont-check"></i>Onion</li>
				<li><i class="icofont-check"></i>Avarakai</li>
				<li><i class="icofont-check"></i>Chowchow</li>
				<li><i class="icofont-check"></i>Chillies</li>
				<li><i class="icofont-check"></i>Mint</li>
				<li><i class="icofont-check"></i>Karileaves</li>
				<li><i class="icofont-check"></i>Karna kilagu</li>
				<li><i class="icofont-check"></i>Soyabeans</li>
				<li><i class="icofont-check"></i>Coriander leaves</li>
				<li><i class="icofont-check"></i>Drumstick</li>
				<li><i class="icofont-check"></i>Banana-flower</li>
				<li><i class="icofont-check"></i>Butter beans</li>
             </ul>
          </div>
		  <div class="col-md-4 pt-3 order-2 order-md-1" data-aos="fade-up">
			<h3>Fruits</h3>
            <ul class="pt-3">					
				<li><i class="icofont-check"></i>Avocado</li>
				<li><i class="icofont-check"></i>Amla</li>
				<li><i class="icofont-check"></i>Apple</li>
				<li><i class="icofont-check"></i>Banana karpuram</li>
				<li><i class="icofont-check"></i>Banana Poovan</li>
				<li><i class="icofont-check"></i>Banana Nendran</li>
				<li><i class="icofont-check"></i>Banana Rasthali</li>
				<li><i class="icofont-check"></i>Banana RED</li>
				<li><i class="icofont-check"></i>Custard Apple</li>
				<li><i class="icofont-check"></i>Grapes Paneer</li>
				<li><i class="icofont-check"></i>Guava</li>
				<li><i class="icofont-check"></i>Lemon</li>
				<li><i class="icofont-check"></i>Orange Nagpur</li>
				<li><i class="icofont-check"></i>Papaya</li>
				<li><i class="icofont-check"></i>Pineapple</li>
				<li><i class="icofont-check"></i>Pomegranate</li>
				<li><i class="icofont-check"></i>Sapota</li>
				<li><i class="icofont-check"></i>Sweet Lime</li>
				<li><i class="icofont-check"></i>Watermelon Kiran</li>
				
             </ul>
          </div>
        </div>
		
    </section><!-- End About Section -->
	
	<!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery" style="padding: 0px 0;">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <p>App Screenshots</p>
        </div>

        <div class="row no-gutters" data-aos="fade-left">

         

          <div class="col-lg-2 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="150">
              <a href="assets/img/2.png" class="venobox" data-gall="gallery-item">
                <img src="assets/img/2.png" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-2 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
              <a href="assets/img/3.png" class="venobox" data-gall="gallery-item">
                <img src="assets/img/3.png" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-2 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="250">
              <a href="assets/img/4.png" class="venobox" data-gall="gallery-item">
                <img src="assets/img/4.png" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-2 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
              <a href="assets/img/5.png" class="venobox" data-gall="gallery-item">
                <img src="assets/img/5.png" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-2 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="350">
              <a href="assets/img/6.png" class="venobox" data-gall="gallery-item">
                <img src="assets/img/6.png" alt="" class="img-fluid">
              </a>
            </div>
          </div>

         

          <div class="col-lg-2 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="350">
              <a href="assets/img/8.png" class="venobox" data-gall="gallery-item">
                <img src="assets/img/8.png" alt="" class="img-fluid">
              </a>
            </div>
          </div>


          

        </div>

      </div>
    </section><!-- End Gallery Section -->
	
	
	
	<!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials" style="padding: 20px 0;">
      <div class="container">
		<div class="section-title" data-aos="fade-up">
          <p style="color: #fff;text-align: center;">Our Happy Clients</p>
		</div>
        <div class="owl-carousel testimonials-carousel" data-aos="zoom-in">

          <div class="testimonial-item">
            <h3>Radha</h3>
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Fresh Vegetables, amazing products. I loved the quick delivery.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
          </div>

          <div class="testimonial-item">
            <h3>Kishore</h3>
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Best price, one time delivery
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
          </div>

          <div class="testimonial-item">
            <h3>Uma Devi</h3>
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Quality products, I will order again
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
          </div>

          <div class="testimonial-item">
            <h3>Jothi</h3>
            <h4>Freelancer</h4>
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              I liked the way they packed the vegetables, good quality too.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
          </div>

          
        </div>

      </div>
    </section><!-- End Testimonials Section -->
	
	<!-- ======= Contact Section ======= -->
    <section id="contact" class="contact" style="padding: 20px 0;">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <p>Contact Us</p>
        </div>

        <div class="row">

          <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
            <div class="info">            

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email</h4>
                <p><a href="mailto:info@matofresh.com">info@matofresh.com</a></p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Call</h4>
                <p><a href="tel:+918328257338">+91 83282 57338</a></p>
              </div>
			  
			  <div class="phone">
                <i class="icofont-whatsapp"></i>
                <h4>Whatsapp</h4>
                <p><a href="https://api.whatsapp.com/send?phone=918328257338&text=Enquiry%20of%20Mato%20Fresh">+91 83282 57338</a></p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">

            <form action="index.php" method="post" role="form1" class="php-email-form">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required/>
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required/>
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" data-rule="minlen:4" data-msg="Please enter a valid phone number" required/>
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message" required></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit" name="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->
	
	</main>
	<!-- ======= Footer ======= -->
  <footer id="footer" style="padding: 25px;">

    <div class="container">
        <div class="policies" style="display: flex; justify-content: space-evenly">
          <a href="https://matofresh.in/about-us/" style="color: white;">About Us</a>
          <a href="https://matofresh.in/terms-conditions/" style="color: white;">Terms and Conditions</a>
          <a href="https://matofresh.in/privacy-policy/" style="color: white;">Privacy Policy</a>
          <a href="https://matofresh.in/contact-us/" style="color: white;">Contact Us</a>
          <a href="https://matofresh.in/shipping_policy/" style="color: white;">Cancellation Policy</a>
        </div>
      <div class="copyright">
        2022 &copy; <strong><span>MatoFresh</span></strong>. All Rights Reserved. 
		Designed &amp; Developed by <a href="https://www.gtechwebsolutions.com/" target="_blank" style="color: #000;font-weight: 600;">G Tech Solutions</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

	<!-- Vendor JS Files -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
	<script src="assets/vendor/venobox/venobox.min.js"></script>
	<script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
	<script src="assets/vendor/counterup/counterup.min.js"></script>
	<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
	<script src="assets/vendor/aos/aos.js"></script>

	<!-- Template Main JS File -->
	<script src="assets/js/main.js"></script>

</body>

</html>