<?php
require_once ("customFunctions.php");
require_once  ("connect.php");

check_logged_in();
$user = $_SESSION['username'];
$adminCheck = check_admin_right($conn);


$getUserDatasql = " SELECT * FROM bezorgers WHERE relatie_nummer = $user";
$userData = mysqli_fetch_assoc(mysqli_query($conn, $getUserDatasql));



if (isset($_POST["submit"])){
    //echo"gegevens verwerken";
    $relatienummer = mysqli_escape_string($conn, $_POST["relatieNummer"]);
    $userData['relatie_nummer'] = $relatienummer;
    $voornaam = mysqli_escape_string($conn, $_POST["Voornaam"]);
    $userData['voornaam'] = $voornaam;
    $achternaam = mysqli_escape_string($conn, $_POST["Achternaam"]);
    $userData['achternaam'] = $achternaam;
    $mailAdress = mysqli_escape_string($conn, $_POST["mailAdress"]);
    $userData['mailAdress'] = $mailAdress;
    $passwrd = $userData["wachtwoord"];
    $admin = $userData["admin"];

    $updateUserdatasql ="UPDATE `bezorgers` SET `relatie_nummer`= '$relatienummer',`voornaam`= '$voornaam',`achternaam`= '$achternaam',`mailAdress`= '$mailAdress',`wachtwoord`='$passwrd',`admin`= '$admin'  WHERE `relatie_nummer`= '$user'";



    if(mysqli_query($conn, $updateUserdatasql)){
        echo "<br>" . "Gegevens opgeslagen";
    }
    else{
        echo "Error: " . "<br>" . mysqli_error($conn);
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>gegevens aanpassen</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body >

<div    class="header">
    <h1 class="headertext">Krantenbezorger reserveren</h1>

    <div class="logout">
        <form class="logout"  name="logout" method="post" action="logout.php">
            <button class="logout" type="submit" name="logout">Uitloggen</button>
        </form>
    </div>


    <div class="dropdownMenu">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <a href="homepage.php">Homepage</a>
            <a href="beschikbaarheid.php">Beschikbaarheid aangeven</a>
            <a href="edit.php">Gegevens bewerken</a>
            <a href="Reserveren.php">Bezorger reserveren</a>
            <?php if($adminCheck == "true"){ ?>
                <a href="inschrijving.php">Bezorger toevoegen</a>
            <?php } ?>
        </div>

    </div>

</div>

<section>
    <h1>Gegevens bewerken</h1>

    <form action="" method="post">
        <div class="data-field">
            <label for="relatieNummer">relatienummer</label>
            <input id="relatieNummer" type="text" name="relatieNummer" value="<?= $userData["relatie_nummer"] ?>"/>
        </div>
        <div class="data-field">
            <label for="Voornaam">Voornaam</label>
            <input id="Voornaam" type="text" name="Voornaam" value="<?= $userData["voornaam"] ?>"/>
        </div>
        <div class="data-field">
            <label for="Achternaam">Achternaam</label>
            <input id="Achternaam" type="text" name="Achternaam" value="<?= $userData["achternaam"] ?>"/>
        </div>
        <div class="data-field">
            <label for="mailAdress">emailadress:</label>
            <input id="mailAdress" type="text" name="mailAdress" value="<?= $userData["mailAdress"] ?>"/>
        </div>
        <div class="data-submit">
            <input type="submit" name="submit" value="Opslaan"/>
        </div>
    </form>
</section>

</body>
</html>