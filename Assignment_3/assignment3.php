<?php

require_once('config.php'); 

/*
 Displays list of images
*/
function outputImages() {
  try {
    if (isset($_GET['country']) || isset($_GET['continent']) || isset($_GET['title'])) {

      $continent = $_GET['continent'] ;
      $country = $_GET['country'] ;
      $title = $_GET['title'] ;

      if(isset($continent) && !(is_numeric($continent))) {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql	=	"SELECT * FROM imagedetails WHERE	ContinentCode='$continent' ORDER BY ImageID ASC";
        $result	=	$pdo->query($sql);
        while	($row	=	$result->fetch())	{
          outputSingleImage($row);									   
        }
        $pdo = null;
      }

      else if(isset($country) && !(is_numeric($country))) {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql	=	"SELECT * FROM imagedetails WHERE	CountryCodeISO='$country' ORDER BY ImageID ASC";
        $result	=	$pdo->query($sql);
        while	($row	=	$result->fetch())	{
          outputSingleImage($row);									   
        }
        $pdo = null;
      }

      else if(isset($title) && ($title != "")) {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql	=	"SELECT * FROM imagedetails WHERE	Title LIKE '%$title%' ORDER BY ImageID ASC";
        $result	=	$pdo->query($sql);
        while	($row	=	$result->fetch())	{
          outputSingleImage($row);									   
        }
        $pdo = null;
      }

      else {                  
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql	=	"SELECT Title, Path, ImageID FROM imagedetails ORDER BY ImageID ASC";
        $result	=	$pdo->query($sql);
        while	($row	=	$result->fetch())	{
          outputSingleImage($row);									   
        }
        $pdo = null;
      }	
    } else { 
      $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql	=	"SELECT Title, Path, ImageID FROM imagedetails ORDER BY ImageID ASC";
      $result	=	$pdo->query($sql);
      while	($row	=	$result->fetch())	{
        outputSingleImage($row);									   
      }
      $pdo = null;
    }	
  }
  catch (PDOException $e) {
    die( $e->getMessage() );
  }
}

/*
 Displays a single image with link
*/
function outputSingleImage($row) {
  echo '<li>';
  echo '<a href="detail.php?id=' . $row['ImageID'] . '" class="img-responsive">';
  echo '<img src="images/square-medium/' . $row['Path'] .'" alt="' . $row['Title'] . '">';
  echo '<div class="caption">';
  echo '<div class="blur"></div>';
  echo '<div class="caption-text">';
  echo '<p>' . $row['Title'] . '</p>';
  echo '</div>';
  echo '</div>';
  echo '</a>';
  echo '</li>';
}

/*
 Displays list of continents
*/
function continentList() {
  try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
    $sql	=	"SELECT ContinentCode, ContinentName FROM continents ORDER BY ContinentCode ASC";
    $result	=	$pdo->query($sql);
    while	($row	=	$result->fetch())	{
      echo '<option	value="' . $row['ContinentCode'] . '">' . $row['ContinentName'] . '</option>';								   
    }
    $pdo = null;
  }
  catch (PDOException $e) {
    die( $e->getMessage() );
  }
}

/*
 Displays list of countries
*/
function countryList() {
  try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
    $sql	=	"SELECT imagedetails.CountryCodeISO, CountryName, ISO FROM imagedetails INNER JOIN countries ON imagedetails.CountryCodeISO = countries.ISO GROUP BY CountryName";
    $result	=	$pdo->query($sql);
    while	($row	=	$result->fetch())	{
      echo '<option	value="' . $row['ISO'] . '">' . $row['CountryName'] . '</option>';								   
    }
    $pdo = null;
  }
  catch (PDOException $e) {
    die( $e->getMessage() );
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Assignment 3</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="assignment3.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php continentList(); ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php countryList(); ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
          
		  <ul class="caption-style-2">
        <?php outputImages(); ?> 
      </ul>  

    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>