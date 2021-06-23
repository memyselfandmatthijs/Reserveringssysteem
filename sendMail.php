<?php
use PHPMailer\PHPMailer\PHPMailer;


function mailBezorger($bezorger, $date, $conn, $wijk){

    $getMailAdressSql = "SELECT * FROM `bezorgers` WHERE `relatie_nummer` = '$bezorger'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $getMailAdressSql));
    $recievingMailAdress = $result["mailAdress"];
    $nameReceiver = $result['voornaam'] . " " . $result['achternaam'];
    $nameSender = "krantenbezorger reserveren | ";
    $sendingEmail = "krantenbezorgerreserveren@gmail.com";

    echo $result['mailAdress'] . "<br>";
    echo $date . "<br>";
    echo $bezorger . "<br>";

    require_once("PHPMailer/PHPMailer.php");
    require_once("PHPMailer/SMTP.php");
    require_once("PHPMailer/Exception.php");

    $mail = new PHPMailer();

    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = $sendingEmail;
    $mail->Password = 'f*ets123';
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";

    //email settings
    $mail->isHTML(true);
    $mail->setFrom($sendingEmail, $nameSender);
    $mail->addAddress($recievingMailAdress);
    $mail->Subject = ("$sendingEmail (U bent gereserveerd voor {$date})");
    $mail->Body = "Goedemiddag {$nameReceiver}, <br> U bent gereserveerd voor {$wijk}. <br> Verdere details kunt u vinden op de site : https://stud.hosted.hr.nl/1013008/Reserveringssysteem/inlog.php . <br> <br> Met vriendelijke groet, <br> Mitchel the mailbot ";

    if ($mail->send()) {
        $status = "success";
        $response = "Email is sent!";
        header('location: Reserveren.php');
    } else {
        $status = "failed";
        $response = "Something is wrong: <br>" . $mail->ErrorInfo;
    }

    exit(json_encode(array("status" => $status, "response" => $response)));

}

?>
