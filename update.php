<?php
session_start();

$rid = $_GET['id'];
//echo $rid;

$conn = mysqli_connect('localhost', 'root', '', 'regis');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_old = "SELECT r.rid, rtitle, rservNum, username, rCookTimeh, rCookTimem, img_loc, rcategory, ingredients, steps, rintro FROM recipe r,images i WHERE r.rid=i.rid AND r.rid=$rid";
$result = mysqli_query($conn, $sql_old);
$row_old = mysqli_fetch_assoc($result);
$old_img =$row_old["img_loc"];


$title = $servings = $preptime = $category = $steps = '';




//

if (isset($_POST['update'])) {


    // escape sql chars
    $title = mysqli_real_escape_string($conn, $_POST['rtitle']);
    $title = mysqli_real_escape_string($conn, $_POST['rtitle']);
    $author = mysqli_real_escape_string($conn, $_POST['username']);
    $servings = mysqli_real_escape_string($conn, $_POST['rServNum']);
    $hpreptime = mysqli_real_escape_string($conn, $_POST['rCookTimeh']);
    $mpreptime = mysqli_real_escape_string($conn, $_POST['rCookTimem']);
    $category = mysqli_real_escape_string($conn, $_POST['rcategory']);
    $ingredients =  mysqli_real_escape_string($conn, $_POST['ingredients']);
    $steps = mysqli_real_escape_string($conn, $_POST['steps']);
    $intro =  mysqli_real_escape_string($conn, $_POST['rintro']);
    $fnm = $_FILES["image"]["name"];

    $username = $_SESSION['username'];


    // update sql
    $sql = "UPDATE recipe SET rtitle='$title', rServNum='$servings', rCookTimeh='$hpreptime', rCookTimem='$mpreptime', rcategory='$category', ingredients='$ingredients', steps='$steps', rintro='$intro'  WHERE rid=$rid";
    //echo $sql;

    //for testing
    // UPDATE recipe SET rtitle='kool', rServNum='5', rCookTimeh='6', rCookTimem='25', rcategory='Beverages', ingredients='sf', steps='lol', rintro='ok'  WHERE rid=65;
    //works


    // save to db and check 
    if (mysqli_query($conn, $sql)) {
        // success
        //header('location: recipe.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }


    //update image in db
    if ($fnm != ''){
    //to save image
    // keep as comment  -->$sql = "INSERT INTO images(rid, img_loc) VALUES('rid','$dst_db')";

        $var1 = rand(1111, 9999);  //generate random number in $var1 variable
        $var2 = rand(1111, 9999);  // generate random number in $var2 variable

        $var3 = $var1 . $var2;  // concatenate $var1 and $var2 in $var3
        $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

        $fnm = $_FILES["image"]["name"];    // get the image name in $fnm variable
        $dst = "./images/r_images/" . $var3 . $fnm;  // storing image path into the {r_images} folder with 32 characters hex number and file name
        $dst_db = "images/r_images/" . $var3 . $fnm; // storing image path into the database with 32 characters hex number and file name

        //delete old img
        if (file_exists($old_img)) {
            unlink($old_img);
          } else {
            echo 'Could not delete '.$old_img.', file does not exist';
        }


        move_uploaded_file($_FILES["image"]["tmp_name"], $dst);  // move image into the {r_images} folder with 32 characters hex number and image name

        $check = mysqli_query($conn, "UPDATE images SET img_loc='$dst_db' WHERE rid='$rid'");  // executing update query

        if ($check) {
            echo '<script type="text/javascript"> alert("Data Inserted Successfully!"); </script>';  // alert message
            header('location: recipe.php');
        } else {
            echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
        }
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
                    <form action="update.php?id=<?php echo $rid; ?>" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">

                            <div class="col-12">
                                <label for="firstName" class="form-label">Image (optional)</label>
                                <div class="input-group mb-3">
                                    <!-- <div class="input-group-prepend">
                                        <span class="input-group-text">Upload</span>
                                    </div> -->
                                   
                                    <div class="custom-file">
                                        <input type="file" name="image" accept="image/png, image/jpeg">
                                            <label class="custom-file-label" for="inputGroupFile01"></label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                
                                
                                <label for="firstName" class="form-label">Recipe Title</label>
                                <input type="text" class="form-control" name="rtitle" id="recipe_title" placeholder="" value="<?php echo $row_old["rtitle"]; ?>" required>

                            </div>
                            <div class="col-12">
                                <label for="firstName" class="form-label">Recipe Author</label>
                                <input type="text" class="form-control" name="username" id="recipe_author" placeholder="" value="<?php echo $_SESSION['username']; ?>" readonly>

                            </div>

                            <!-- to add "selected" in the option tag for Category list -->
                            <?php 
                            
                            $veg_sel = $nveg_sel = $bev_sel = "";
                            if ($row_old["rcategory"] = "Vegetarian") {
                                $veg_sel = "selected";
                            }
                            if ($row_old["rcategory"] = "Non-Vegetarian" ) {
                                $nveg_sel = "selected";
                            }
                            if ($row_old["rcategory"] = "Beverages") {
                                $bev_sel = "selected";
                            }
                            
                            ?>
                            
                            
                            <div class="col-md-4">
                                <label for="state" class="form-label">Category</label>
                                <select class="form-select" id="category" name="rcategory" required>
                                    <option value="">Choose...</option>
                                    <option <?php echo $veg_sel ?> >Vegetarian</option>
                                    <option <?php echo $nveg_sel ?> >Non-Vegetarian</option>
                                    <option <?php echo $bev_sel ?> >Beverages</option>
                                </select>

                            </div>
                            <?php  
                            // foreach($row_old as $key => $value) {
                            //     echo "<br>";
                            //     echo " $key: $value ";
                            //   }
                            ?>
                            
                            <div class="col-md-3">
                                <label for="zip" class="form-label">Servings</label>
                                <input type="number" class="form-control" name="rServNum" id="serving" min="1" max="999" placeholder="" value="<?php echo $row_old['rservNum']; ?>" required>

                            </div>
                        </div>
                        <br>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="zip" class="form-label">Preparation Time</label>
                                <input type="number" class="form-control" name="rCookTimeh" id="cooktime" min="0" max="23" placeholder="Hours" value="<?php echo $row_old['rCookTimeh']; ?>" required>

                            </div>
                            <div class="col-md-3">
                                <label for="zip" class="form-label text-white">.</label>
                                <input type="number" class="form-control" name="rCookTimem" id="prep_time_mins" min="0" max="59" placeholder="Minutes" value="<?php echo $row_old['rCookTimem']; ?>" required>
                            </div>

                        </div>
                        <br>
                        <div class="col-12">
                            <label for="zip" class="form-label">Introduction Text</label>
                            <textarea class="form-control " name="rintro" id="Introduction" placeholder="Introduction" rows="2" required><?php echo $row_old['rintro']; ?></textarea>

                        </div>
                        <br>
                        <div class="col-12">
                            <label for="zip" class="form-label">Ingredients</label>
                            <textarea class="form-control " name="ingredients" id="Ingredients" placeholder="Ingredients" rows="2" required><?php echo $row_old['ingredients']; ?></textarea>

                        </div>
                        <br>
                        <div class="col-12">
                            <label for="zip" class="form-label">Instructions</label>
                            <textarea class="form-control " name="steps" id="Instructions" placeholder="Instructions" rows="5" required><?php echo $row_old['steps']; ?></textarea>

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