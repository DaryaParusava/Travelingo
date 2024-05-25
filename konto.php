<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>konto</title> 
    <link rel="stylesheet" href="styleKonto.css"> 
</head>
<body>
<div id="upPart">
   <a href="index.php" class="up" id="logo">TRAVELINGO</a>
   <a href="my.php" class="up"> my</a>
   <a href="kierunki.php" class="up">kierunki</a>
   <a href="pomoc.php" class="up">pomoc </a>
   <a href="travelFam.php" class="up">travelFam </a>
   <a href="konto.php" class="up" id="konto"><b>konto</b> </a>
</div>

<div id="mainPart">
    <?php
    session_start();

    $blad = "";

    if (isset($_POST['login'], $_POST['haslo'], $_POST['role'])) {
        require_once "connect.php";
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if ($polaczenie->connect_errno) {
            echo "Error: " . $polaczenie->connect_error;
        } else {
            $login = $polaczenie->real_escape_string($_POST['login']);
            $haslo = $polaczenie->real_escape_string($_POST['haslo']);
            $role = $polaczenie->real_escape_string($_POST['role']);

            $query = "SELECT * FROM uzytkownicy WHERE login='$login' AND rola='$role'";
            $result = $polaczenie->query($query);

            if ($result) {
                $user = $result->fetch_assoc();
                if ($user && password_verify($haslo, $user['haslo'])) {
                    $_SESSION['zalogowany'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['login'];
                    header('Location: witamy.php');
                    exit();
                } else {
                    $blad = '<span id="span" style="color:red; margin-right:110px; font-size: 16px;">Nieprawidłowy login lub hasło!</span>';
                }
                $result->free();
            } else {
                echo "Błąd zapytania SQL: " . $polaczenie->error;
            }

            $polaczenie->close();
        }
    }
    ?>

    <div id="formularz">
        <form action="konto.php" method="post">
            Login: <input type="text" name="login"><br>
            Hasło: <input type="password" name="haslo"><br>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="user">Użytkownik</option>
            </select><br>
            <button type="submit">Zaloguj się</button><br>
            <a href="rejestracja.php"> Załóż darmowe konto </a>
        </form>
    </div>

    <?php 
    if($blad != "") {
        echo $blad;
    }
   

?>
</div>

<div id="downPart">
    <h4> Pobierz naszą aplikację! </h4><br>
    <div id="applikacje">  
        <a href="https://play.google.com/store/account"><img id="google" src="googleplay.png"></a>
        <a href="https://www.apple.com/pl/app-store/"><img id="app" src="app.png"></a>  
    </div>
    <h4>Znajdż nas :</h4><br>
    <div id="logos">
        <a href="https://www.instagram.com/"><img class="img" src="inst.jpg"></a>
        <a href="https://www.tiktok.com/"><img class="img" src="tt.jpg"></a>
        <a href="https://m.youtube.com/?gl=PL&hl=pl"><img class="img" src="yt.jpg"></a>
        <a href="https://web.whatsapp.com/"><img class="img" src="wa.jpg"></a>
        <a href="https://web.telegram.org/"><img class="img" src="tg.jpg"></a>
        <a href="https://twitter.com/?lang=pl"><img class="img" src="tw.jpg"><br></a>
    </div>  
</body>
</html>
