<?php
// function to generate ratings
/* 
$cont=0;
$total=0;
*/


function generate_ratings($rating) {
    $movie_rating = '';
    for ($i = 0; $i < $rating; $i++) {
        $movie_rating .= '<img  src="star.png" width="15px" height="15px" alt="star"/>';  
    }

    return $movie_rating;

}



// cabecera de detalles director
function get_director($director_id) {

    global $db;

    $query = 'SELECT 
            people_fullname 
       FROM
           people
       WHERE
           people_id = ' . $director_id;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $people_fullname;
}

// cabecera de detalles acor
function get_leadactor($leadactor_id) {

    global $db;

    $query = 'SELECT
            people_fullname
        FROM
            people 
        WHERE
            people_id = ' . $leadactor_id;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $people_fullname;
}

// take in the id of a movie type and return the meaningful textual
// cabecera de detalles 
function get_movietype($type_id) {

    global $db;

    $query = 'SELECT 
            movietype_label
       FROM
           movietype
       WHERE
           movietype_id = ' . $type_id;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $movietype_label;
}

// cabecera àrte de healt
function calculate_differences($takings, $cost) {

    $difference = $takings - $cost;

    if ($difference < 0) {     
        $color = 'red';
        $difference = '$' . abs($difference) . ' million';
    } elseif ($difference > 0) {
        $color ='green';
        $difference = '$' . $difference . ' million';
    } else {
        $color = 'blue';
        $difference = 'broke even';
    }

    return '<span style="color:' . $color . ';">' . $difference . '</span>';
}

//connect to MySQL
$db = mysqli_connect('localhost', 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db,'moviesite') or die(mysqli_error($db));


// retrieve information de cabecera
$query = 'SELECT
        movie_name, movie_year, movie_director, movie_leadactor,
        movie_type, movie_running_time, movie_cost, movie_takings
    FROM
        movie
    WHERE
        movie_id = ' . $_GET['movie_id'];
$result = mysqli_query($db,$query) or die(mysqli_error($db));

$row = mysqli_fetch_assoc($result);
$movie_name         = $row['movie_name'];
$movie_director     = get_director($row['movie_director']);
$movie_leadactor    = get_leadactor($row['movie_leadactor']);
$movie_year         = $row['movie_year'];
$movie_running_time = $row['movie_running_time'] .' mins';
$movie_takings      = $row['movie_takings'] . ' million';
$movie_cost         = $row['movie_cost'] . ' million';
$movie_health       = calculate_differences($row['movie_takings'],
                          $row['movie_cost']);


// display the information de 
echo <<<ENDHTML
<html>
 <head>
  <title>Details and Reviews for: $movie_name</title>
  <style>
    
    table{
        width: 100%;
        display: flex;
        justify-content: center
    }
  </style>
 </head>
 <body>
  <div style="text-align: center;">
   <h2>$movie_name</h2>
   <h3><em>Details</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
     <td><strong>Title</strong></strong></td>
     <td>$movie_name</td>
     <td><strong>Release Year</strong></strong></td>
     <td>$movie_year</td>
    </tr><tr>
     <td><strong>Movie Director</strong></td>
     <td>$movie_director</td>
     <td><strong>Cost</strong></td>
     <td>$$movie_cost<td/>
    </tr><tr>
     <td><strong>Lead Actor</strong></td>
     <td>$movie_leadactor</td>
     <td><strong>Takings</strong></td>
     <td>$$movie_takings<td/>
    </tr><tr>
     <td><strong>Running Time</strong></td>
     <td>$movie_running_time</td>
     <td><strong>Health</strong></td>
     <td>$movie_health<td/>
    </tr>
   </table>
ENDHTML;

// retrieve reviews for this movie
$query = 'SELECT
        review_movie_id, review_date, reviewer_name, review_comment,
        review_rating
    FROM
        reviews
    WHERE
        review_movie_id = ' . $_GET['movie_id'] . '
    ORDER BY
        review_date DESC';

$result = mysqli_query($db,$query) or die(mysqli_error($db));

// display the reviews
echo <<< ENDHTML
   <h3><em>Reviews</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 90%; margin-left: auto; margin-right: auto;">
    
    <tr>
     <th style="width: 7em;">Date</th>
     <th style="width: 10em;">Reviewer</th>
     <th>Comments</th>
     <th style="width: 5em;">Rating</th>

    </tr>
ENDHTML;
$cont=0;
$suma=0;
$total=0;

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['review_date'];
    $name = $row['reviewer_name'];
    $comment = $row['review_comment'];
    $rating = generate_ratings($row['review_rating']);

    $suma += $row['review_rating'];
    $cont++;

    echo <<<ENDHTML
    <tr>
      <td style="vertical-align:top; text-align: center;">$date</td>
      <td style="vertical-align:top;">$name</td>
      <td style="vertical-align:top;">$comment</td>
      <td style="vertical-align:top;">$rating</td>     
    </tr>
</div>

ENDHTML;
}


$total = $suma/$cont;

//for para imprimir tantas estrellas como tenga en el total de la media 
for ($i = 1; $i <= $total; $i++) {
    echo '<img  src="star.png" width="15px" height="15px" alt="star"/>';  
}



$a = $_GET['movie_id'];


echo <<<ENDHTML
    <form action="http://localhost:8080/practica5/ejercicios/N4P110form.php?movie_id=$a" method="post">
    <table> 

        <tr>
            <td class="boton">
                <input type="submit" name="submit" value="ADD" />
            </td>
        </tr>


    </table>
    </form>

ENDHTML;
echo <<<ENDHTML
    

 </body>
</html>
ENDHTML;


?>