<?php
require_once ('connect.php');
require_once ('customFunctions.php');


$adminCheck = check_admin_right($conn);
if ($adminCheck == "false"){
    header('location: homepage.php');
}

$wachtwoordovereenkomst = "";
$relatieNummer = "";
$voornaam = "";
$achternaam = "";
$telefoonnummer = "";
$wachtwoord = "";
$wachtwoordControle = "";

if(!empty($_POST['relNumber']) ) {
    $relatieNummer = mysqli_escape_string($conn, $_POST["relNumber"]);
    $voornaam = mysqli_escape_string($conn, $_POST["firstName"]);
    $achternaam = mysqli_escape_string($conn, $_POST["lastName"]);
    $mailAdress = mysqli_escape_string($conn, $_POST["emailAdress"]);
    $wachtwoord = mysqli_escape_string($conn, $_POST["password"]);
    $wachtwoordControle = mysqli_escape_string($conn, $_POST["confirmPassword"]);

}

if ($wachtwoord == $wachtwoordControle) {
    $wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
    $sql = "INSERT INTO bezorgers (relatie_nummer, voornaam, achternaam, mailAdress, wachtwoord) VALUES ('$relatieNummer', '$voornaam', '$achternaam', '$mailAdress', '$wachtwoord')";

    if ($relatieNummer != "0" && mysqli_query($conn, $sql)) {


        mysqli_query($conn, $sql);
        echo "New record created successfully";
    } elseif ($relatieNummer == "0") {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if ($wachtwoordControle != $wachtwoord && isset($_POST['submit'])) {
        $wachtwoordovereenkomst = "wachtwoorden komen niet overeen";
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    <title>Bezorger inschrijven</title>
</head>

<body>
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
<hr>

<h1>Bezorger inschrijven</h1>

<a href="homepage.php">terug</a>
<br>
<br>

<form action="inschrijving.php" method="post">
    <label for="relNumber">Relatienummer:</label>
    <input type="number" id="relNumber" name="relNumber" required>
    <br>
    <label for="firstName">Voornaam:</label>
    <input type="text" id="firstName" name="firstName" required>
    <br>
    <label for="lastName">Achternaam:</label>
    <input type="text" id="lastName" name="lastName" required>
    <br>
    <label for="emailAdress">Emailadres:</label>
    <input type="text" id="emailAdress" name="emailAdress" required>
    <p> <?= $wachtwoordovereenkomst ?></p>

    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="confirmPassword">Wachtwoord bevestigen:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required>
    <br>
    <button type="submit" name="submit">Opslaan</button>


</form>

</body>

