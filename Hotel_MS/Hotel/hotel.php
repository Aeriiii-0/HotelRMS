<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coast Whale Luxury Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style> 
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #faf8f6;
        }
        
        .hotel-image {
            display: block;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-radius: 0;
        }

        .intro-title {
            font-family: 'Georgia', serif; 
            font-size: 2.8rem; 
            color: #6b5d57; 
            margin-bottom: 2.5rem;
            font-weight: 300;
            letter-spacing: 3px;
            position: relative;
            padding-bottom: 20px;
        }

        .intro-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #B2A195, transparent);
        }

        .intro-body {
            line-height: 1.9;
            color: #7a6f6a;
            font-size: 1.05rem;
            font-weight: 300;
        }

        .btn-primary {
            background: linear-gradient(135deg, #9f8681 0%, #B2A195 100%);
            border: none;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(159, 134, 129, 0.4);
            background: linear-gradient(135deg, #8a7570 0%, #a08f84 100%);
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 32px rgba(159, 134, 129, 0.25);
        }

        .card-body {
            padding: 25px;
            background-color: #ffffff;
        }

        .card-title {
            font-family: 'Georgia', serif;
            color: #6b5d57;
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 15px;
        }

        .card-text {
            color: #7a6f6a;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        section {
            background-color: #faf8f6;
        }

        .experiences-section {
            background-color: #ffffff;
            padding: 60px 0;
        }

        .about-section {
            background-color: #f5f1ed;
            padding: 80px 0;
        }

        .about-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .about-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            flex-wrap: wrap;
            gap: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-family: 'Georgia', serif;
            font-size: 3rem;
            color: #9f8681;
            font-weight: 300;
            display: block;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #6b5d57;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-title {
            font-family: 'Georgia', serif; 
            font-size: 2.5rem; 
            color: #6b5d57; 
            margin-bottom: 3rem;
            font-weight: 300;
            letter-spacing: 3px;
            position: relative;
            padding-bottom: 20px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #B2A195, transparent);
        }

        .experience-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #9f8681 0%, #B2A195 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 24px;
        }
    </style>
</head>

<body>

    <?php include 'HomeNavbar.php'; ?>
    
    <img src="images/2.png" alt="Coast Whale Luxury Hotel Exterior and Pool" class="hotel-image img-fluid w-100">

    <section class="py-5">
        <div class="container text-center">
            
            <h2 class="intro-title">A SANCTUARY OF ELEGANCE</h2>
            
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    
                    <p class="intro-body">
                      The Coast Whale Hotel features two pillars of elegance: the Signature Suites for contemporary Philippine comfort, and the Pinnacle Collection for global design and unrivaled personalized service.
                    </p>
                    
                    <p class="intro-body mt-4">
                     Located on its expansive Sunset Beachfront in Veridia City, the hotel is 45 minutes from VIG, 15 minutes from major districts, and near the Coral Bay Yacht Club and Grand Veridia Arena.
                    </p>
                    
                </div>
            </div>
        </div>
    </section>

    <section class="about-section" id="about">
        <div class="container">
            <h2 class="section-title text-center">ABOUT COAST WHALE HOTEL</h2>
            
            <div class="about-content text-center">
                <p class="intro-body">
                    Coast Whale Hotel stands as a beacon of Philippine luxury hospitality, where contemporary elegance meets timeless tradition. Since our founding, we have dedicated ourselves to creating unforgettable experiences that celebrate the natural beauty of our coastal paradise and the warmth of Filipino hospitality.
                </p>
                
                <p class="intro-body mt-4">
                    Our commitment to excellence extends beyond luxurious accommodations. We believe in sustainable tourism that honors our environment, supports local communities, and preserves the pristine beauty of Sunset Beachfront for generations to come. Every detail, from our locally-sourced cuisine to our eco-conscious practices, reflects our deep respect for the land and sea that surrounds us.
                </p>

                <p class="intro-body mt-4">
                    Whether you seek a romantic escape, a family adventure, or a corporate retreat, Coast Whale Hotel offers a sanctuary where memories are made and dreams become reality. Our dedicated team ensures that every guest receives personalized service that exceeds expectations.
                </p>

                <div class="about-stats">
                    <div class="stat-item">
                        <span class="stat-number">250+</span>
                        <span class="stat-label">Luxury Suites</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Dining Venues</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Concierge Service</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Guest Satisfaction</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="experiences-section">
        <div class="container">
            <h2 class="section-title text-center">EXPERIENCES TO DISCOVER</h2>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="experience-icon">🌊</div>
                            <h3 class="card-title">Beachfront Serenity</h3>
                            <p class="card-text">Immerse yourself in the tranquil beauty of our private Sunset Beachfront. Enjoy morning yoga sessions, sunset cocktails, and exclusive beach amenities designed for ultimate relaxation.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="experience-icon">🍽️</div>
                            <h3 class="card-title">Culinary Journey</h3>
                            <p class="card-text">Indulge in world-class dining experiences featuring contemporary Filipino cuisine and international flavors. Our award-winning chefs create memorable gastronomic adventures.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="experience-icon">💆</div>
                            <h3 class="card-title">Wellness Retreat</h3>
                            <p class="card-text">Rejuvenate at our luxury spa featuring traditional Filipino healing therapies, infinity pools, and state-of-the-art fitness facilities with ocean views.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="experience-icon">⛵</div>
                            <h3 class="card-title">Marine Adventures</h3>
                            <p class="card-text">Explore the crystal-clear waters with our exclusive yacht excursions, snorkeling expeditions, and water sports activities. Partner access to Coral Bay Yacht Club included.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="experience-icon">🎭</div>
                            <h3 class="card-title">Cultural Immersion</h3>
                            <p class="card-text">Experience authentic Filipino culture through curated art exhibitions, live traditional performances, and guided heritage tours of Veridia City's historic landmarks.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="experience-icon">🎪</div>
                            <h3 class="card-title">Grand Events</h3>
                            <p class="card-text">Host unforgettable celebrations in our elegant ballrooms and outdoor venues. From intimate gatherings to grand galas, our event team ensures perfection in every detail.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>