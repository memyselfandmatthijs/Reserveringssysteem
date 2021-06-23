<?php

require_once ("customFunctions.php"); //get some homemade functions
require_once ("connect.php"); //connect to database

check_logged_in();
$adminCheck = check_admin_right($conn);
$user = $_SESSION['username'];
$date = date('Y-n-j');

/*
$getFullUsernameSql = "SELECT `voornaam`,`achternaam` FROM `bezorgers` WHERE `relatie_nummer` = '$user'";
$result = mysqli_query($conn, $getFullUsernameSql);
$nameArray = mysqli_fetch_assoc($result);
$fullName = $nameArray['voornaam'] . " " . $nameArray['achternaam'];
*/

if (!isset($_POST['type'])){
    $chooseType = "datesThisWeek";
    $_POST['type'] = "datesThisWeek";
}

if (isset($_POST['type'])){
    $chooseType = $_POST['type'];

    if ($chooseType == "allDates") {
        $updateReserveringenSql = "DELETE FROM `reserveringen` WHERE `datum` < '$date'";
        mysqli_query($conn, $updateReserveringenSql);

        $getScheduleSql = "SELECT * FROM `reserveringen` WHERE `relatie_nummer` = '$user' ORDER BY `reserveringen`.`datum` ASC";
        $result = mysqli_query($conn, $getScheduleSql);

        $appointmentList = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $appointmentList [] = $row;
        }
    }

}

if ($chooseType == "datesThisWeek") {

    $referenceTimestamp = 1609714819;
    $secondsPerWeek = 604800; //Aantal seconden in een week
    $secondsPerDay = 86400;
    $weekNumber = date('W');
    $standardWeekNumber = date('W', $referenceTimestamp);
    $differenceInWeeks = $weekNumber - $standardWeekNumber;

    $mondayTimeStamp = date('U', ($referenceTimestamp + ($differenceInWeeks * $secondsPerWeek)));
    $saturdayTimeStamp = date('U', ($referenceTimestamp + ($differenceInWeeks * $secondsPerWeek) + (5 * $secondsPerDay)));
    $saturdayDate = date('Y-n-j', $saturdayTimeStamp);
    $getThisWeeksDatesSql = "SELECT * FROM `reserveringen` WHERE `datum` <= '$saturdayDate' AND `relatie_nummer` = '$user' ORDER BY `reserveringen`.`datum` ASC";

    $result = mysqli_query($conn, $getThisWeeksDatesSql);
    $appointmentList = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $appointmentList [] = $row;
    }

    $tasks = [];

    foreach ($appointmentList as $index => $appointment){
        $date = $appointment['datum'];
        $date = explode('-', $date);

        $taskDay = date('l', mktime(0, 0, 0, $date[1], $date[2], $date[0]));
        //echo $taskDay;
        if ($taskDay == "Monday"){
            $tasks['monday'] = "maandag -" . $appointment['wijk'];
        }
        if ($taskDay == "Tuesday"){
            $tasks['tuesday'] = "dinsdag -" . $appointment['wijk'];
        }
        if ($taskDay == "Wednesday"){
            $tasks['wednesday'] = "woensdag -" . $appointment['wijk'];
        }
        if ($taskDay == "Thursday"){
            $tasks['thursday'] = "donderdag -" . $appointment['wijk'];
        }
        if ($taskDay == "Friday"){
            $tasks['friday'] = "vrijdag -" . $appointment['wijk'];
        }
        if ($taskDay == "Saturday"){
            $tasks['saturday'] = "zaterdag - " . $appointment['wijk'];
        }

    }




}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    <title>Homepage</title>
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


    <div class="weekoverview">
            <?php if ($chooseType == "allDates"){ ?>
            <h1 class="weekviewtitle">afsprakenoverzicht</h1>
            <?php } else { ?>
            <h1 class="weekviewtitle">weekoverzicht week <?= $weekNumber ?></h1>
            <?php } ?>

        <form class="choosetypebtns" name="chooseType" action="homepage.php" method="post">
            <button type="submit" name="type" value="datesThisWeek">Weekoverzicht</button>
            <button type="submit" name="type" value="allDates">Totaaloverzicht</button>
        </form>

            <?php if($chooseType == "allDates"){ ?>
            <table>
                <tr>
                    <th>datum</th>
                    <th class="center">wijk</th>
                    <th>bijzonderheden</th>
                </tr>

                <?php foreach ($appointmentList as $appointment){ ?>
                    <tr>
                        <td><?= $appointment['datum']?></td>
                        <td class="center"><?= $appointment['wijk']?></td>
                        <td><?= $appointment['bijzonderheden']?></td>
                    </tr>
                <?php } ?>
            </table>
                <?php  if (!isset($appointmentList[0])){?>
                    <p>Er zijn geen reserveringen voor de komende acht weken </p>

                <?php } ?>

        <?php }
        if ($chooseType == "datesThisWeek"){ ?>
        <div>
            <table>
                <?php foreach ($tasks as $task){ ?>
                <tr>
                    <td><?= $task ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php  if (!isset($tasks[0])){?>
                <p>Er zijn geen reserveringen voor de komende week </p>

            <?php } ?>
        </div>

        <?php } ?>
        </div>

</body>