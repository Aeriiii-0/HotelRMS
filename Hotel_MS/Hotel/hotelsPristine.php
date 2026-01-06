<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>

  .overlay{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 15px;
      white-space: nowrap;
  }
    
  .overlay img {
    height: auto;
    width: 100px;
  }

  .overlay h5{
color: white;
    font-size: 65px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    letter-spacing: 2px;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
  }

  .fili-section {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 60px;
    padding: 50px 0;
}

.fili-images {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    width: 550px; 
}

.fili-images img {
    width: 100%;
    border-radius: 3px;
    object-fit: cover;
}

.fili-text {
    max-width: 600px;
}

.fili-text h2 {
    font-family: 'Georgia', serif; 
    font-size: 27px;
    letter-spacing: 2px;
    margin-bottom: 20px;
}

.fili-text p {
      line-height: 1.9;
    font-size: 1.05rem;
    font-weight: 300;
    color: #555;
    margin-bottom: 15px;
}
.serene-text{
      max-width: 900px;
       margin: 0 auto; 
    padding: 0 20px;
}

.serene-text h2{
      font-family: 'Georgia', serif; 
    font-size: 27px;
    letter-spacing: 2px;
    margin-bottom: 20px;
    text-align: center;
}
.serene-text p{
    line-height: 1.9;
    font-size: 1.05rem;
    font-weight: 300;
    color: #555;
    margin-bottom: 15px;
    text-align: center;
    
}
  .book-now-button {
             padding: 7px 25px; 
             border-radius: 25px; 
             border: 2px solid #9f8681; 
             cursor: pointer; 
             background-color: #9f8681; 
             color: white; 
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             font-size: 13px; 
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

         .brownTextBg{
             background-color: #F5F5F5;
             height: 1100px;
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

          .btn-primary {
             background: linear-gradient(135deg, #9f8681 0%, #B2A195 100%);
             border: none;
             padding: 12px 32px;
             border-radius: 25px;
             font-weight: 600;
             text-transform: uppercase;
             letter-spacing: 1px;
             transition: all 0.3s ease;
             font-size: 10px;
         }

         .btn-primary:hover {
             transform: translateY(-3px);
             box-shadow: 0 8px 20px rgba(159, 134, 129, 0.4);
             background: linear-gradient(135deg, #8a7570 0%, #a08f84 100%);
         }



    </style>
</head>
<body>


    <div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="overlay">
        <img src="images/whiteLogo.png" alt="">
        <h5 class="txt-hotel">PRISTINE HOTEL</h5>
    </div>
    <div class="carousel-item active">
      <img src="images/pristineLobby.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Welcome to Pristine Hotel</h5>
        <p>Experience timeless elegance and warm hospitality the moment you arrive.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/roomWide.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Unwind in Pure Comfort</h5>
        <p>Relax in our thoughtfully designed rooms crafted for peace and relaxation.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/dining.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>A Taste of Luxury</h5>
        <p>Indulge in exquisite dishes prepared with the finest ingredients.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<br><br><br>
<div class="fili-section">
    <div class="fili-images">
        <img src="images/room1.png" alt="">
        <img src="images/bar.png" alt="">
        <img src="images/bathroom.png" alt="">
        <img src="images/buffet.png" alt="">
        <img src="images/conference.png" alt="">
        <img src="images/room.png" alt="">
    </div>

    <div class="fili-text">
        <br>
        <h2>ENVELOPED IN TIMELESS ELEGANCE</h2>
        <p>
            Pristine Hotel redefines luxury through artful design, genuine service, and serene spaces crafted for your comfort. From arrival to farewell, guests experience a curated blend of warmth, sophistication, and world-class hospitality.
        </p>
        <p>
             Here, luxury is more than an offering—it is a feeling that follows you long after you leave.
        </p>
        <br>
       <a href="BookPristine.php" class="book-now-button">Book Now</a>
    </div>
</div>
<br><br><br><br>

<div class="brownTextBg">

<div class="serene-text">
        <br><br><br>
        <h2>AWAKEN TO SERENE LUXURY</h2>
        <p>
          From the moment you arrive, Pristine Hotel surrounds you with elegance and comfort. Our 379 rooms and suites blend contemporary sophistication with subtle Filipino artistry, each offering breathtaking views of the sea, mountains, or city skyline—a serene escape at every glance.
        </p>

        <p>Whether you are seeking a peaceful retreat, a romantic escape, or a place to celebrate life’s milestones, Pristine Hotel offers an experience that lingers long after your stay. Step inside and discover a world where comfort, elegance, and Filipino warmth embrace you in every detail.</p>
        
        <br><br><br><br>

        <h2>RECREATIONAL ACTIVITIES</h2>

         <div class="container my-5">
  <div class="row justify-content-center g-4">
    
    <div class="col-md-4"> <div class="card">
        <img src="images/fit.png" class="card-img-top" alt="...">
        <div class="card-body d-flex justify-content-center">
          <a href="#" class="btn btn-primary">FITNESS CENTER</a>
        </div>
      </div>
    </div>

     <div class="col-md-4"> <div class="card">
        <img src="images/spa (1).png" class="card-img-top" alt="...">
        <div class="card-body d-flex justify-content-center">
          <a href="#" class="btn btn-primary">HAGOD MASSAGE</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4"> <div class="card">
        <img src="images/pool.png" class="card-img-top" alt="...">
        <div class="card-body d-flex justify-content-center">
          <a href="#" class="btn btn-primary">POOL PENT</a>
        </div>
      </div>
    </div>

   

    </div>
</div>

          
    </div>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>