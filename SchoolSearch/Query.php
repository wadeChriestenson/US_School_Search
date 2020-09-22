<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'Connections.php' ?>
  <link href="query.css" type="text/css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Title</title>
</head>
<?php
if(!isset($_REQUEST['County'])){
  $_REQUEST['County'] = null;
}


$selectedState  = ($_GET['selectedState']);
$state = "SELECT name FROM state_county_names WHERE state='$selectedState' ";
$countySearch = mysqli_query($conn, $state);
if($_SERVER["REQUEST_METHOD"]=="GET") {
  $selectedCounty = $_REQUEST['County'];
}


?>
<body>
<header class="head">


<form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
  <input type="hidden" name="selectedState" value="<?php echo $selectedState ?>">
  <label for="countyName">COUNTY :
    <select name="County">
      <?php
      while($row = mysqli_fetch_array($countySearch))
      {
        $countyName = $row['name'];
        echo "<option value='$countyName'>$countyName</option>";
      if(!isset($selectedCounty)){
      $selectedCounty = $countyName;
      }
      }

      ?>
    </select>
  </label>
  <input type="submit" value="Select">
<?php
$sql = "SELECT fips FROM state_county_names WHERE state='$selectedState' AND name='$selectedCounty'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 0){
  while($row = mysqli_fetch_assoc($result)){
    $fips = $row['fips'];
  }
}
?>
</form>

  <a href="Index.html">Return to Map</a>

</header>

<div class="county">
<div class="county1">
<?php
$search = "SELECT * FROM state_county_names WHERE fips='$fips'";
$sql = mysqli_query($conn, $search);


if ($sql->num_rows > 0) {
echo "<table><tr><th>County and State</th><th>FIPS #</th></tr>";
  // output data of each row
  while($row = $sql->fetch_assoc()) {
  echo "<tr><td>".$row["name"]."</td><td>".$row["fips"]."</td></tr>";
  }

echo "</table>";
} else {
echo "0 results";
} ?>
</div>
</div>

<div class="school">
  <h2>Public Schools</h2>
    
  <?php
$search = "SELECT * FROM public_schools WHERE COUNTYFIPS='$fips' ORDER BY CITY";
$sql = mysqli_query($conn, $search);


if ($sql->num_rows > 0) {
  echo "<table><tr><th>Public School</th><th>City</th><th>Full Time Teachers</th><th>Number of Students</th><th>Grade Levels</th><th>Website</th></tr>";
  // output data of each row
  while($row = $sql->fetch_assoc()) {
    echo "<tr><td>".$row["NAME"]."</td><td>".$row["CITY"]."</td><td>".$row["FT_TEACHER"]."</td><td>".$row["ENROLLMENT"]."</td><td>".$row["LEVEL_"]."</td><td><a href=' ".$row['WEBSITE']." '>".$row["WEBSITE"]."</a></td></tr>";
  }
echo "</table>";
} else {
  echo "0 results";
} ?>
</div>
<div style="height: 15px;"></div>
<div class="college">
  <h2>Universities and Colleges</h2>
  <?php
$search = "SELECT * FROM colleges_and_universities WHERE COUNTYFIPS='$fips' ORDER BY CITY";
$sql = mysqli_query($conn, $search);


if ($sql->num_rows > 0) {
  echo "<table><tr><th>Universities and College</th><th>City</th><th>Full Time Teachers</th><th>Number of Students</th><th>Types of College</th><th>Website</th></tr>";
  // output data of each row
  while($row = $sql->fetch_assoc()) {
    echo "<tr><td>".$row["NAME"]."</td><td>".$row["CITY"]."</td><td>".$row["TOT_EMP"]."</td><td>".$row["TOT_ENROLL"]."</td><td>".$row["NAICS_DESC"]."</td><td><a href=' ".$row['WEBSITE']." '>".$row["WEBSITE"]."</a></td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}
$search = "SELECT * FROM full_naics WHERE fips='$fips'";
$sql = mysqli_query($conn, $search);
?>
</div>
<div style="height: 15px;"></div>
<div class="full">

  <div class="full1">
    <h2>Number of Businesses</h2>
    <?php
if ($sql->num_rows > 0) {
  echo "<table><tr><th>Year</th><th>Number of Business</th><th>Number of Employed</th></tr>";
  // output data of each row
  while($row = $sql->fetch_assoc()) {
    echo "<tr><td>".$row["year"]."</td><td>".$row["naics_all_num_establishments"]."</td><td>".$row["naics_all_employment"]."</td></tr>";
  }

  echo "</table>";
} else {
  echo "0 results";
}
?>
  </div>
  <div class="full2">
    <h2>Population per County</h2>
    <?php
$search = "SELECT * FROM full_s0_ WHERE fips='$fips'";
$sql = mysqli_query($conn, $search);


if ($sql->num_rows > 0) {
  echo "<table><th>Total Population</th><th>Caucasian</th><th>African-Americans</th><th>Native-Americans</th><th>Asian</th><th>Pacific Islander</th>
    <th>Mixed Race</th><th>Other</th></tr>";
  // output data of each row
  while($row = $sql->fetch_assoc()) {
    echo "<tr><td>".$row["B17001_001E"]."</td><td>".$row["B17001A_001E"]."</td><td>".$row["B17001B_001E"]."</td><td>".$row["B17001C_001E"]."</td>
            <td>".$row["B17001D_001E"]."</td><td>".$row["B17001E_001E"]."</td><td>".$row["B17001G_001E"]."</td><td>".$row["B17001F_001E"]."</td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}
?>
  </div>
</div>
<div style="height: 15px;"></div>
<div class="income">
  <h2>Income and Poverty</h2>
  <?php
  $search = "SELECT * FROM full_s0_ WHERE fips='$fips'";
  $sql = mysqli_query($conn, $search);


  if ($sql->num_rows > 0) {
    echo "<table><th>Year</th><th>Per Capita Income</th><th>Median Income</th><th>Poverty Level Under 18</th><th>Poverty Level over 65</th></tr>";
    // output data of each row
    while($row = $sql->fetch_assoc()) {
      echo "<tr><td>".$row["year"]."</td><td>$".$row["B19301_001E"]."</td><td>$".$row["B20002_001E"]."</td><td>".$row["DP03_0129PE"]."%</td><td>".$row["DP03_0135PE"]."%</td></tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
  ?>
</div>

<div style="height: 15px;"></div>
  <div class="income">
    <h2>Top 5 per Capita Income Counties in <?php echo $selectedState ?></h2>
    <?php
    $search = "SELECT * FROM full_s0_ WHERE state='$selectedState' AND year='2018' ORDER BY B19301_001E DESC LIMIT 5";
    $sql = mysqli_query($conn, $search);


    if ($sql->num_rows > 0) {
      echo "<table><th>County</th><th>Per Capita Income</th><th>Median Income</th><th>Poverty Level Under 18</th><th>Poverty Level over 65</th></tr>";
      // output data of each row
      while($row = $sql->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>$".$row["B19301_001E"]."</td><td>$".$row["B20002_001E"]."</td><td>".$row["DP03_0129PE"]."%</td><td>".$row["DP03_0135PE"]."%</td></tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }
    ?>
</div>
</body>
</html>

