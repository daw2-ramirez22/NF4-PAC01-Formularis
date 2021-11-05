<?php

$a = $_GET['movie_id'];


echo <<<ENDHTML
    <html>
    <head>
    <title>Dime tu comentario</title>
    </head>
    <body>
        <h1>Deja tu comentario</h1>
    <form action="http://localhost:8080/practica5/ejercicios/N4P111formproces.php?movie_id=$a" method="post">
    <table>

    <tr>

        <tr>
        <td>Reviwer</td>
        <td><input type="text" name="reviwer" /></td>
        </tr>

        <tr>
        <td>Comments</td>
        <td>
            <textarea name="comment" rows="5" cols="60"></textarea>
        </td>

        </tr>

        <tr>
        <td>Rating</td>
        <td><input type="number" name="rating" /></td>
        </tr>
    
    
        <tr>
        <td colspan="2" style="text-align: center">
        <input type="submit" name="submit" value="ADD" />
        </td>
        </tr>
    </table>
    </form>
    </body>
    </html>
ENDHTML;
?>