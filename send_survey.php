<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 21/04/2018
 * Time: 15:24
 */

include 'connect.php';
session_start();

$user = $_SESSION['name'];
if(isset($_POST['LivelloStudi']))
{
    //salvo il livello di studi inserito dall'utente
    $lvlStud = $_POST['LivelloStudi'];
    $sql = " UPDATE users SET `Knowledge_lvl`= '$lvlStud' WHERE Username = '$user'";
    $result = mysqli_query($conn, $sql) or die("failed to set user level of knowledge");
    // elimino il livello dall'array $_POST cos' che possa ciclarlo in automatico
    unset($_POST['LivelloStudi']);
}
//sentinella che mi dice il numero di campi in $_POST
$sentinel = count($_POST);

//variabile di confronto con $sentinella per vedere se ho effettuato
//il numero giusto di query al database
$guard = 0;

/**
 * NB --> LA VARIABILE QUI SOTTO SERVE PER CAMBIARE TABELLA DOVE SALVARE I VALORI
 */
$cambia_campo=0;
foreach($_POST as $key => $val)
//ciclo su ogni entry del questionario
{
    if($cambia_campo==0) {
        $phil_Id = $key;
        /**
         * NB --> CONTROLLO SULL'ULTIMO ID DELLA CATEGORIA FILOSOFIA PRIMA DI CAMBIARE A GENERALE
         */
        if($phil_Id==5932){$cambia_campo=1;}
        $lvl = $val;
        //prendo da db il valore dato nel precedente questionario se esiste
        $sql = "SELECT Level FROM survey_phil WHERE Username = '$user' AND Phil_id = '$phil_Id'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            /**se ho trovato un riscontro, vado a sovrascrivere i dati;
             * qui si potrebbe inserire un ulteriore controllo tra $lvl e result['level'] per
             * evitare una query nel caso i campi non vengano modificati
             * NB-->bisognerà anche modificare il controllo per il messaggio
             */
            $sql = " UPDATE survey_phil SET `Level`= '$lvl' WHERE Username = '$user' AND Phil_id = '$phil_Id'";
            if (mysqli_query($conn, $sql))
                $guard++;
        } else {
            //è la prima volta che compilo il questionario
            $sql = " INSERT INTO survey_phil(Username, Phil_id, Level) VALUES ('$user','$phil_Id','$lvl')";
            if (mysqli_query($conn, $sql))
                $guard++;
        }
    }
    else
    {
        $general_Id = $key;
        $lvl = $val;
        //prendo da db il valore dato nel precedente questionario se esiste
        $sql = "SELECT Level FROM survey_general WHERE Username = '$user' AND General_id = '$general_Id'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        if($count == 1)
        {
            /**se ho trovato un riscontro, vado a sovrascrivere i dati;
             * qui si potrebbe inserire un ulteriore controllo tra $lvl e result['level'] per
             * evitare una queries nel caso i campi non vengano modificati
             * NB-->bisognerà anche modificare il controllo per il messaggio
             */
            $sql = " UPDATE survey_general SET `Level`= '$lvl' WHERE Username = '$user' AND General_id = '$general_Id'";
            if(mysqli_query($conn, $sql))
                $guard++;
        }
        else
        {
            //è la prima volta che compilo il questionario
            $sql = " INSERT INTO survey_general(Username, General_id, Level) VALUES ('$user','$general_Id','$lvl')";
            if(mysqli_query($conn, $sql))
                $guard++;
        }


    }

}
if ($sentinel == $guard)
{
    $message = "Questionario compilato con successo";
    echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.replace(\"home_Private.php\");</script>";
}
else
{
    echo $message = "Potrebbe essersi verificato un errore, ricontrolla il questionario ".mysqli_error($conn);
}
?>