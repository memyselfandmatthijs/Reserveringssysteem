<?php
session_start();

require_once ('connect.php'); //connect to database

//emptying the values
$userFeedback = "";
$checkPassword = "";

//retrieving the username and password input by the user
if (isset($_POST['relNumber'])) {
    $givenUserName = mysqli_escape_string($conn, $_POST['relNumber']);
    $givenPassword = mysqli_escape_string($conn, $_POST['password']);

    $passwordRetrieveSql = " SELECT wachtwoord FROM bezorgers WHERE relatie_nummer = $givenUserName";
    $result = mysqli_query($conn, $passwordRetrieveSql);


    if ($givenUserName != "") {
        $checkPassword = mysqli_fetch_assoc($result)['wachtwoord'];
    }

//check whether or not the password is correct
    if ($checkPassword && password_verify($givenPassword, $checkPassword) && $checkPassword != "") {
        $userFeedback = "";
        $_SESSION['login'] = "true";
        $_SESSION['username'] = $givenUserName;
        header('Location: homepage.php');
        die();
    }

//if not, give the feedback
    if ($checkPassword != $givenPassword && $givenUserName != "") {
        $userFeedback = "Relatienummer of wachtwoord onjuist";
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
    <title>Inloggen</title>

</head>

<body>
    <div    class="header">
        <h1 class="headertext">Krantenbezorger reserveren</h1>

    <div class="bloglink">
        <form name="bloglink" method="post" action="https://stud.hosted.hr.nl/1013008/">
        <button class="bloglink"> Terug naar de blog</button>
        </form>
    </div>
    </div>
    <hr>

    <div class="content">
        <div class="whiteContent">

            <h1>Inloggen</h1>
            <p><?= $userFeedback ?></p>

            <form action="inlog.php" method="post">
                <label for ="relNumber">Relatienummer:</label>
                <input type="text" id="relNumber" name="relNumber" required>
                <br>
                <label for ="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <br>
                <button type="submit">Inloggen</button>
            </form>
        </div>
    </div>
</body>
