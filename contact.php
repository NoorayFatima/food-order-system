<?php include('partials-front/menu.php'); ?>

<?php  
// Handle form submission
$message_sent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_sent = true;
}
?>
<!-- Contact Section Starts Here -->
<section class="contact">
    <div class="container">
        <h2 class="text-center">Contact Us</h2>
        <?php if ($message_sent): ?>
            <div class="success-message" id="success-message" style="color: #27ae60; background: #eafaf1; border: 1px solid #b2f2d7; padding: 15px; border-radius: 5px; text-align: center; margin-bottom: 20px;">
                Thank you for contacting us! Your message has been received. We will get back to you soon.
            </div>
            <script>
                setTimeout(function() {
                    var msg = document.getElementById('success-message');
                    if(msg) msg.style.display = 'none';
                }, 2500);
            </script>
        <?php endif; ?>
        <div class="contact-info">
            <div class="contact-details">
                <h2>Get in Touch</h2>
                <br>
                <p><strong>Address:</strong> 123 Food Street, Flavor Town, Country</p>
                <p><strong>Phone:</strong> +1 234 567 890</p>
                <p><strong>Email:</strong> info@restaurant.com</p>
                <br>
                <div class="social-links">
                    <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png" alt="Facebook" width="32"></a>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png" alt="Instagram" width="32"></a>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png" alt="Twitter" width="32"></a>
                </div>
            </div>
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="#" method="post">
                    <input type="text" name="name" placeholder="Your Name" required class="input-field">
                    <input type="email" name="email" placeholder="Your Email" required class="input-field">
                    <textarea name="message" rows="5" placeholder="Your Message" required class="input-field"></textarea>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
