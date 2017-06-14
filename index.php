<head>
<link href='styles.css' rel="stylesheet"/>
</head>
<?php 
include('config.php');

$imgfolder = 'img';
$images = scandir($imgfolder);
unset($images[0]);unset($images[1]);

$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}


if(isset($_GET['hashtag'])){
//SEARCH FOR TAG
echo "<div style='width: 50%;float:left;'><h2>Search for #".$_GET['hashtag']."</h2>";
$abfrage = "SELECT image FROM images WHERE hashtag='".$_GET['hashtag']."' GROUP BY image";
$ergebnis = mysqli_query($db, $abfrage);
if (mysqli_num_rows($ergebnis)==0) die("no results.");
while($row = mysqli_fetch_object($ergebnis))
{                  
    echo "<div class='image' style='width:20%;border: 1px dashed black'>";
    echo "<img style='width: 100%;' src='".$imgfolder."/".$row->image."' onclick='window.open(this.src)'/>";
        $abfrage2 = "SELECT hashtag FROM images WHERE image='$row->image'";
        $ergebnis2 = mysqli_query($db, $abfrage2);
        while($row2 = mysqli_fetch_object($ergebnis2)){
            $hashtag = $row2->hashtag;
            echo "<span class='hashtag'>#".$hashtag."</span>&nbsp;";
        }

    echo "</div>";
}
echo "</div>";die();
}





echo "<div style='width:50%;float:left;'><h2>Not tagged...</h2>";
$abfrage = "SELECT image FROM images GROUP BY image";
$ergebnis = mysqli_query($db, $abfrage);
while($row = mysqli_fetch_object($ergebnis))
{
    $row->image;
    if(($key = array_search($row->image, $images)) !== false) {
        unset($images[$key]);
    }
}
/*
    
*/
foreach($images as $image){
    echo "<img class='image' style='width: 20%;' src='".$imgfolder."/".$image."' onclick=''/>";
}
echo "</div>";

echo "<div style='width: 50%;float:left;'><h2>Tagged</h2>";
$abfrage = "SELECT image FROM images GROUP BY image";
$ergebnis = mysqli_query($db, $abfrage);
while($row = mysqli_fetch_object($ergebnis))
{
    echo "<div style='width:20%;border: 1px dashed black'>";
    echo "<img class='image' style='width: 100%;' src='".$imgfolder."/".$row->image."' onclick='window.open(this.src)'/>";
        $abfrage2 = "SELECT hashtag FROM images WHERE image='$row->image'";
        $ergebnis2 = mysqli_query($db, $abfrage2);
        while($row2 = mysqli_fetch_object($ergebnis2)){
            $hashtag = $row2->hashtag;
            echo "<span class='hashtag'><a href='?hashtag=$hashtag'>#".$hashtag."</a></span>&nbsp;";    
        }

    echo "</div>";
}
echo "</div>";




?>