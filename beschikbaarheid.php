<?php
require_once ('connect.php');
require_once ('customFunctions.php');

check_logged_in();
$adminCheck = check_admin_right($conn);
$referenceTimestamp = 1609714819;
$secondsPerWeek = 604800;
$secondsPerDay = 86400;
$nextWeekNumber = date('W') + 1;
$standardWeekNumber = date('W', $referenceTimestamp);
$differenceInWeeks = $nextWeekNumber - $standardWeekNumber;

$username = $_SESSION['username'];
$register = false;

$mondayTimeStamp = date('U', ($referenceTimestamp + ($differenceInWeeks * $secondsPerWeek)));
$secondMondayTimeStamp = $mondayTimeStamp + $secondsPerWeek;
$thirdMondayTimeStamp = $mondayTimeStamp + 2 * $secondsPerWeek;
$fourthMondayTimeStamp = $mondayTimeStamp + 3 * $secondsPerWeek;
$fifthMondayTimeStamp = $mondayTimeStamp + 4 * $secondsPerWeek;
$sixthMondayTimeStamp = $mondayTimeStamp + 5 * $secondsPerWeek;
$seventhMondayTimeStamp = $mondayTimeStamp + 6 * $secondsPerWeek;
$eighthMondayTimeStamp = $mondayTimeStamp + 7 * $secondsPerWeek;

if (!isset($_POST['week'])){
    $_SESSION['week'] = $mondayTimeStamp;
}

if (isset($_POST['week'])){
    $_SESSION['week'] = $_POST['week'];
}

$chosenTimeStamp = $_SESSION['week'];

$date1 = date('Y-n-j', $chosenTimeStamp);
$date2 = date('Y-n-j', $chosenTimeStamp + (1 * $secondsPerDay));
$date3 = date('Y-n-j', $chosenTimeStamp + (2 * $secondsPerDay));
$date4 = date('Y-n-j', $chosenTimeStamp + (3 * $secondsPerDay));
$date5 = date('Y-n-j', $chosenTimeStamp + (4 * $secondsPerDay));
$date6 = date('Y-n-j', $chosenTimeStamp + (5 * $secondsPerDay));

if (isset($_POST['submit'])){
    foreach ($_POST as $index => $date){
        if ($date != "opslaan"){
            registerDate($date , $conn, $username);
        }
    }
    $_POST = "";
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    <title>Beschikbaarheid aangeven</title>
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

<h1 class="weekviewtitle">Geef hier uw beschikbaarheid aan</h1>
<div class="availabilitycontent">


        <div class="chooseweekbtns">
            <form name="chooseWeek" action="beschikbaarheid.php" method="post">
                <button class="chswk" type="submit" name="week" value="<?= $mondayTimeStamp ?>">week <?= date('W', $mondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $secondMondayTimeStamp ?>">week <?= date('W', $secondMondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $thirdMondayTimeStamp ?>">week <?= date('W', $thirdMondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $fourthMondayTimeStamp ?>">week <?= date('W', $fourthMondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $fifthMondayTimeStamp ?>">week <?= date('W', $fifthMondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $sixthMondayTimeStamp ?>">week <?= date('W', $sixthMondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $seventhMondayTimeStamp ?>">week <?= date('W', $seventhMondayTimeStamp) ?></button>
                <button class="chswk"  type="submit" name="week" value="<?= $eighthMondayTimeStamp ?>">week <?= date('W', $eighthMondayTimeStamp) ?></button>
            </form>
        </div>

    <div class="datepickthing">
        <h3><?= "week " . date('W', $chosenTimeStamp) ?></h3>
        <form name="week" action="beschikbaarheid.php" method="post">
            <label for="date1">maandag <?= $date1?></label>
            <input type="checkbox" name="date1" id="date1" value="<?= $date1 ?>">
            <br>
            <label for="date2">dinsdag <?= $date2?></label>
            <input type="checkbox" name="date2" id="date2" value="<?= $date2 ?>">
            <br>
            <label for="date3">woensdag <?= $date3?></label>
            <input type="checkbox" name="date3" id="date3" value="<?= $date3 ?>">
            <br>
            <label for="date4">donderdag <?= $date4?></label>
            <input type="checkbox" name="date4" id="date4" value="<?= $date4 ?>">
            <br>
            <label for="date5">vrijdag <?= $date5?></label>
            <input type="checkbox" name="date5" id="date5" value="<?= $date5 ?>">
            <br>
            <label for="date6">zaterdag <?= $date6?></label>
            <input type="checkbox" name="date6" id="date6" value="<?= $date6 ?>">
            <br>
            <button type="submit" name="submit">Opslaan</button>
        </form>
    </div>
</div>

</body>
