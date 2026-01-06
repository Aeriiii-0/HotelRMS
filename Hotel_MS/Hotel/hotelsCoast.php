<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coast Whale Hotel</title>
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
    color: #2d5f4f;
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
    color: #2d5f4f;
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
    border: 2px solid #3d8b6f; 
    cursor: pointer; 
    background-color: #3d8b6f; 
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
    color: #3d8b6f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(61, 139, 111, 0.3);
  }

  .greenTextBg{
    background: linear-gradient(135deg, #e8f5f0 0%, #d4ebe3 100%);
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
    box-shadow: 0 12px 32px rgba(61, 139, 111, 0.25);
  }

  .card-body {
    padding: 20px;
    background-color: #ffffff;
  }

  .btn-primary {
    background: linear-gradient(135deg, #3d8b6f 0%, #52a382 100%);
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
    box-shadow: 0 8px 20px rgba(61, 139, 111, 0.4);
    background: linear-gradient(135deg, #2d5f4f 0%, #3d8b6f 100%);
  }

  .carousel-caption h5 {
    color: #e8f5f0;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
  }

  .carousel-caption p {
    color: #f0f8f5;
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
            <h5 class="txt-hotel">COAST WHALE HOTEL</h5>
        </div>
        <div class="carousel-item active">
          <img src="images/pristineLobby.png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Welcome to Coast Whale Hotel</h5>
            <p>Where ocean serenity meets coastal elegance in perfect harmony.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/roomWide.png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Breathe in Coastal Tranquility</h5>
            <p>Immerse yourself in rooms inspired by the gentle rhythms of the sea.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/dining.png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Ocean-Inspired Cuisine</h5>
            <p>Savor fresh coastal flavors that celebrate the bounty of the sea.</p>
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
            <h2>WHERE OCEAN MEETS SERENITY</h2>
            <p>
                Coast Whale Hotel embraces the spirit of the sea through calming design, authentic hospitality, and tranquil spaces inspired by coastal beauty. From your first glimpse to your final farewell, experience a harmonious blend of oceanic wonder, natural elegance, and exceptional care.
            </p>
            <p>
                Here, the rhythm of the waves becomes part of your story—a peaceful sanctuary that stays with you long after the tides have turned.
            </p>
            <br>
            <a href="BookCoast.php" class="book-now-button" ">Book Now</a>
        </div>
    </div>
    <br><br><br><br>

    <div class="greenTextBg">
        <div class="serene-text">
            <br><br><br>
            <h2>EMBRACE COASTAL TRANQUILITY</h2>
            <p>
                From the moment you arrive, Coast Whale Hotel envelops you in the soothing embrace of the ocean. Our 379 rooms and suites blend contemporary coastal design with gentle marine artistry, each offering spectacular views of endless horizons, rolling waves, or verdant landscapes—a peaceful escape at every turn.
            </p>

            <p>Whether you seek a seaside sanctuary, a romantic coastal getaway, or a place to celebrate life's precious moments, Coast Whale Hotel offers an experience as timeless as the ocean itself. Step inside and discover a world where comfort, natural beauty, and warm hospitality flow together like the tides.</p>
            
            <br><br><br><br>

            <h2>COASTAL EXPERIENCES</h2>

            <div class="container my-5">
              <div class="row justify-content-center g-4">
                
                <div class="col-md-4">
                  <div class="card">
                    <img src="images/fit.png" class="card-img-top" alt="...">
                    <div class="card-body d-flex justify-content-center">
                      <a href="#" class="btn btn-primary">WELLNESS CENTER</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="card">
                    <img src="images/spa (1).png" class="card-img-top" alt="...">
                    <div class="card-body d-flex justify-content-center">
                      <a href="#" class="btn btn-primary">OCEAN SPA</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="card">
                    <img src="images/pool.png" class="card-img-top" alt="...">
                    <div class="card-body d-flex justify-content-center">
                      <a href="#" class="btn btn-primary">INFINITY POOL</a>
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