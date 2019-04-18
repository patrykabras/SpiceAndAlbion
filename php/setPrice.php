<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Spice And Albion</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<?php
require 'connection.php';
?>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="navbar-brand" href="#">
            <h2>SpiceAndAlbion</h2>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Set Price</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Items
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item " href="listOfItems.php">List Of Items</a>
                        <a class="dropdown-item" href="addItem.php">Add New Item</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="mx-auto" id="Box">
        <!-- INSERT INTO Prices (ID_Price, ID_Item, ID_Market, Date, ID_User, Price) VALUES (NULL, '52', '5', CURRENT_TIMESTAMP, '0', '26392'); -->
        <form action="" method="post">
            <div class="form-group mx-sm-3">
                <label for="exampleInputEmail1">Item</label>
                <?php
                $sql = "SELECT ID_Item, Name , Tier FROM Items";
                $result = $conn->query($sql);

                echo '<select name="ID_Item"  class="custom-select mr-3" id="inputGroupSelect01" required="required">';
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array(MYSQLI_NUM)) {
                        echo  '<option value="' . $row[0] . '">' . $row[1] . " T" . $row[2] . '</option>';
                    }
                } else {
                    echo "0 results";
                }
                echo '</select>';
                ?>
            </div>
            <div class="form-group mx-sm-3">
                <label for="exampleInputEmail1">Marketplace</label>
                <?php
                $sql = "SELECT ID_Matket,Name FROM Markets";
                $result = $conn->query($sql);

                echo '<select name="ID_Market" class="custom-select mr-3" id="inputGroupSelect01" required="required">';
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array(MYSQLI_NUM)) {
                        echo  '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                } else {
                    echo "0 results";
                }
                echo '</select>';
                ?>
            </div>
            <div class="form-group mx-sm-3">
                <label for="exampleInputPrice">Price: </label>
                <input type="number" name="Price" class="form-control" placeholder="Enter price..." required="required">
            </div>
            <div class="form-group mx-sm-3">
                <label for="exampleInputPrice">AuthCode: </label>
                <input type="text" name="AuthCode" class="form-control" placeholder="Enter AuthCode...">
                <small id="emailHelp" class="form-text text-muted">Size matter</small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
        </form>
        <?php

        if (isset($_POST["submit"])) {
            //INSERT INTO Prices (ID_Price, ID_Item, ID_Market, Date, ID_User, Price) VALUES (NULL, '52', '5', CURRENT_TIMESTAMP, '0', '26392');
            $ID_Item = $_POST["ID_Item"];
            $ID_Market = $_POST["ID_Market"];
            $Price = $_POST["Price"];
            $AuthCode = $_POST["AuthCode"];
            // $Date = date("Y-m-d H:i:s", time());
            $ID_User = NULL;
            $sql = "SELECT ID_User,AuthCode FROM Users";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array(MYSQLI_NUM)) {
                    for ($k = 0; $k < sizeof($row); $k++) {
                        if ($AuthCode == $row[1]) {
                            $ID_User = $row[0];
                        }
                    }
                }
            } else {
                echo "0 results";
            }

            $sqlInsert = "INSERT INTO Prices (ID_Price, ID_Item, ID_Market, Date, ID_User, Price) 
                        VALUES (NULL,'" . $ID_Item . "', '" . $ID_Market . "', CURRENT_TIMESTAMP, '" . $ID_User . "', '" . $Price . "')";
            if ($conn->query($sqlInsert) === TRUE) {
                echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
            } else {
                echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
            }
        }
        ?>
    </div>
    <footer class="bg-dark p-4 text-md-right text-light"><span>Created by Patryk Abraś & Kamil Szydłowski &copy; Copyright 2019</span></footer>
    <script src="../js/bootstrap.min.js"></script>
    <?php
    $conn->close();
    ?>
</body>

</html>