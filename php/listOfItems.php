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
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
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
                    <a class="nav-link" href="setPrice.php">Set Price</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Items
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item active" href="#">List Of Items</a>
                        <a class="dropdown-item" href="addItem.php">Add New Item</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" onkeyup="myFunction()" id="SearchBar" placeholder="Search by Item Name..." aria-label="Search">
            </form>
        </div>
    </nav>


    <table class="table" id="myTable">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <?php
                $sql = "SELECT Items.Name,Items.Tier,Items.Enchant,Items.Quality,ItemTypes.Name FROM Items,ItemTypes WHERE Items.ID_Type = ItemTypes.ID_Type";
                $result = $conn->query($sql);
                $finfo = mysqli_fetch_fields($result);
                foreach ($finfo as $val) {
                    echo '<th scope="col">' . $val->name . '</th>';
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                $i = 0;
                while ($row = $result->fetch_array(MYSQLI_NUM)) {
                    // echo "<br> id: " . $row[0] . " - Name: " . $row[1] . " " . $row[2] . "Size: " . $result->num_rows;
                    echo '<tr><th scope="row">' . $i . '</th>';
                    for ($k = 0; $k < sizeof($row); $k++) {
                        echo '<td>' . $row[$k] . '</td>';
                    }
                    echo '</tr>';
                    $i++;
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    <footer class="bg-dark p-4 text-md-right text-light"><span>Created by Patryk Abraś & Kamil Szydłowski &copy; Copyright 2019</span></footer>
    <script>
        function myFunction() {
            // Declare variables 
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("SearchBar");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>