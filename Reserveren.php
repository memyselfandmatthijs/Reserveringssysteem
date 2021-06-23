<?php
require_once('customFunctions.php');
require_once('connect.php');
require_once ('sendMail.php');

check_logged_in();
$adminCheck = check_admin_right($conn);
$getDateSql = "SELECT DISTINCT `datum` FROM `beschikbaarheid`";
$result = mysqli_query($conn, $getDateSql);

$dateList = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dateList [] = $row;
}

if (isset($_GET['datePicked'])) {
    $pickedDate = $_GET['datePicked'];
    $_SESSION['datePicked'] = $pickedDate;
    $getPeopleSql = "SELECT `relatie_nummer` FROM `beschikbaarheid` WHERE `datum` = '$pickedDate'";
    $result = mysqli_query($conn, $getPeopleSql);

    $availablePersons = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $availablePersons [] = $row;
    }

    for ($i = 0; $i < count($availablePersons); $i++) {
        foreach ($availablePersons[$i] as $person) {
            $getNameSql = "SELECT `voornaam`, `achternaam` FROM `bezorgers` WHERE `relatie_nummer`= $person";
            $result = mysqli_query($conn, $getNameSql);

            $name [] = mysqli_fetch_assoc($result);
        }
    }

}

if (isset($_POST['chosenPerson'])){
    $chosenName = $_POST['chosenPerson'];
    $wijk = $_POST['wijk'];
    $details = $_POST['details'];
    $pickedDate = $_SESSION['datePicked'];
    $saveAppointmentSql = "INSERT INTO `reserveringen`(`relatie_nummer`, `datum`, `wijk`, `bijzonderheden`) VALUES ('$chosenName', '$pickedDate', '$wijk', '$details')";
    $deleteAvailabilitySql = "DELETE FROM `beschikbaarheid` WHERE `datum` = '$pickedDate' AND `relatie_nummer` = '$chosenName'";

    if (mysqli_query($conn, $saveAppointmentSql)){
        echo "succes <br> ";  // . $saveAppointmentSql. "<br> url:" . $_SERVER['HTTP_REFERER'];
        mysqli_query($conn, $deleteAvailabilitySql);
        mailBezorger($chosenName, $pickedDate, $conn, $wijk);
    }
}


?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    <title>Bezorger reserveren</title>
</head>

<body>
<div class="header">
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
            <a href="Reserveren.php">Bezorger reserveren</a>
            <?php if($adminCheck == "true"){ ?>
                <a href="inschrijving.php">Bezorger toevoegen</a>
            <?php } ?>
        </div>

    </div>

</div>
<hr>
<h1>Reserveer een bezorger</h1>

<a href="homepage.php">terug</a>
<br>
<br>

<div class="pickdatediv">
    <form action="Reserveren.php" method="get">
        <label for="datePicked">Kies een datum: </label>
           <select name="datePicked">
               <?php foreach($dateList as  $date) { ?>
                    <option value="<?= $date['datum'] ?>"><?= $date['datum'] ?></option>
               <?php } ?>
           </select>
        <br>
        <br>
        <button type="submit" name="submit">Bezorger zoeken</button>

    </form>
</div>

<?php if(isset($_GET['datePicked'])){ ?>
<div class="claimdate">

        <h3>Beschikbare bezorgers op <?= $_GET['datePicked'] ?>:</h3>

    <form action="Reserveren.php" method="post">
        <?php foreach($availablePersons as $index => $person) { ?>
            <input type="radio" name="chosenPerson" value="<?= $person['relatie_nummer'] ?>">
            <label for="chosenPerson"><?= $name[$index]['voornaam'] . " " . $name[$index]['achternaam'] ?></label>
            <br>

        <?php } ?>
            <br>
            <label for="wijk">wijk:</label>
            <input type="text" name="wijk" required>
            <br>
            <label for="details">Bijzonderheden:</label>
            <input type="text" name="details">
            <br>
        <button type="submit" name="submit">Reserveren</button>
    </form>
    <?php } ?>
</div>
</body>