<?php
require_once ('connect.php');
require_once ('customFunctions.php');

check_logged_in();
$username = $_SESSION['username'];
//$referenceTimestamp = 1607295600; //7 dec 2020, als er tijd over is nog effe fiksen dat het over meerdere jaren werkt
$referenceTimestamp = 1609714819;
$secondsPerWeek = 604800; //Aantal seconden in een week
$secondsPerDay = 86400;
$nextWeekNumber = date('W') + 1;
$standardWeekNumber = date('W', $referenceTimestamp);
$differenceInWeeks = $nextWeekNumber - $standardWeekNumber;
$register = false;

$mondayTimeStamp = date('U', ($referenceTimestamp + ($differenceInWeeks * $secondsPerWeek)));
$secondMondayTimeStamp = $mondayTimeStamp + $secondsPerWeek;
$thirdMondayTimeStamp = $mondayTimeStamp + 2 * $secondsPerWeek;
$fourthMondayTimeStamp = $mondayTimeStamp + 3 * $secondsPerWeek;
$fifthMondayTimeStamp = $mondayTimeStamp + 4 * $secondsPerWeek;
$sixthMondayTimeStamp = $mondayTimeStamp + 5 * $secondsPerWeek;
$seventhMondayTimeStamp = $mondayTimeStamp + 6 * $secondsPerWeek;
$eighthMondayTimeStamp = $mondayTimeStamp + 7 * $secondsPerWeek;



if (isset($_POST['firstWeek'])){
    $chosenTimeStamp = $mondayTimeStamp;
}

if (isset($_POST['secondWeek'])){
    $chosenTimeStamp = $secondMondayTimeStamp;
}
if (isset($_POST['thirdWeek'])){
    $chosenTimeStamp = $thirdMondayTimeStamp;
}
if (isset($_POST['fourthWeek'])){
    $chosenTimeStamp = $fourthMondayTimeStamp;
}
if (isset($_POST['fifthWeek'])){
    $chosenTimeStamp = $fifthMondayTimeStamp;
}
if (isset($_POST['sixthWeek'])){
    $chosenTimeStamp = $sixthMondayTimeStamp;
}
if (isset($_POST['seventhWeek'])){
    $chosenTimeStamp = $seventhMondayTimeStamp;
}
if (isset($_POST['eighthWeek'])){
    $chosenTimeStamp = $eighthMondayTimeStamp;
}
if ($_POST == ""){ //$chosenTimeStamp <= $referenceTimestamp ||
    $chosenTimeStamp = $mondayTimeStamp;
}

echo "chosen is " . date('W', $chosenTimeStamp);

$date1 = date('j n Y', $chosenTimeStamp);
$date2 = date('j n Y', $chosenTimeStamp + (1 * $secondsPerDay));
$date3 = date('j n Y', $chosenTimeStamp + (2 * $secondsPerDay));
$date4 = date('j n Y', $chosenTimeStamp + (3 * $secondsPerDay));
$date5 = date('j n Y', $chosenTimeStamp + (4 * $secondsPerDay));
$date6 = date('j n Y', $chosenTimeStamp + (5 * $secondsPerDay));

if (isset($_POST['submit'])) {
    $check1 = $_POST['date1'];
    $check2 = $_POST['date2'];
    $check3 = $_POST['date3'];
    $check4 = $_POST['date4'];
    $check5 = $_POST['date5'];
    $check6 = $_POST['date6'];
    $register = true;
}

if ($register == "true") {
    registerDate($date1, $check1, $username, $conn);
    registerDate($date2, $check2, $username, $conn);
    registerDate($date3, $check3, $username, $conn);
    registerDate($date4, $check4, $username, $conn);
    registerDate($date5, $check5, $username, $conn);
    registerDate($date6, $check6, $username, $conn);
    $register = false;
}

/*
 <button type="submit" name="week" value="<?= $mondayTimeStamp ?>">week <?= date('W', $mondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $secondMondayTimeStamp ?>">week <?= date('W', $secondMondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $thirdMondayTimeStamp ?>">week <?= date('W', $thirdMondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $fourthMondayTimeStamp ?>">week <?= date('W', $fourthMondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $fifthMondayTimeStamp ?>">week <?= date('W', $fifthMondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $sixthMondayTimeStamp ?>">week <?= date('W', $sixthMondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $seventhMondayTimeStamp ?>">week <?= date('W', $seventhMondayTimeStamp) ?></button>
    <button type="submit" name="week" value="<?= $eighthMondayTimeStamp ?>">week <?= date('W', $eighthMondayTimeStamp) ?></button>

 */


echo "<br>";
print_r($_POST);
?>

<head>
<title>Beschikbaarheid aangeven</title>
</head>

<body>
<h1>Geef hier uw beschikbaarheid aan</h1>

<a href="homepage.php">Terug</a>

<h3><?= "week " . date('W', $chosenTimeStamp) ?></h3>
<form name="week" action="beschikbaarheid.php" method="post">
    <label for="date1">maandag <?= $date1?></label>
    <input type="checkbox" name="date1" id="date1">
    <br>
    <label for="date2">dinsdag <?= $date2?></label>
    <input type="checkbox" name="date2" id="date2">
    <br>
    <label for="date3">woensdag <?= $date3?></label>
    <input type="checkbox" name="date3" id="date3">
    <br>
    <label for="date4">donderdag <?= $date4?></label>
    <input type="checkbox" name="date4" id="date4">
    <br>
    <label for="date5">vrijdag <?= $date5?></label>
    <input type="checkbox" name="date5" id="date5">
    <br>
    <label for="date6">zaterdag <?= $date6?></label>
    <input type="checkbox" name="date6" id="date6">
    <br>
    <input type="submit"  name="submit"  value="opslaan">
</form>

<form name="chooseWeek" action="beschikbaarheid.php" method="post">
    <input type="submit" name="firstWeek" value="week <?= date('W', $mondayTimeStamp) ?>">
    <input type="submit" name="secondWeek" value="week <?= date('W', $secondMondayTimeStamp) ?>">
    <input type="submit" name="thirdWeek" value="week <?= date('W', $thirdMondayTimeStamp) ?>">
    <input type="submit" name="fourthWeek" value="week <?= date('W', $fourthMondayTimeStamp) ?>">
    <input type="submit" name="fifthWeek" value="week <?= date('W', $fifthMondayTimeStamp) ?>">
    <input type="submit" name="sixthWeek" value="week <?= date('W', $sixthMondayTimeStamp) ?>">
    <input type="submit" name="seventhWeek" value="week <?= date('W', $seventhMondayTimeStamp) ?>">
    <input type="submit" name="eighthWeek" value="week <?= date('W', $eighthMondayTimeStamp) ?>">

</form>

</body>
