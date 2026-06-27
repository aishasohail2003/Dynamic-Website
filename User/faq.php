<?php 
include('config.php'); 
include('header.php'); 
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

<style>
    :root {
        --accent: #ff6b00;
        --card-bg: rgba(0, 0, 0, 0.8); /* Premium Glass Dark */
        --border: rgba(255, 255, 255, 0.1);
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif; 
        background-color: #000;
        /* Theater Background with fixed position */
        background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), 
                          url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #fff;
    }

    .faq-page-wrapper {
        min-height: 100vh;
        padding-top: 100px;
        padding-bottom: 80px;
    }

    .container-xl { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

    .faq-header-v2 { text-align: center; margin-bottom: 60px; }
    .faq-header-v2 h2 { font-size: 45px; font-weight: 800; text-transform: uppercase; letter-spacing: -1px; }
    .faq-header-v2 span { color: var(--accent); text-shadow: 0 0 20px rgba(255, 107, 0, 0.4); }
    .faq-header-v2 p { color: #aaa; font-size: 18px; margin-top: 10px; }

    .faq-grid { display: grid; grid-template-columns: 280px 1fr; gap: 40px; }

    /* --- Sidebar Categories --- */
    .faq-sidebar { position: sticky; top: 120px; height: fit-content; }
    .category-list { list-style: none; padding: 0; }
    .cat-item {
        padding: 18px 20px;
        margin-bottom: 12px;
        border-radius: 12px;
        cursor: pointer;
        transition: 0.4s;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border);
        color: #bbb;
        display: flex;
        align-items: center;
        gap: 15px;
        backdrop-filter: blur(10px);
    }
    
    .cat-item:hover { background: rgba(255, 255, 255, 0.08); color: #fff; }
    
    .cat-item.active {
        background: var(--accent);
        border-color: var(--accent);
        color: #000;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(255, 107, 0, 0.3);
    }

    /* --- FAQ Cards with Smooth Animation --- */
    .faq-card-v2 {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 15px;
        margin-bottom: 18px;
        display: none; /* Controlled by JS */
        backdrop-filter: blur(20px);
        animation: slideUp 0.5s ease forwards;
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .faq-trigger { padding: 25px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
    .faq-trigger h4 { margin: 0; font-size: 18px; font-weight: 600; color: #fff; }
    
    .icon-box { color: var(--accent); font-size: 14px; transition: 0.4s; }
    .faq-card-v2.open .icon-box { transform: rotate(180deg); color: #fff; }

    .faq-body { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-out; }
    .faq-body .inner { 
        padding: 0 25px 25px 25px; 
        color: #ccc; 
        line-height: 1.8; 
        font-size: 16px; 
        border-top: 1px solid rgba(255,255,255,0.05); 
        padding-top: 20px; 
    }

    #no-results { display: none; text-align: center; padding: 50px; background: var(--card-bg); border-radius: 15px; color: #666; }

    @media (max-width: 992px) {
        .faq-grid { grid-template-columns: 1fr; }
        .faq-sidebar { position: relative; top: 0; margin-bottom: 30px; }
        .category-list { display: flex; overflow-x: auto; gap: 10px; padding-bottom: 10px; }
        .cat-item { white-space: nowrap; margin-bottom: 0; }
    }
</style>

<div class="faq-page-wrapper">
    <div class="container-xl">
        <header class="faq-header-v2">
            <h2>Movixo <span>Help Center</span></h2>
            <p>Everything you need to know about your movie experience</p>
        </header>

        <div class="faq-grid">
            <aside class="faq-sidebar">
                <ul class="category-list">
                    <li class="cat-item active" data-target="booking"><i class="fas fa-ticket-alt"></i> Booking</li>
                    <li class="cat-item" data-target="payments"><i class="fas fa-wallet"></i> Payments</li>
                    <li class="cat-item" data-target="account"><i class="fas fa-user-shield"></i> Account</li>
                    <li class="cat-item" data-target="theatre"><i class="fas fa-tv"></i> Theatre Info</li>
                </ul>
            </aside>

            <main class="faq-main-content">
                
                <div class="faq-card-v2" data-category="booking">
                    <div class="faq-trigger"><h4>How do I book a movie ticket?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Browse movies from the home page, select your film, pick a theatre and showtime, choose your seats, and complete the payment. Your ticket will be generated instantly.</div></div>
                </div>
                <div class="faq-card-v2" data-category="booking">
                    <div class="faq-trigger"><h4>Can I book tickets for a future date?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Yes, advance booking is usually available 3-4 days before the show date, depending on the cinema's schedule.</div></div>
                </div>
                <div class="faq-card-v2" data-category="booking">
                    <div class="faq-trigger"><h4>Is there a limit on the number of tickets?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Generally, you can book up to 10 tickets in a single transaction. For bulk or corporate bookings, please contact our support.</div></div>
                </div>

                <div class="faq-card-v2" data-category="payments">
                    <div class="faq-trigger"><h4>What payment methods are supported?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">We support all major Credit/Debit Cards, UPI (PhonePe, Google Pay), Net Banking, and popular digital wallets.</div></div>
                </div>
                <div class="faq-card-v2" data-category="payments">
                    <div class="faq-trigger"><h4>My payment was deducted, but ticket wasn't booked.</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Don't worry! This usually happens due to a network timeout. The amount is automatically refunded by your bank within 5-7 working days.</div></div>
                </div>
                <div class="faq-card-v2" data-category="payments">
                    <div class="faq-trigger"><h4>Are there any extra convenience fees?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Yes, a small internet handling fee is charged per ticket to provide you with a seamless and secure online booking experience.</div></div>
                </div>

                <div class="faq-card-v2" data-category="account">
                    <div class="faq-trigger"><h4>How can I see my previous bookings?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Login to your account and go to the "My Bookings" section from the profile dropdown to see your entire booking history.</div></div>
                </div>
                <div class="faq-card-v2" data-category="account">
                    <div class="faq-trigger"><h4>I forgot my password, what should I do?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Click on "Login", then select "Forgot Password". We will send a password reset link to your registered email address.</div></div>
                </div>
                <div class="faq-card-v2" data-category="account">
                    <div class="faq-trigger"><h4>Can I update my phone number or email?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Yes, you can update your personal details in the "My Profile" section after logging in.</div></div>
                </div>

                <div class="faq-card-v2" data-category="theatre">
                    <div class="faq-trigger"><h4>What is an M-Ticket and how do I use it?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">An M-Ticket is a digital ticket with a QR code. You just need to show this QR code on your phone at the cinema entrance—no printout needed!</div></div>
                </div>
                <div class="faq-card-v2" data-category="theatre">
                    <div class="faq-trigger"><h4>How early should I arrive at the cinema?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">We recommend arriving at least 15-20 minutes before the showtime to complete security checks and find your seat comfortably.</div></div>
                </div>
                <div class="faq-card-v2" data-category="theatre">
                    <div class="faq-trigger"><h4>Do you provide parking facilities?</h4><div class="icon-box"><i class="fas fa-chevron-down"></i></div></div>
                    <div class="faq-body"><div class="inner">Most of our partner theatres provide dedicated parking space, though charges may apply as per the theatre's policy.</div></div>
                </div>

                <div id="no-results">No questions found in this category.</div>
            </main>
        </div>
    </div>
</div>

<script>
    const catItems = document.querySelectorAll('.cat-item');
    const faqCards = document.querySelectorAll('.faq-card-v2');

    // Filter Logic
    function filterFAQ(category) {
        faqCards.forEach(card => {
            if (card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
                card.classList.remove('open');
                card.querySelector('.faq-body').style.maxHeight = null;
            }
        });
    }

    // Default Selection
    filterFAQ('booking');

    // Sidebar Click Event
    catItems.forEach(item => {
        item.addEventListener('click', () => {
            catItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            filterFAQ(item.getAttribute('data-target'));
        });
    });

    // Accordion Toggle
    document.querySelectorAll('.faq-trigger').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const parent = trigger.parentElement;
            const body = trigger.nextElementSibling;
            
            // Toggle active card
            parent.classList.toggle('open');
            
            if (parent.classList.contains('open')) {
                body.style.maxHeight = body.scrollHeight + "px";
            } else {
                body.style.maxHeight = null;
            }
        });
    });
</script>

<?php include('footer.php'); ?>