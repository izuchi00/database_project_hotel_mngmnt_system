<?php
    include('includes/dbconnection.php');
    session_start();
    error_reporting(E_ALL);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Hospitality Hub | Hotel :: Past Tours</title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <style>
        h2 {
            padding-bottom: 20px;
        }

        .tour-details {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            width: 100%; /* Full width by default */
            display: flex; /* Flexbox layout */
            flex-wrap: wrap; /* Allow items to wrap */
        }

        .tour-details h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 100%; /* Full width */
            text-align: center; /* Center text */
        }

        .tour-details p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
            width: 100%; /* Full width */
        }

        .tour-details strong {
            font-weight: bold;
        }

        .tour-details a {
            text-decoration: none;
            color: inherit;
        }

        @media (min-width: 768px) {
            /* Adjust for larger screens */
            .tour-details {
                width: calc(50% - 40px); /* Two items per row with some spacing */
                margin-right: 20px;
                margin-bottom: 20px;
            }
        }

        @media (min-width: 992px) {
            /* Adjust for even larger screens */
            .tour-details {
                width: calc(33.333% - 40px); /* Three items per row with some spacing */
                margin-right: 20px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="header head-top">
        <div class="container">
            <?php include_once('includes/header.php');?>
        </div>
    </div>

    <div class="content">
        <div class="contact">
            <div class="container">
                <h2>Past Tours</h2>
                <div class="contact-grids">
                    <div class="col-md-12">
                        <?php
                        // Check if user is logged in
                        if (isset($_SESSION['hbmsuid'])) {
                            try {
                                // Fetch past tours from the database
                                $sql = "SELECT * FROM tbltourbooking WHERE Status = 'Confirmed' AND TourEndDate < CURDATE()";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                        ?>
                                            <div class="tour-details">
                                                <h3 class="text-xl fw-bold">Tour <?php echo $cnt; ?></h3>
                                                <p><strong>Tour Name:</strong> <?php echo $row->TourName; ?></p>
                                                <p><strong>Tour Location:</strong> <?php echo $row->TourLocation; ?></p>
                                                <p><strong>Number of Tourists:</strong> <?php echo $row->NumberOfTourists; ?></p>
                                                <p><strong>Meals Per Day:</strong> <?php echo $row->MealsPerDay; ?></p>
                                                <p><strong>Car Type:</strong> <?php echo $row->CarType; ?></p>
                                                <p><strong>Tour Start Date:</strong> <?php echo $row->TourStartDate; ?></p>
                                                <p><strong>Tour End Date:</strong> <?php echo $row->TourEndDate; ?></p>
                                                <p><strong>Tour Guide Location:</strong> <?php echo $row->TourGuideLocation; ?></p>
                                                <p><strong>Remark:</strong> <?php echo $row->Remark; ?></p>
                                                <p><strong>Status:</strong> <?php echo $row->Status; ?></p>
                                                <p><strong>Total Price:</strong> <?php echo $row->TotalPrice; ?></p>
                                            </div>
                                        <?php
                                        $cnt++;
                                    }
                                } 

                                else {
                                    echo "<p>No past tours available.</p>";
                                }
                            } 
                            catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        } 
                        
                        else {
                            // If user is not logged in, display login prompt
                            echo "<p>Please <a href='login.php'>login</a> to view past tours.</p>";
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php include_once('includes/getintouch.php');?>
    </div>
<?php include_once('includes/footer.php');?>
</body>

</html>