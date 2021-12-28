<?php

// Starting the session, to use and
// store data in session variable
session_start();
$id = $_GET['id'];

$result;
$conn = mysqli_connect('localhost', 'root', '', 'regis');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .carousel-control-next,
        .carousel-control-prev

        /*, .carousel-indicators */
            {
            filter: invert(100%);
        }

        .carousel-inner>.item>img,
        .carousel-inner>.item>a>img {
            width: 100%;
            /* use this, or not */
            margin: auto;
        }

        .main-header {
            font-family: "Courier New";
        }


        .marketing .col-lg-4 {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .marketing h2 {
            font-weight: 400;
        }

        /* rtl:begin:ignore */
        .marketing .col-lg-4 p {
            margin-right: .75rem;
            margin-left: .75rem;
        }
    </style>
</head>

<body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img class="bi me-2" src="images/drawing.svg" width="50" height="50">
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
                    <li><a href="recipe.php" class="nav-link px-2 text-white">My Recipes</a></li>

                </ul>

            </div>
        </div>
    </header>

    <!-- section 2-Carousel-->
    <div class="container">





        <?php

        $sql = "SELECT rtitle,username,rCookTimeh,rCookTimem,rcategory,steps,rintro FROM recipe WHERE rid=$id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Tumbnailh</text></svg> -->
                        <img src="images/fruit-basket.svg" class="bd-placeholder-img card-img-top" alt="..." width="100%" height="225" focusable="false">
                        <div class="card-body">
                            <p class="fw-bold fs-5"><a href="#" class="nav-link nav-link px-2 text-black"><?php echo $row["rtitle"] ?></a></p>
                            <p class="card-text"></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <small class="text-muted"><?php echo $row["username"] ?></small>
                                </div>
                                <small class="text-muted"><?php echo $row["rCookTimeh"] . "h " . $row["rCookTimem"] . "m " ?></small>
                                <p><?php echo $row["rcategory"] ?></p>
                            </div>
                            <p><?php echo $row["rintro"] ?></p>
                            <p><?php echo $row["steps"] ?></p>

                        </div>
                    </div>
                </div>
                <!-- card end -->
        <?php
            }
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </div>
</body>

</html>