<style> 
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Modern Header Design */
    .main-header {
        background-color: #ffffff;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo-section {
        flex: 0 0 auto;
    }

    .logo {
        max-height: 65px;
        width: auto;
        display: block;
    }

    .nav-section {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .main-nav {
        display: flex;
        list-style: none;
        gap: 45px;
        margin: 0;
        padding: 0;
        align-items: center;
    }

    .main-nav > li:not(:last-child) a {
        color: #6b5d57;
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
        position: relative;
        padding: 5px 0;
    }

    .main-nav > li:not(:last-child) a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #9f8681, #B2A195);
        transition: width 0.3s ease;
    }

    .main-nav > li:not(:last-child) a:hover {
        color: #9f8681;
    }

    .main-nav > li:not(:last-child) a:hover::after {
        width: 100%;
    }

    .main-nav > li:last-child a {
        text-decoration: none;
    }

    .book-now-button {
        padding: 12px 32px; 
        border-radius: 30px; 
        border: none;
        cursor: pointer; 
        background: linear-gradient(135deg, #9f8681 0%, #B2A195 100%);
        color: white; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px; 
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(159, 134, 129, 0.3);
    }

    .book-now-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(159, 134, 129, 0.4);
        background: linear-gradient(135deg, #8a7570 0%, #a08f84 100%);
    }

    /* Mobile Menu Toggle */
    .mobile-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        color: #6b5d57;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .nav-section {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .nav-section.active {
            display: block;
        }

        .main-nav {
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .mobile-toggle {
            display: block;
        }

        .header-container {
            position: relative;
        }
    }
</style>

<header class="main-header">
    <div class="header-container">
        <div class="logo-section">
            <a href="index.php">
                <img src="images/coastwhale-logo-removebg.png" class="logo" alt="Coast Whale Hotel Logo">
            </a>
        </div>

        <button class="mobile-toggle" onclick="toggleMobileMenu()">☰</button>

        <nav class="nav-section" id="mainNav">
            <ul class="main-nav">
                <li><a href="hotelsPristine.php">Hotels</a></li>
                <li><a href="dining-section.php">Dining</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="hotel.php#about">About Us</a></li>
                <li><a href="BookPristine.php"><button class="book-now-button">Book Now</button></a></li>
            </ul>
        </nav>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('active');
    }
</script>