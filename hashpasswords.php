
<?php
/*
require_once ('connect.php');

$sql = "SELECT `relatie_nummer`, `wachtwoord` FROM `bezorgers` ORDER BY `relatie_nummer` ASC";

$result = mysqli_query($conn, $sql);

$passwords = [];
while ($row = mysqli_fetch_assoc($result)) {
    $passwords [] = $row;
}

print_r($passwords);

 foreach ($passwords as $index => $password){
     $relnum = $password['relatie_nummer'];
    $passwordnew = password_hash($password['wachtwoord'], PASSWORD_DEFAULT);
    $sql = "UPDATE `bezorgers` SET `wachtwoord`= '$passwordnew' WHERE `relatie_nummer` = '$relnum' ";

    mysqli_query($conn, $sql);
 }
*/
 ?>


<head>

</head>

<body>
<?php foreach ($passwords as $index => $password){ ?>
    <p><?= $password['relatie_nummer'] . " " . $password['wachtwoord']?></p>
    <br>
<?php } ?>

</body>