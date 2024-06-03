<?php
    include('includes/dbconnection.php');
    session_start();
    error_reporting(E_ALL);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Hospitality Hub | Hotel :: Ongoing Tours</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
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

        /* Styles for pop-up form */
        .formDiv {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .formDiv h3{
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 3rem;
        }
        .outerFormDiv {
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Align items to the end (right) */
            align-items: end;
            transform: translate(-50%, -50%);
            position: fixed;
            top: 50%;
            left: 50%;
            height: 55vh;
            background-color: #fff;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .closeButton {
            border-radius: 25px;
            background-color: #eb5757;
            padding: 8px;
        }

        .join-form label {
            display: block;
            margin-bottom: 10px;
            margin-bottom: 5px;
            margin-left:15px;
        }

        .join-form input[type="number"],
        .join-form input[type="date"] {
            width: 100%;
            padding: 4px 20px;
            margin-bottom: 10px;
            border-radius: 35px;
            border: 1px solid #ccc;
        }
        .join-form p{
            margin-top: 10px;
            margin-bottom: 15px;
            font-weight: bold;
            margin-left: 15px;
            font-size: 1.5rem;
        }
        .join-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .outerFormDiv img {
            width: 20px;
            height: 20px;
        }
        .hidden{
            display: none;
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
                <h2>Ongoing Tours</h2>
                <div class="contact-grids">
                    <div class="col-md-12">
                        <?php
                        // Check if user is logged in
                        if (isset($_SESSION['hbmsuid'])) {
                            try {
                                // Fetch ongoing tours from the database
                                $sql = "SELECT * FROM tbltourbooking WHERE Status = 'Confirmed' AND TourStartDate <= CURDATE() AND TourEndDate >= CURDATE()";
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
                                            <button onclick="openJoinForm(<?php echo $row->BookingID; ?>, <?php echo $row->TotalPrice; ?>, <?php echo $row->NumberOfTourists; ?>)" class="btn btn-primary">Join Tour</button>
                                        </div>
                                        <?php
                                        $cnt++;
                                    }
                                } else {
                                    echo "<p>No ongoing tours available.</p>";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        } else {
                            // If user is not logged in, display login prompt
                            echo "<p>Please <a href='login.php'>login</a> to join a tour.</p>";
                        }
                        ?>
                    </div>
                    <div id="formDiv" class="outerFormDiv hidden">
                        <button id="closeButton" class="closeButton"><img src="https://www.svgrepo.com/show/438388/close.svg" alt="close icon"></button>
                        <div class="formDiv">
                            <h3>Join Tour</h3>
                            <form class="join-form" id="joinForm" method="post">
                                <input type="hidden" id="bookingID" name="bookingID" value="">
                                <label for="tourists">Number of Tourists:</label>
                                <input type="number" id="tourists" name="tourists" required><br>
                                <label for="joiningDate">Joining Date:</label>
                                <input type="date" id="joiningDate" name="joiningDate" required><br>
                                <p>Total Price per person: 
                                    <p id="priceperperson">

                                    </p>
                                </p>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/getintouch.php');?>
    </div>
    <?php include_once('includes/footer.php');?>

    <!-- JavaScript to handle pop-up form -->
    <script>
        document.getElementById('closeButton').addEventListener('click', close);

        function close(){
            var formHTML = document.getElementById('formDiv');
            formHTML.classList.add('hidden');
        }
        function openJoinForm(bookingID, totalPrice, NumberOfTourists) {
            // Open pop-up form
            var formHTML = document.getElementById('formDiv');
            // Set form values
            document.getElementById('bookingID').value = bookingID;
            document.getElementById('priceperperson').textContent = totalPrice/(NumberOfTourists+1);
            formHTML.classList.toggle('hidden');
        }
    </script>

</body>
</html>