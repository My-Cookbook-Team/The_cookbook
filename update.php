<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'regis');

$title = $servings = $preptime = $category = $steps = '';
$rid = $_GET['id'];



if (isset($_POST['update'])) {


    // escape sql chars
    $title = mysqli_real_escape_string($conn, $_POST['rtitle']);
    $author = mysqli_real_escape_string($conn, $_POST['username']);
    $servings = mysqli_real_escape_string($conn, $_POST['rServNum']);
    $hpreptime = mysqli_real_escape_string($conn, $_POST['rCookTimeh']);
    $mpreptime = mysqli_real_escape_string($conn, $_POST['rCookTimem']);
    $category = mysqli_real_escape_string($conn, $_POST['rcategory']);
    $ingredients =  mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);
    $intro =  mysqli_real_escape_string($conn, $_POST['rintro']);


    $username = $_SESSION['username'];


    // create sql
    $sql = "UPDATE recipe
    SET rtitle='$title', rServNum='$servings', rCookTimeh='$hpreptime', rCookTimem='$mpreptime, rcategory='$category', ingredients='$ingredient', steps='$steps', rintro='$intro') 
    WHERE rid='$rid'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    //update image in db

    //to save image
    //$sql = "INSERT INTO images(rid, img_loc) VALUES('rid','$dst_db')";
    $var1 = rand(1111, 9999);  //generate random number in $var1 variable
    $var2 = rand(1111, 9999);  // generate random number in $var2 variable

    $var3 = $var1 . $var2;  // concatenate $var1 and $var2 in $var3
    $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

    $fnm = $_FILES["image"]["name"];    // get the image name in $fnm variable
    $dst = "./images/r_images/" . $var3 . $fnm;  // storing image path into the {r_images} folder with 32 characters hex number and file name
    $dst_db = "images/r_images/" . $var3 . $fnm; // storing image path into the database with 32 characters hex number and file name

    move_uploaded_file($_FILES["image"]["tmp_name"], $dst);  // move image into the {r_images} folder with 32 characters hex number and image name

    $check = mysqli_query($conn, "UPDATE images SET img_loc='$dst_db' WHERE rid='$rid'");  // executing update query

    if ($check) {
        echo '<script type="text/javascript"> alert("Data Inserted Seccessfully!"); </script>';  // alert message
        header('location: recipe.php');
    } else {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
} // end POST check

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }


        .value-button {
            display: inline-block;
            border: 1px solid #ddd;
            margin: 0px;
            width: 40px;
            height: 20px;
            text-align: center;
            vertical-align: middle;
            padding: 11px 0;
            background: #eee;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .value-button:hover {
            cursor: pointer;
        }

        form #decrease {
            margin-right: -4px;
            border-radius: 8px 0 0 8px;
        }

        form #increase {
            margin-left: -4px;
            border-radius: 0 8px 8px 0;
        }

        .value-button:hover {
            cursor: pointer;
        }

        form #decrease {
            margin-right: -4px;
            border-radius: 8px 0 0 8px;
        }

        form #increase {
            margin-left: -4px;
            border-radius: 0 8px 8px 0;
        }

        .main-header {
            font-family: "Courier New";
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
</head>
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

<body class="bg-light">

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="images/drawing.svg" alt="" width="72" height="57">
                <h2 class="main-header">The CookBook</h2>
                <p class="lead"></p>
            </div>

            <div class="row g-5">

                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3 ">Recipe Details</h4>
                    <form action="add.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">

                            <div class="col-12">
                                <label for="firstName" class="form-label">Image</label>
                                <div class="input-group mb-3">
                                    <!-- <div class="input-group-prepend">
                                        <span class="input-group-text">Upload</span>
                                    </div> -->
                                   
                                    <div class="custom-file">
                                        <input type="file" name="image" required>
                                            <label class="custom-file-label" for="inputGroupFile01"></label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <label for="firstName" class="form-label">Recipe Title</label>
                                <input type="text" class="form-control" name="rtitle" id="recipe_title" placeholder="" value="" required>

                            </div>
                            <div class="col-12">
                                <label for="firstName" class="form-label">Recipe Author</label>
                                <input type="text" class="form-control" name="username" id="recipe_author" placeholder="" value="<?php echo $_SESSION['username']; ?>" readonly>
                                username
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">Category</label>
                                <select class="form-select" id="category" name="rcategory" required>
                                    <option value="">Choose...</option>
                                    <option>Vegetarian</option>
                                    <option>Non-Vegetarian</option>
                                    <option>Beverages</option>
                                </select>

                            </div>

                            <div class="col-md-3">
                                <label for="zip" class="form-label">Servings</label>
                                <input type="number" class="form-control" name="rServNum" id="serving" min="1" max="999" placeholder="" required>

                            </div>
                        </div>
                        <br>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="zip" class="form-label">Preparation Time</label>
                                <input type="number" class="form-control" name="rCookTimeh" id="cooktime" min="0" max="23" placeholder="Hours" required>

                            </div>
                            <div class="col-md-3">
                                <label for="zip" class="form-label text-white">.</label>
                                <input type="number" class="form-control" name="rCookTimem" id="prep_time_mins" min="0" max="59" placeholder="Minutes" required>
                            </div>

                        </div>
                        <br>
                        <div class="col-12">
                            <label for="zip" class="form-label">Introduction Text</label>
                            <textarea class="form-control " name="rintro" id="Introduction" placeholder="Introduction" rows="2" required></textarea>

                        </div>
                        <br>
                        <div class="col-12">
                            <label for="zip" class="form-label">Ingredients</label>
                            <textarea class="form-control " name="ingredients" id="Ingredients" placeholder="Ingredients" rows="2" required></textarea>

                        </div>
                        <br>
                        <div class="col-12">
                            <label for="zip" class="form-label">Instructions</label>
                            <textarea class="form-control " name="steps" id="Instructions" placeholder="Instructions" rows="5" required></textarea>

                        </div>
                        <br>



                        <button class="w-50 btn btn-outline-primary btn-lg" name="update" type="submit">Submit</button>
                    </form>
                </div>

            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; Powered by a <a href="images/hamster.gif" target="_blank" rel="noopener noreferrer"> small hamster</a></p>
        </footer>
    </div>


    <script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="form-validation.js"></script>
</body>

</html>