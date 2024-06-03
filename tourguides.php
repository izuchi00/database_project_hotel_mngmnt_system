<?php
    session_start();
    error_reporting(0);
    include('includes/dbconnection.php');

    // Fetching data for the first record
    $sql="SELECT * from tblTourGuides LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result1 = $query->fetch(PDO::FETCH_OBJ);

    // Fetching data for the second record
    $sql="SELECT * from tblTourGuides LIMIT 1 OFFSET 1";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result2 = $query->fetch(PDO::FETCH_OBJ);

    // Fetching data for the third record
    $sql="SELECT * from tblTourGuides LIMIT 1 OFFSET 2";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result3 = $query->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Hospitality Hub | Tour Guides :: Gallery</title>
    
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/lightbox.css">
    
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>

<body>
    <div class="header head-top">
        <div class="container">
            <?php include_once('includes/header.php');?>
        </div>
    </div>

    <div class="container text-center">
        <div class="content">
            <div class="gallery-top">
                <div class="container">
                    
                    <div class="gallery-info">
                        <h2>Tour Guides</h2>
                    </div>
                    
                    <div class="gallery-grids-top">
                        <div class="gallery-grids">
                            <div class="col-md-12 gallery-grid">
                                <br />

                                <div class="col-md-4">
                                    <a class="example-image-link" href="http://localhost/hbms/tourimages/guide1.jpeg" data-lightbox="example-set" data-title="">
                                        <img class="example-image" src="http://localhost/hbms/tourimages/guide1.jpeg" height="300" width="300" alt=""/>
                                    </a>

                                    <h4><?php echo $result1->Name; ?></h4>

                                    <p>Languages: <?php echo $result1->Languages; ?></p>
                                    <p>Specialization: <?php echo $result1->Specialization; ?></p>
                                    <p>Known For: <?php echo $result1->KnownFor; ?></p>
                                    <p>Contact: <?php echo $result1->Contact; ?></p>

                                </div>
                            </div>

                            <div class="col-md-12 gallery-grid">
                                <br />

                                <div class="col-md-4">
                                    <a class="example-image-link" href="http://localhost/hbms/tourimages/guide2.jpeg" data-lightbox="example-set" data-title="">
                                        <img class="example-image" src="http://localhost/hbms/tourimages/guide2.jpeg" height="300" width="300" alt=""/>
                                    </a>

                                    <h4><?php echo $result2->Name; ?></h4>

                                    <p>Languages: <?php echo $result2->Languages; ?></p>
                                    <p>Specialization: <?php echo $result2->Specialization; ?></p>
                                    <p>Known For: <?php echo $result2->KnownFor; ?></p>
                                    <p>Contact: <?php echo $result2->Contact; ?></p>

                                </div>
                            </div>

                            <div class="col-md-12 gallery-grid">
                                <br />

                                <div class="col-md-4">
                                    <a class="example-image-link" href="http://localhost/hbms/tourimages/guide3.jpeg" data-lightbox="example-set" data-title="">
                                        <img class="example-image" src="http://localhost/hbms/tourimages/guide3.jpeg" height="300" width="300" alt=""/>
                                    </a>

                                    <h4><?php echo $result3->Name; ?></h4>

                                    <p>Languages: <?php echo $result3->Languages; ?></p>
                                    <p>Specialization: <?php echo $result3->Specialization; ?></p>
                                    <p>Known For: <?php echo $result3->KnownFor; ?></p>
                                    <p>Contact: <?php echo $result3->Contact; ?></p>
                                </div>
                                
                            </div>

                        </div>
        
                        <div class="clearfix"> </div>

                    </div>
                    <script src="js/lightbox-plus-jquery.min.js"></script>

                </div>
            </div>
            <?php include_once('includes/getintouch.php');?>

        </div>
    </div>
    <?php include_once('includes/footer.php');?>

</body>
</html>

