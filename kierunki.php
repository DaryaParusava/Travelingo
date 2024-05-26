<?php
session_start();

require_once "connect.php";
$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $ticket_id = $_POST['id'];
    $_SESSION['ticket_id'] = $ticket_id; 
    header("Location: konto.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleKierunki.css">
</head>

<body onload='displayTime()'>
    <div id="upPart">
        <a href="index.php" class="up" id="logo">TRAVELINGO</a>
        <a href="my.php" class="up">my</a>
        <a href="kierunki.php" class="up"><b>kierunki</b></a>
        <a href="pomoc.php" class="up">pomoc </a>
        <a href="travelFam.php" class="up">travelFam </a>
        <a href="konto.php" class="up" id="konto">konto</a>
    </div>

    <div id="mainPart">
    <div id="timeDisplay"></div>
        <h1>🠗 WYBIERZ SWOJĄ PODRÓŻ 🠗 </h1>
        
        <?php
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `id`, `punkt_od`, `punkt_do`, `cena`, `czas` FROM `Kierunki`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
            <tr>
                <th id='th'>Odkąd</th>
                <th id='th'>Dokąd</th>
                <th id='th'>Czas</th>
                <th id='th'>Cena</th>
            </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td id='td'>{$row['punkt_od']}</td>
                <td id='td'>{$row['punkt_do']}</td>
                <td id='tdCZAS'>{$row['czas']}</td>
                <td id='tdCENA'>{$row['cena']} zł</td>
                <td  id='butKup'>
                    <form action='kierunki.php' method='post'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button id='butKup' type='submit'><p id='kupic'>KUPIĆ<p></button>
                    </form>
                </td>
            </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>

    </div>

    <div id="downPart">
        <h4> Pobierz naszą aplikację! </h4><br>
        <div id="applikacje">
            <a href="https://play.google.com/store/account"> <img id="google" src="googleplay.png"> </a>
            <a href="https://www.apple.com/pl/app-store/"> <img id="app" src="app.png"> </a>
        </div>
        <h4>Znajdż nas :</h4> <br>
        <div id="logos">
            <a href="https://www.instagram.com/"><img class="img" src="inst.jpg"></a>
            <a href="https://www.tiktok.com/"><img class="img" src="tt.jpg">
            <a href="https://m.youtube.com/?gl=PL&hl=pl"><img class="img" src="yt.jpg">
            <a href="https://web.whatsapp.com/"><img class="img" src="wa.jpg">
            <a href="https://web.telegram.org/"><img class="img" src="tg.jpg">
            <a href="https://twitter.com/?lang=pl"><img class="img" src="tw.jpg"><br>
        </div>
    </div>
<script src="script.js"></script>
</body>

</html>
