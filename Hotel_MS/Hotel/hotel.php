<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine Luxury Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style> 
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #faf8f6;
        }

        .bg-color{
            color: #6b5d57;
            font-weight: 500;
            transition: color 0.3s ease;
        } 

        .bg-color:hover {
            color: #9f8681;
        }

        .top-header {
            background: linear-gradient(135deg, #B2A195 0%, #9f8681 100%);
            height: 20px;
        }

        .book-now-button {
            padding: 10px 28px; 
            border-radius: 25px; 
            border: 2px solid #9f8681; 
            cursor: pointer; 
            background-color: #9f8681; 
            color: white; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px; 
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .book-now-button:hover {
            background-color: transparent;
            color: #9f8681;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(159, 134, 129, 0.3);
        }

        .logo {
            max-height: 110px;
            width: auto;
            display: block;
            margin: 25px auto;
        }
        
        .hotel-image {
            display: block;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-radius: 0;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
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

        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-menu {
            background-color: #ffffff;
            border: 1px solid #e8e3df;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 8px 0;
        }

        .dropdown-item {
            color: #6b5d57;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f5f1ed;
            color: #9f8681;
            padding-left: 25px;
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 32px rgba(159, 134, 129, 0.25);
        }

        .card-body {
            padding: 20px;
            background-color: #ffffff;
        }

        section {
            background-color: #faf8f6;
        }

        .nav-item {
            margin: 0 5px;
        }

        .navbar-nav {
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="top-header"></div>

    <img src="images/logo.png" class="logo img-fluid" alt="logo">

    <nav class="navbar navbar-expand-md bg-custom-color">
        <div class="container-fluid">
            
            <a class="navbar-brand px-3 bg-color" href="#"></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav" >
                <ul class="navbar-nav">
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link bg-color" href="#" role="button">
                            Hotels
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="hotelsCoast.php">Coast Whale Hotel</a></li>
                            <li><a class="dropdown-item" href="hotelsPristine.php">Pristine Hotel</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown px-3">
                        <a class="nav-link bg-color" href="dining-section.php" role="button">
                            Dining
                        </a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link bg-color" href="events.php">Events</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link bg-color" href="#">About us</a>
                    </li>
                   <li class="nav-item dropdown">
                        <button class="book-now-button">Book Now</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="BookPristine.php">Pristine Hotel</a></li>
                            <li><a class="dropdown-item" href="BookCoast.php">Coast Whale Hotel</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <img src="images/2.png" alt="Luxury Hotel Exterior and Pool" class="hotel-image img-fluid w-100">

    <section class="py-5">
        <div class="container text-center">
            
            <h2 class="intro-title">A SANCTUARY OF ELEGANCE</h2>
            
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    
                    <p class="intro-body">
                      The Pristine Hotel features two pillars of elegance: the Signature Suites for contemporary Philippine comfort, and the Pinnacle Collection for global design and unrivaled personalized service.
                      </p>
                    
                    <p class="intro-body mt-4">
                     Located on its expansive Sunset Beachfront in Veridia City, the hotel is 45 minutes from VIG, 15 minutes from major districts, and near the Coral Bay Yacht Club and Grand Veridia Arena </p>
                    
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-auto mb-3">
            <div class="card" style="width: 18rem;">
                <img src="images/pristine.png" class="card-img-top" alt="...">
                <div class="card-body d-flex justify-content-center"> 
                    <a href="hotelsPristine.php" class="btn btn-primary">View Pristine Hotel</a>
                </div>
            </div>
        </div>
        
        <div class="col-auto mb-3">
            <div class="card" style="width: 18rem;">
                <img src="images/coast.jpg" class="card-img-top" alt="...">
                <div class="card-body d-flex justify-content-center">
                    <a href="hotelsCoast.php" class="btn btn-primary">View Coast Whale Hotel</a>
                </div>
            </div>
        </div>
        
        </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>