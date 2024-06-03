<?php 
    session_start();
    Include "includes/dbconnection.php";

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Include database connection code here if not already included
        // $dbh should be your database connection object
        if (strlen($_SESSION['hbmsuid']==0)) {
            header('location:logout.php');
        }
        // Fetch user ID from session
        $userID = $_SESSION['hbmsuid'];

        // Fetch data from the form
        $tourName = $_POST['tour_name'];
        $tourLocation = $_POST['tour_location'];
        $numberOfTourists = $_POST['num_tourists'];
        $mealsPerDay = $_POST['meals_per_day'];
        $carType = $_POST['car_type'];
        $tourStartDate = $_POST['tour_start_date'];
        $tourEndDate = $_POST['tour_end_date'];
        $tourGuideLocation = $_POST['tour_guide_location'];
        $remark = $_POST['remark'];
        $status = 'Confirmed';
        // $min = 1000; $max = 100000;
        $totalPrice = mt_rand(ceil(10000/10) , floor(100000/10))*10;


        // Prepare SQL statement to insert data into tbltourbooking
        $sql = "INSERT INTO tbltourbooking (UserID, TourName, TourLocation, NumberOfTourists, MealsPerDay, CarType, TourStartDate, TourEndDate, TourGuideLocation, Remark, Status, TotalPrice) 
                VALUES (:userID, :tourName, :tourLocation, :numberOfTourists, :mealsPerDay, :carType, :tourStartDate, :tourEndDate, :tourGuideLocation, :remark, :status, :totalPrice)";
        $query = $dbh->prepare($sql);

        // Bind parameters
        $query->bindParam(':userID', $userID, PDO::PARAM_INT);
        $query->bindParam(':tourName', $tourName, PDO::PARAM_STR);
        $query->bindParam(':tourLocation', $tourLocation, PDO::PARAM_STR);
        $query->bindParam(':numberOfTourists', $numberOfTourists, PDO::PARAM_INT);
        $query->bindParam(':mealsPerDay', $mealsPerDay, PDO::PARAM_INT);
        $query->bindParam(':carType', $carType, PDO::PARAM_STR);
        $query->bindParam(':tourStartDate', $tourStartDate, PDO::PARAM_STR);
        $query->bindParam(':tourEndDate', $tourEndDate, PDO::PARAM_STR);
        $query->bindParam(':tourGuideLocation', $tourGuideLocation, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':totalPrice', $totalPrice, PDO::PARAM_INT);

        // Execute the query
        $query->execute();

        // Check if the query was successful
        if ($query) {
            // Redirect to a success page or do something else
            echo "Tour booking added successfully!";
        } 
        else {
            // Handle the error appropriately
            echo "Error adding tour booking!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hospitality Hub | Hotel :: Tour Booking</title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <style>
        /* Custom CSS */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        h5{
            margin-bottom: 5px;
            margin-left: 15px;
            margin-top: 3px;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .container {
            margin-bottom: 50px;
        }
        h2 {
            margin-top: 50px;
            text-align: center;
            margin-bottom: 40px;
            color: #002bff;
            font-size: 5rem;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 50px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 20px;
            margin-bottom: 20px;
            border: none;
            border-radius: 50px;
            background-color: #f8f9fa;
            box-sizing: border-box;
            border: 2px solid #ced4da;
            transition: border-color 0.3s ease;
        }
        form{
            background-color: white;
        }
        textarea{
            border-radius: 50px;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position-x: calc(100% - 12px);
            background-position-y: 50%;
            border-radius: 50px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1.5rem;
            font-weight:bold;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body style="background-color: #f0eadf">
    <div class="header head-top">
        <div class="container">
            <?php include_once('includes/header.php');?>
        </div>
    </div>

    <div class="container gallery-info">
        <h2>Tour Booking</h2>
        <form method="post">
            <?php 

                // Assuming you already have $dbh connected to your database
                $uid = $_SESSION['hbmsuid'];
                $sql = "SELECT * FROM tbluser WHERE ID = :uid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {    ?>
                        <h5>Name</h5>
                        <input type="text" class="rounded-xl font-bold" value="<?php echo $row->FullName; ?>" name="name" class="form-control" required="true" readonly="true">
                        <h5>Mobile Number</h5>
                        <input type="text" name="phone" class="form-control" required="true" maxlength="10" pattern="[0-9]+" value="<?php echo $row->MobileNumber; ?>" readonly="true">
                        <h5>Email Address</h5>
                        <input type="email" value="<?php echo $row->Email; ?>" class="form-control" name="email" required="true" readonly="true">
                        <?php
                        $cnt = $cnt + 1;
                    }
                }   
            ?>

            <h5>Tour Name</h5>
            <input type="text" name="tour_name" class="form-control" required="true">

            <h5>Tour Location</h5>
            <input type="text" name="tour_location" class="form-control" required="true"></input>

            <h5>Number of Tourists</h5>
            <input type="number" name="num_tourists" class="form-control" required="true">

            <h5>Meals Per Day</h5>
            <input type="number" name="meals_per_day" class="form-control" required="true">

            <h5>Car Type</h5>
            <select name="car_type" class="form-control" required="true">
                <option value="">Choose Car Type</option>
                <option value="mini">Mini</option>
                <option value="AC mini">AC Mini</option>
                <option value="sedan">Sedan</option>
                <option value="AC sedan">AC Sedan</option>
                <option value="suv">SUV</option>
            </select>

            <h5>Tour Start Date</h5>
            <input type="date" name="tour_start_date" class="form-control" required="true">

            <h5>Tour End Date</h5>
            <input type="date" name="tour_end_date" class="form-control" required="true">

            <h5>Tour Guide Location</h5>
            <input type="text" name="tour_guide_location" class="form-control" required="true">

            <h5>Remark</h5>
            <textarea type="text" name="remark" class="form-control"></textarea>
            <br>
            
            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
        </form>
    </div>

    <div>
        <?php include_once('includes/getintouch.php');?>
    </div>

    <?php include_once('includes/footer.php');?>
</body>

</html>