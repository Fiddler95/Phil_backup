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
$search = "%".$search."%";

$query = "SELECT Level_1 as 'Nome' FROM argomento WHERE Level_1 LIKE '$search' GROUP BY Level_1 UNION SELECT Nome FROM universita WHERE Nome LIKE '$search' GROUP BY Nome UNION SELECT Nome FROM speaker WHERE Nome LIKE '$search' GROUP BY Nome UNION SELECT `Nome` FROM autori WHERE `Nome` LIKE '$search' GROUP BY `Nome` LIMIT 10";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0)
{
    $output .= '
  <div class="table-responsive">
  <ul class="list_of_suggestions">
   
 ';
    while($row = mysqli_fetch_array($result))
    {
        $res = $row["Nome"];
        $output .= '<li class="single_suggestion"><a class="link_of_suggestions" href="show_results.php?tag='.$res.'">'.$res.'</a></li>
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