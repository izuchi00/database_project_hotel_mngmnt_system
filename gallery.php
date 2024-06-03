<?php
session_start();
error_reporting(E_ALL);

include('includes/dbconnection.php');

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Check if the user is logged in
    if(isset($_SESSION['user_id'])) {
        // Retrieve form data
        $facilityID = $_POST['facility_id'];
        $review = $_POST['review'];
        $rating = $_POST['rating']; // New: Rating

        // Insert the review into the database
        $sql = "INSERT INTO tblreviews (FacilityID, Review, Rating) VALUES (:facility_id, :review, :rating)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':facility_id', $facilityID, PDO::PARAM_INT);
        $query->bindParam(':review', $review, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT); // New: Bind rating parameter
        $query->execute();
        $msg = "Review submitted successfully!";
    } else {
        // User is not logged in, display a pop-up asking them to login or sign up
        echo "<script>alert('Please login or sign up to submit a review.')</script>";
    }
}

// Pagination variables
$limit = 3; // Number of reviews per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Offset for the SQL query

// Fetch reviews from the database
$sql = "SELECT * FROM tblreviews ORDER BY ReviewDate DESC LIMIT $offset, $limit";
$query = $dbh->prepare($sql);
$query->execute();
$reviews = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Hospitality Hub| Hotel :: Reviews</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<style>
    .content {
            padding: 50px 0;
        }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 36px;
        color: #333;
    }
    
    /* Custom styling for the dropdown */
    .custom-dropdown {
        background-color: #f9f9f9;
        width: 400px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #333;
    }

    /* Hover effect */
    .custom-dropdown option:hover {
        background-color: #e0e0e0;
        cursor: pointer;
    }

/*
    .form-control {
        padding: 100;
    }
*/
    .form-group {
        text-align: left; /* Align the form group content to the left */
    }

    .star-rating {
        margin-top: 10px;
        direction: ltr;
        unicode-bidi: bidi-override;
        text-align: left; 
    }

    .star-rating input[type="radio"] {
        display: none;
        text-align: left;
    }

    .star-rating label {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
        float: right;
        text-align: left;
    }

    .star-rating input[type="radio"]:checked ~ label {
        color: #ffc107;
    }

    /* Custom style for the login modal */
    .modal-content {
        border-radius: 10px;
    }

    .modal-body {
        font-size: 16px;
        text-align: center;
    }

    .modal-footer {
        justify-content: center;
    }

        /* Custom styling for the reviews list */
    .reviews-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Adjust spacing between reviews */
    }

    .review-item {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: calc(50% - 10px); /* Two reviews side by side with some spacing */
    }

    .review-item p {
        margin: 0;
        font-size: 16px;
        color: #333;
    }

    .review-item p:first-child {
        font-weight: bold;
    }

    /* Pagination links */
    .pagination {
        margin-top: 20px;
        list-style: none;
    }

    .pagination li {
        display: inline-block;
        margin-right: 10px;
    }

    .pagination a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    .pagination a:hover {
        text-decoration: underline;
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
        <div class="container">
            <h2>Reviews</h2>
            <?php if(isset($msg)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $msg; ?>
            </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="facility_id">Select Facility:</label>
                    <select class="form-control custom-dropdown" id="facility_id" name="facility_id">
                        <?php
                            // Fetch facilities from the database
                            $sql = "SELECT * FROM tblfacility";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $facilities = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach($facilities as $facility) {
                                echo "<option value='".$facility['ID']."'>".$facility['FacilityTitle']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <div class="star-rating">
                        <input type="radio" id="rating5" name="rating" value="5"><label for="rating5">&#9733;</label>
                        <input type="radio" id="rating4" name="rating" value="4"><label for="rating4">&#9733;</label>
                        <input type="radio" id="rating3" name="rating" value="3"><label for="rating3">&#9733;</label>
                        <input type="radio" id="rating2" name="rating" value="2"><label for="rating2">&#9733;</label>
                        <input type="radio" id="rating1" name="rating" value="1"><label for="rating1">&#9733;</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="review">Your Review:</label>
                    <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit Review</button>
            </form>
            <div class="reviews-list">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <p><?php echo $review['ReviewText']; ?></p>
                        <p>Rating: <?php echo $review['Rating']; ?></p>
                        <p>Date: <?php echo $review['ReviewDate']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination links -->
            <?php
                // Count total number of reviews
                $sql = "SELECT COUNT(*) AS total FROM tblreviews";
                $query = $dbh->prepare($sql);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $total_pages = ceil($row['total'] / $limit);

                // Pagination links
                echo "<ul class='pagination'>";
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li><a href='?page=$i'>$i</a></li>";
                }
                echo "</ul>";
            ?>
        </div>
    </div>
    <?php include_once('includes/footer.php');?>
</body>
</html>
