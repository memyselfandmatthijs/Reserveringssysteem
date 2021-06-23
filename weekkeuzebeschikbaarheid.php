<?php
require_once('customFunctions.php');

check_logged_in();

$referenceTimestamp = 1609714819;
$secondsPerWeek = 604800;
$secondsPerDay = 86400;
$nextWeekNumber = date('W') + 1;
$standardWeekNumber = date('W', $referenceTimestamp);
$differenceInWeeks = $nextWeekNumber - $standardWeekNumber;

$mondayTimeStamp = date('U', ($referenceTimestamp + ($differenceInWeeks * $secondsPerWeek)));
$secondMondayTimeStamp = $mondayTimeStamp + $secondsPerWeek;
$thirdMondayTimeStamp = $mondayTimeStamp + 2 * $secondsPerWeek;
$fourthMondayTimeStamp = $mondayTimeStamp + 3 * $secondsPerWeek;
$fifthMondayTimeStamp = $mondayTimeStamp + 4 * $secondsPerWeek;
$sixthMondayTimeStamp = $mondayTimeStamp + 5 * $secondsPerWeek;
$seventhMondayTimeStamp = $mondayTimeStamp + 6 * $secondsPerWeek;
$eighthMondayTimeStamp = $mondayTimeStamp + 7 * $secondsPerWeek;

if (isset($_POST['firstWeek'])){
    $_SESSION['week'] = $mondayTimeStamp;
    header('location: beschikbaarheid.php');
}

if (isset($_POST['secondWeek'])){
    $_SESSION['week'] = $secondMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
if (isset($_POST['thirdWeek'])){
    $_SESSION['week'] = $thirdMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
if (isset($_POST['fourthWeek'])){
    $_SESSION['week'] = $fourthMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
if (isset($_POST['fifthWeek'])){
    $_SESSION['week'] = $fifthMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
if (isset($_POST['sixthWeek'])){
    $_SESSION['week'] = $sixthMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
if (isset($_POST['seventhWeek'])){
    $_SESSION['week'] = $seventhMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
if (isset($_POST['eighthWeek'])){
    $_SESSION['week'] = $eighthMondayTimeStamp;
    header('location: beschikbaarheid.php');
}
?>

<head>
    <title> Week kiezen </title>
</head>

<body>
<h1> Kies een week </h1>

<a href="homepage.php">terug</a>
<br>
<br>

<form name="chooseWeek" action="weekkeuzebeschikbaarheid.php" method="post">

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