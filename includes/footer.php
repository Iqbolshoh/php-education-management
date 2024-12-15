<footer id="footer" class="footer position-relative dark-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 col-sm-12 footer-about mb-4">
                <a href="./" class="d-flex align-items-center">
                    <span class="sitename">Iqbolshoh</span>
                </a>
                <div class="footer-contact pt-3">
                    <p><strong>Location:</strong> <?php echo $contact_boxData[0]['value']; ?></p>
                    <p class="mt-3"><strong>Phone:</strong> <span><?php echo $contact_boxData[1]['value']; ?></span>
                    </p>
                    <p><strong>Email:</strong> <span><?php echo $contact_boxData[2]['value']; ?></span></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 footer-links mb-4">
                <h4>Useful Links</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="./">Home</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="about.php">About Us</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="products.php">Products</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="services.php">Services</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 footer-follow mb-4">
                <h4>Follow Us</h4>
                <p>We will keep you updated with the latest products and offers. Follow us on social media!</p>
                <div class="social-links d-flex">
                    <a href="https://twitter.com/<?php echo $contactData[0]['twitter']; ?>" target="_blank"><i
                            class="bi bi-twitter"></i></a>
                    <a href="https://facebook.com/<?php echo $contactData[0]['facebook']; ?>" target="_blank"><i
                            class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com/<?php echo $contactData[0]['instagram']; ?>" target="_blank"><i
                            class="bi bi-instagram"></i></a>
                    <a href="https://linkedin.com/<?php echo $contactData[0]['linkedin']; ?>" target="_blank"><i
                            class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename"> Iqbolshoh</strong> <span>All rights reserved</span>
        </p>
    </div>

    <style>
        footer .sitename {
            color: var(--accent-color);
        }
    </style>

</footer>