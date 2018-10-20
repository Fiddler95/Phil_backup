<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 16/08/2018
 * Time: 17:31
 *
 * Funzione per cercare in maniera asincrona gli url nel database corrispondenti a tag inseriti dall'utente
 * utilizzata nella pagina principale all'interno della barra di ricerca
 */


include "connect.php";
$output = '';

$search = mysqli_real_escape_string($conn, $_POST["query"]);
$query = "SELECT Tag FROM tags WHERE Tag LIKE '%".$search."%' GROUP BY Tag";

$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
    $output .= '
  <div class="table-responsive">
  <ul class="list_of_suggestions">
   
 ';
    while($row = mysqli_fetch_array($result))
    {
        $output .= '<li class="single_suggestion"><a class="link_of_suggestions" href="show_results.php?tag='.$row["Tag"].'">'.$row["Tag"].'</a></li>
  ';
    }
    $output .= '</ul></div>';
    echo $output;
}
else
{
    $output .= '
        <div class="table-responsive">
            <ul class="list_of_suggestions">
                <li class="single_suggestion">Match not found</li>
            </ul>
        </div>';
    echo $output;
}

?>