<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dining</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
      .header-img{
        width: 100%;
        height: 415px;
        object-fit: fit;
      }

      .card-img-overlay {
        display: flex;
        flex-direction: column;
        justify-content: center; 
        align-items: center;   
        text-align: center;
      }

      .card {
        border-radius: 20px;
      }
      
      .card-child {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        
      }

      .card-child:hover {
        transform: translateY(-8px); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.25); 
      }
      

      .heading-offers {
        margin-left: 10%;
      }

      #myCarousel .carousel-control {
        background: none; 
      }

      .offer-p{
        text-shadow: 5px 5px 10px rgb(12, 14, 6);
      } 

      .card-title{
        font-family: 'Georgia', serif; 
        font-weight: bold;
        margin-top: -1px;
      }
      .top-header {
            background: linear-gradient(135deg, #B2A195 0%, #9f8681 100%);
            height: 20px;
      }
      .logo {
        max-height: 110px;
        width: auto;
        display: block;
        margin: 25px auto;
      }

      body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #faf8f6;
            color: #6b5d57; 
      }

      .hotel-image {
            display: block;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-radius: 0;
            width: 100%;
            height: 450px;

      }
      .seperator-block{
        height: 75px;
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 15px 0;
      }

      .intro-title {
            font-family: 'Georgia', serif; 
            font-size: 4.9rem; 
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
            font-size: 1.3rem;
            font-weight: 300;
        }

        .card-img-top{
          
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;

        }


    </style>
  </head>
  <body>

  <?php include 'HomeNavbar.php'; ?>
    
    <img src="images/banner-1.png" alt="Luxury Hotel Exterior and Pool" class="hotel-image img-fluid ">
    
    <section class="py-5">
        <div class="container text-center">
            <h2 class="intro-title">Restaurant and Fine Dining</h2>
            
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    
                    <p class="intro-body">
                      Treat your palate and senses to an irresistible selection of international dishes — from Filipino and other Asian favorites to European and American specialties — all crafted to perfection by our acclaimed chefs.
                    </p>
                    
                    <p class="intro-body mt-4">
                      Indulge in vibrant flavors, comforting classics, and bold culinary twists as each dish is prepared with the finest ingredients and inspired techniques. Whether you’re craving something familiar or eager to explore new tastes, every plate promises a memorable dining experience.
                    </p>
                    
                </div>
            </div>
        </div>
    </section>

    

  <div class="container mt-4">
  <div class="row">

    <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-1.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Noir et Mer</h4>
          <p class="card-text">Coastal-inspired Filipino dishes elevated with sophisticated French and Asian touches.</p>
          <p class="card-text"><small class="text-muted">4.3 Rating</small></p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-2.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Le Lotus Filipino</h4>
          <p class="card-text">Artfully plated dishes celebrating the richness of Philippine heritage.</p>
          <br>
          <p class="card-text"><small class="text-muted">4.5 Rating</small></p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-3.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Sining Kusina</h4>
          <p class="card-text">Where culinary artistry meets the soul of Filipino cuisine.</p>
          <br>
          <p class="card-text"><small class="text-muted">4.2 Rating</small></p>
        </div>
      </div>
    </div>

     <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-4.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Celestia</h4>
          <p class="card-text">A refined journey through coastal and grilled Filipino delicacies..</p>
          <br>
          <p class="card-text"><small class="text-muted">4.4 Rating</small></p>
        </div>
      </div>
    </div>

     <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-5.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Opaline</h4>
          <p class="card-text">Sleek, modern fusion of Philippine heritage with French technique and delicate Chinese flavors.</p>
          <p class="card-text"><small class="text-muted">4.7 Rating</small></p>
        </div>
      </div>
    </div>

     <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-6.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Ginto at Lasa</h4>
          <p class="card-text">Golden, luxurious takes on classic Filipino recipes.</p>
          <br>
          <p class="card-text"><small class="text-muted">4.6 Rating</small></p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-7.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Pista & Palais</h4>
          <p class="card-text">Festive Filipino flavors transformed into exquisite French-inspired courses with Chinese subtlety.</p>
          
          <p class="card-text"><small class="text-muted">4.9 Rating</small></p>
        </div>
      </div>
    </div>

     <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-8.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">L'Artisan Filipina</h4>
          <p class="card-text">Handcrafted Filipino flavors presented with French precision and Asian elegance..</p>
          <br>
          <p class="card-text"><small class="text-muted">4.1 Rating</small></p>
          
        </div>
      </div>
    </div>

     <div class="col-md-4 mb-4">
      <div class="card card-child h-100">
        <img class="card-img-top" src="images/restaurant-9.jpeg" alt="">
        <div class="card-body">
          <h4 class="card-title">Horizon</h4>
          <p class="card-text">Contemporary fusion where Philippine heritage meets the sophistication of French and Chinese cuisine.</p>
          <p class="card-text"><small class="text-muted">4.3 Rating</small></p>
        </div>
      </div>
    </div>
  </div>
</div>

    <br>
    <br>
    <h1 class="col-md-4 mb-4 heading-offers">OTHER OFFERS</h1>


<div class="container" >
   <div id="myCarousel" class="carousel slide" data-ride="carousel" >
      <ol class="carousel-indicators">
         <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
         <li data-target="#myCarousel" data-slide-to="1"></li>
         <li data-target="#myCarousel" data-slide-to="2"></li>
         <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
         <div class="item active">
            <img src="images/offers-1.jpg" alt="Chania"style="width: 100%; height: 350px; object-fit: cover;">
            <div class="carousel-caption">
               <h3 class="offer-p">Coffee Shop Bar</h3>
               <p class="offer-p">A bright, inviting space offering the perfect start or midday boost. Enjoy expertly crafted espresso drinks, slow-pour single-origin coffee, and refreshing cold brews, all served by friendly baristas in a comfortable atmosphere designed for conversation or focused work.</p>
            </div>
         </div>
         <div class="item">
            <img src="images/offers-2.jpeg" alt="Chania"style="width: 100%; height: 350px; object-fit: cover;">
            <div class="carousel-caption">
               <h3 class="offer-p">Wine and Alcohol Bar</h3>
               <p class="offer-p">Savor the evening in a sophisticated setting. Our bar features a curated selection of global wines, local craft beers, and signature cocktails mixed to perfection. It's the ideal spot for a relaxing nightcap or to socialize over premium spirits.</p>
            </div>
         </div>
         <div class="item">
            <img src="images/offers-3.jpg" alt="Flower"style="width: 100%; height: 350px; object-fit: cover;">
            <div class="carousel-caption">
               <h3 class="offer-p">Pastry Shop</h3>
               <p class="offer-p">Step into a haven of sweet aromas and delicate artistry. We offer freshly baked croissants, flaky Danish pastries, rich cakes, and tempting tarts, all handcrafted daily. Treat yourself to a moment of delicious indulgence with a perfect pastry pairing.</p>
            </div>
         </div>
         <div class="item">
            <img src="images/offers-4.jpg" alt="Flower"style="width: 100%; height: 350px; object-fit: cover;">
            <div class="carousel-caption">
               <h3 class="offer-p">Hotel Pantry</h3>
               <p class="offer-p">Designed for convenience and comfort, the Hotel Pantry offers a quick, self-serve selection available 24/7. Find essential snacks, chilled beverages, microwaveable meals, travel necessities, and freshly brewed coffee to satisfy any craving day or night.</p>
            </div>
         </div>
      </div height: 350px;>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span></a><a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span> 
      </a>
   </div>
</div>

<br><br><br><br>

  </body>
</html>
