<?php
    session_start();
    if (!isset($_SESSION['userId'])) {
        header("Location: signin.html");
        exit();
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .product-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <!-- Start: Navbar Centered Links -->
    <nav class="navbar navbar-light navbar-expand-md py-3" style="font-size: 18px;font-family: Poppins, sans-serif;">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="Home.php"><span><img height="75px" src="assets/img/Logo%20(1).png"></span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3">
                 <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="men.html" style="margin-right: 5px;font-size: 16px;">Men</a></li>
                    <li class="nav-item" style="font-size: 16px;"><a class="nav-link" href="women.html" style="margin-right: 5px;font-size: 16px;">Women</a></li>
                    <li class="nav-item" style="font-size: 16px;"><a class="nav-link" href="kids.html" style="margin-right: 5px;font-size: 16px;">Kids</a></li>
                    <li class="nav-item" style="font-size: 16px;"><a class="nav-link" href="traditional.html" style="font-size: 16px;">Traditional</a></li>
                    <li class="nav-item" style="font-size: 16px;"><a class="nav-link" href="all.html" style="margin-right: 5px;font-size: 16px;">Explore</a></li>
                 </ul>
                
                    <a class="nav-link" href="browse_products.php" style="font-size: 16px;"><i class="fas fa-heart" style="font-size: 25px;color: #2d3693;padding: 5px;margin-right: 5px;margin-left: 5px;"></i></a>
                    <a class="nav-link" href="view_userorders.php" style="font-size: 16px;"><i class="fas fa-shopping-cart" style="font-size: 25px;color: #2d3693;padding: 5px;margin-right: 5px;margin-left: 5px;"></i></a>
                    <a class="nav-link" href="signout.php" style="font-size: 16px;"><i class="fas fa-user-circle" style="font-size: 25px;color: #2d3693;padding: 5px;margin-right: 5px;margin-left: 5px;"></i></a>
            </div>
        </div>
    </nav><!-- End: Navbar Centered Links -->

    <div class="container">
        <h1 class="text-center my-4">Browse Products</h1>
        <div class="row">
            <?php
            include 'db_connect.php';

            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 product-card">';
                    echo '<div class="card">';
                    echo '<img src="' . htmlspecialchars($row['product_image']) . '" class="card-img-top product-image" alt="' . htmlspecialchars($row['product_name']) . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['product_name']) . '</h5>';
                    echo '<p class="card-text">Price: PHP ' . number_format($row['product_price'], 2) . '</p>';
                    echo '<p class="card-text">Total Sales: ' . number_format($row['product_sale']) . '</p>';
                    echo '<p class="card-text">Available Stocks: ' . number_format($row['product_stock']) . '</p>';
                    echo '<form action="order_product.php" method="POST" class="mt-auto">';
                    echo '<input type="hidden" name="product_id" value="' . $row['productId'] . '">';
                    echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row['product_name']) . '">';
                    echo '<div class="form-group">';
                    echo '<label for="buyerName">Name:</label>';
                    echo '<input type="text" class="form-control" name="buyerName" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="deliveryAddress">Delivery Address:</label>';
                    echo '<input type="text" class="form-control" name="deliveryAddress" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="quantity">Quantity:</label>';
                    echo '<input type="number" class="form-control" name="quantity" min="1" max="' . $row['product_stock'] . '" required>';
                    echo '</div>';
                    echo '<div class="text-center">';
                    echo '<button type="submit" class="btn btn-primary">Order</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No products available.</p>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
