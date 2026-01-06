<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="styles.css" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <title>Events</title>

    <style>
      .image-container {
        position: relative;
        width: 100%;
        height: 300px;
        overflow: hidden;
      }
      .image-container img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
      }
      .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);

        display: flex;
        justify-content: center;
        align-items: center;
      }
      .overlay-text {
        color: wheat;
        font-size: 32px;
        font-family: "Times New Roman", Times, serif;
        /* font-weight: bold; */
        text-align: center;
        padding: 10px;
      }
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        transition: all 0.2s ease-in-out;
      }
      .card {
        transition: all 0.2s ease-in-out;
      }
    </style>
  </head>
  <body>
    <div class="image-container">
      <img src="images/grand-event.jpg" alt="Hotel Event" />
      <div class="overlay">
        <span class="overlay-text">
          <h1>
            <i
              >Milestones, are worth sanctifying.<br />
              Celebrate it with lux.</i
            >
          </h1>
        </span>
      </div>
    </div>

    <br />
    <div class="container">
      <div class="row align-items-center">
        <p class="lead text-muted">
          Pristine Hotels provides magnificent venues and impeccable service for
          every occasion, from grand celebrations to intimate gatherings. Our
          expert events teams are dedicated to bringing your vision to life.
        </p>
        <br />
        <h2>The Pristine Grandeur - City Events</h2>
        <h6><i>Timeless Elegance, Unforgettable Stays.</i></h6>
      </div>
    </div>

    <div class="container" name="Cards">
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <img
              class="card-img-top"
              src="images/Grand-Imperial.png"
              alt="Grand Imperial"
            />
            <div class="card-body">
              <h5 class="card-title">Grand Imperial Ballroom</h5>
              <p class="card-text">
                A majestic, column-free space accommodating up to 800 guests,
                perfect for lavish weddings, gala dinners, and major
                conferences. Equipped with state-of-the-art audiovisual
                technology.
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
            <img class="card-img-top" src="images/Rooftop.png" alt="Rooftop" />
            <div class="card-body">
              <h5 class="card-title">Rooftop Terrace</h5>
              <p class="card-text">
                A unique outdoor venue offering spectacular city backdrops for
                cocktail receptions, product launches, or intimate celebrations
                under the stars.
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
            <img
              class="card-img-top"
              src="images/ExecRoom.png"
              alt="ExecRoom"
            />
            <div class="card-body">
              <h5 class="card-title">Executive Boardrooms</h5>
              <p class="card-text">
                A suite of elegantly appointed rooms suitable for high-level
                meetings, corporate workshops, and private discussions,
                featuring advanced presentation tools and dedicated support.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />

    <div class="container-fluid" style="background-color: #44210fe7">
      <div class="container" style="padding-top: 20px; padding-bottom: 20px">
        <br />
        <h2 style="color: antiquewhite">
          The Coast Whale Hotel - Coastal Events
        </h2>
        <h6 style="color: antiquewhite"><i>Where Grandeur Meets Calm.</i></h6>
        <div class="row">
          <div class="col-sm-4">
            <div class="card">
              <img
                src="images/AzurePav.png"
                class="card-img-top"
                alt="Azure Pavillion"
              />
              <div class="card-body">
                <h5 class="card-title">Azure Pavillion</h5>
                <p class="card-text">
                  A versatile event space with retractable glass walls, offering
                  breathtaking ocean views for weddings, banquets, and upscale
                  corporate retreats (up to 250 guests).
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card">
              <img
                src="images/Beachfront.png"
                class="card-img-top"
                alt="Beachfront Garden"
              />
              <div class="card-body">
                <h5 class="card-title">Beachfront Garden</h5>
                <p class="card-text">
                  A picturesque outdoor setting ideal for romantic ceremonies,
                  al fresco dining, and relaxed social gatherings amidst lush
                  greenery and sea breezes.
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card">
              <img
                src="images/Wellness.png"
                class="card-img-top"
                alt="Wellness"
              />
              <div class="card-body">
                <h5 class="card-title">Wellness Studios</h5>
                <p class="card-text">
                  Flexible studios equipped for yoga retreats, mindfulness
                  workshops, and health seminars, complete with natural light
                  and serene ambiance
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
