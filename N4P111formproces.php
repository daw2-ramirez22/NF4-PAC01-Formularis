<?php
// connect to mysqli
$db = mysqli_connect('localhost', 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');

//make sure you're using the correct database
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));


$fecha_actual = date("Y-m-d");
$reviwer =$_POST['reviwer'];
$comment =$_POST['comment'];
$rating =$_POST['rating'];



$review_movie_id = $_GET['movie_id'];

$query = <<<ENDSQL
INSERT INTO reviews
    (review_movie_id, review_date, reviewer_name, review_comment,
    review_rating)
VALUES
    ("$review_movie_id","$fecha_actual","$reviwer","$comment","$rating")
ENDSQL;
mysqli_query($db,$query) or die(mysqli_error($db));


echo 'Data inserted successfully!';

?>  