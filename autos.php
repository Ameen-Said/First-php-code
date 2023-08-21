
<?php require_once("pdo.php");

if (isset($_GET['name'])) {
    $username = $_GET['name'];
} else{
    die("Name parameter missing");
}
$make_check = false;
$year_milage_check = false;
$data_insert = false;

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
    if($_POST['make'] !== ""){
        if(is_numeric($_POST['year']) && is_numeric($_POST['mileage'])){
            $make = $_POST['make'];
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];

        }else{ $year_milage_check = true;}

    }
    else { $make_check = true; }
}

if(isset($make) && isset($year) && isset($mileage)){
    $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year , :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':make',$make);
    $stmt->bindParam(':year',$year);
    $stmt->bindParam(':mileage',$mileage);
    $result = $stmt->execute();
    if($result){
    $data_insert =true;
 
    }
       
}

$sql2 = "SELECT * FROM autos";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO :: FETCH_ASSOC)
?>


<!DOCTYPE html>
<html>
<head>
<title>Ameen Mohammad Said's Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $username; ?></h1>
<form method="post">
    <?php if($make_check == true){echo "<span style='color: red;'>" . htmlspecialchars("Make is required") . "</span>";} elseif($year_milage_check == true){echo "<span style='color: red;'>" . htmlspecialchars("Mileage and year must be numeric") . "</span>";} elseif($data_insert == true){echo "<span style='color: green;'>" . htmlspecialchars("Record inserted") . "</span>";} ?>
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
<?php if(isset($_POST['logout'])){ header("Location: login.php");}?>
</form>

<h2>Automobiles</h2>
<ul>
<p><?php 
 foreach($result2 as $row) {

echo $row['year'] . $row['make'] . "/" . $row['mileage'] . "<br>";
    }
 ?>
</ul>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
