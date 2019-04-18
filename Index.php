<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Spice And Albion</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<?php
require 'php/connection.php';
?>

<body>
	<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

	<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
		<div class="navbar-brand">
			<h2>SpiceAndAlbion</h2>
		</div>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse center" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link active" href="/">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="php/setPrice.php">Set Price</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Items
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="php/listOfItems.php">List Of Items</a>
						<a class="dropdown-item" href="php/addItem.php">Add New Item</a>
					</div>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<?php
				$sql = "SELECT Name FROM Markets";
				$result = $conn->query($sql);

				echo '<select id="ChooseMarketplace" onChange="searcher()" class="custom-select mr-3" id="inputGroupSelect01">
					  <option selected class="disable">All Marketplace...</option>';
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_array(MYSQLI_NUM)) {
						for ($k = 0; $k < sizeof($row); $k++) {
							echo  '<option value="' . $row[$k] . '">' . $row[$k] . '</option>';
						}
						$i++;
					}
				} else {
					echo "0 results";
				}
				echo '</select>';
				?>
				<input class="form-control mr-sm-2" type="text" onkeyup="searcher()" id="SearchBar" placeholder="Search by Item Name..." aria-label="Search">
			</form>
		</div>
	</nav>


	<table class="table" id="myTable">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<?php
				$sql = "SELECT DISTINCT i.Name AS 'Item name',i.Tier AS 'Tier', Prices.Price, m.Name AS 'Marketplace', (3+COALESCE(u.TrustLevel,0))-TIMESTAMPDIFF(HOUR,Prices.Date,CURRENT_TIMESTAMP) AS 'Trust Level', COALESCE(u.Name,'-') AS 'Added By' FROM Prices INNER JOIN (SELECT ID_Item, MAX(Date) as TopDate FROM Prices, Markets GROUP BY ID_Item, ID_Market) AS EachItem ON EachItem.TopDate = Prices.Date AND EachItem.ID_Item = Prices.ID_Item INNER JOIN Markets as m ON m.ID_Matket = Prices.ID_Market INNER JOIN Items AS i ON i.ID_Item = Prices.ID_Item LEFT JOIN Users AS u on u.ID_User = Prices.ID_User ORDER BY EachItem.ID_Item";
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
			?>
		</tbody>
	</table>
	<footer class="bg-dark p-4 text-md-right text-light"><span>Created by Patryk Abraś & Kamil Szydłowski &copy; Copyright 2019</span></footer>
	<script>
		function searcher() {
			var input, input1, filter, filter1, table, tr, td, td1, i, txtValue, txtValue1;
			input = document.getElementById("SearchBar");
			filter = input.value.toUpperCase();
			input1 = document.getElementById("ChooseMarketplace");
			filter1 = input1.value.toUpperCase();
			table = document.getElementById("myTable");
			tr = table.getElementsByTagName("tr");

			// Loop through all table rows, and hide those who don't match the search query
			for (i = 1; i < tr.length; i++) {
				var vanish = 2;
				td = tr[i].getElementsByTagName("td")[0];
				td1 = tr[i].getElementsByTagName("td")[3];
				if (td) {
					txtValue = td.textContent || td.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						vanish -= 1;
					}
				}
				if (td1) {
					txtValue1 = td1.textContent || td1.innerText;
					if (txtValue1.toUpperCase().indexOf(filter1) > -1 || filter1 == "ALL MARKETPLACE...") {
						vanish -= 1;
					}
				}
				if (vanish == 0) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
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
	<script src="js/bootstrap.min.js"></script>
	<?php
	$conn->close();
	?>
</body>

</html>