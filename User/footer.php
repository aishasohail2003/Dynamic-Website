<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<footer class="modern-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h3 class="footer-logo">Movixo <span class="accent-text">Theatre</span></h3>
            <p class="footer-desc">
                Experience cinema like never before. From the latest blockbusters to timeless classics, we bring the magic of the big screen to your fingertips.
            </p>
            <div class="social-links">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <h4>Quick Explore</h4>
            <ul>
                <li><a href="index.php"><i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-right: 5px;"></i> Home</a></li>
                <li><a href="theatre.php"><i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-right: 5px;"></i> Theatre</a></li>
                <li><a href="contact.php"><i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-right: 5px;"></i> Contact Us</a></li>
                <li><a href="faq.php"><i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-right: 5px;"></i> FAQs</a></li>
                <li><a href="review.php"><i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-right: 5px;"></i> Review</a></li>
            </ul>
            </ul>
        </div>

        <div class="footer-newsletter">
            <h4>Get In Touch</h4>
            <p style="color: #888; font-size: 14px; margin-bottom: 10px;">
                <i class="fa-solid fa-location-dot" style="color: var(--accent); margin-right: 10px;"></i> North Nazimabad, Cinema City
            </p>
            <p style="color: #888; font-size: 14px; margin-bottom: 10px;">
                <i class="fa-solid fa-phone" style="color: var(--accent); margin-right: 10px;"></i> +92 2121714
            </p>
            <p style="color: #888; font-size: 14px;">
                <i class="fa-solid fa-envelope" style="color: var(--accent); margin-right: 10px;"></i> aptech@movixo.com
            </p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> <span style="color: var(--accent);">Movixo</span>. All Rights Reserved.</p>
    </div>
</footer>

<style>
/* --- STYLES (No changes in layout, only icons support) --- */
:root {
    --accent: #ff6b00;
    --footer-bg: #0a0a0a;
}

.modern-footer {
    background: var(--footer-bg);
    color: white;
    padding: 60px 0 20px 0;
    margin-top: 80px;
    border-top: 1px solid rgba(255,255,255,0.05);
    font-family: 'Poppins', sans-serif !important;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 40px;
    padding: 0 20px;
}

.footer-brand { flex: 1 1 300px; }
.footer-logo { font-size: 26px; font-weight: 800; margin-bottom: 15px; text-transform: uppercase; }
.accent-text { color: var(--accent); }
.footer-desc { color: #888; line-height: 1.6; font-size: 14px; margin-bottom: 25px; }

.social-links { display: flex; gap: 15px; }
.social-links a {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.05);
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%; color: white; text-decoration: none;
    transition: 0.3s;
}
.social-links a:hover { background: var(--accent); transform: translateY(-5px); }

.footer-links { flex: 0 1 200px; }
.footer-links h4 { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
.footer-links ul { list-style: none; padding: 0; }
.footer-links ul li { margin-bottom: 12px; }
.footer-links ul li a { color: #888; text-decoration: none; font-size: 14px; transition: 0.3s; }
.footer-links ul li a:hover { color: var(--accent); }

.footer-newsletter { flex: 1 1 250px; }
.footer-newsletter h4 { font-size: 18px; font-weight: 700; margin-bottom: 20px; }

.footer-bottom {
    margin-top: 50px;
    padding: 25px 20px;
    text-align: center;
    border-top: 1px solid rgba(255,255,255,0.05);
}
.footer-bottom p { 
    color: #ffffff; 
    font-size: 13px; 
    font-weight: 700 !important; /* Bold Bold Bold */
    text-transform: uppercase; 
    letter-spacing: 1px; 
}

@media (max-width: 768px) {
    .footer-container { flex-direction: column; text-align: center; }
    .social-links { justify-content: center; }
}
</style>

</body>
</html>