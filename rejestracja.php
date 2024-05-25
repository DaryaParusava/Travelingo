<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <link rel="stylesheet" href="styleRejestracja.css"> 
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

if (isset($_POST['email'])) {
    $wszystko_OK = true;

    $nick = $_POST['nick'];

    if ((strlen($nick) < 3) || (strlen($nick) > 20)) {
        $wszystko_OK = false;
        $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";
    }

    if (ctype_alnum($nick) == false) {
        $wszystko_OK = false;
        $_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
    }

    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $wszystko_OK = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
    }

    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
    }

    if ($haslo1 != $haslo2) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

    if (!isset($_POST['regulamin'])) {
        $wszystko_OK = false;
        $_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu!";
    }

    $file_error = $_FILES['file']['error'];

        if ($file_error == UPLOAD_ERR_NO_FILE) {
            $_SESSION['e_file'] = "Wybierz plik";
        } else if ($file_error != UPLOAD_ERR_OK) {
            $_SESSION['e_file'] = "Błąd";
        }

    $_SESSION['fr_nick'] = $nick;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_haslo1'] = $haslo1;
    $_SESSION['fr_haslo2'] = $haslo2;

    if (isset($_POST['regulamin'])) {
        $_SESSION['fr_regulamin'] = true;
    }

    if ($wszystko_OK) {
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_maili = $rezultat->num_rows;
                if ($ile_takich_maili > 0) {
                    $wszystko_OK = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
                }

                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE login='$nick'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nickow = $rezultat->num_rows;
                if ($ile_takich_nickow > 0) {
                    $wszystko_OK = false;
                    $_SESSION['e_nick'] = "Istnieje już gracz o takim nicku! Wybierz inny.";
                }

                if ($wszystko_OK == true) {
                    if ($polaczenie->query("INSERT INTO uzytkownicy (login, haslo, email, rola, id_akt_podrozy) VALUES ('$nick', '$haslo_hash', '$email', 'user', NULL)")) {
                        $_SESSION['udanarejestracja'] = true;
                        echo "<b>Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!<b><br /><br /><a style='color:darkblue;'href='konto.php'><b>kliknij żeby się zalogować</b></a>";
                    } else {
                        throw new Exception($polaczenie->error);// W przypadku niepowodzenia zapytania SQL INSERT, rzucamy nowym wyjątkiem z komunikatem błędu SQL
                    }
                }

                $polaczenie->close();
            }
        } catch (Exception $e) { //catch kod obsługuje wyjątek, który został rzucony wewnątrz bloku try
            //szczegółowe informacje o błędzie, takie jak jego opis, kod błędu, ścieżka do pliku, w którym wystąpił błąd, oraz numer linii,
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska: ' . $e;
        }
    }
}
?>


<form id="formRej" method="post" enctype="multipart/form-data">

    Nickname: 
    <input id="inpRej1" type="text" value="<?php
    if (isset($_SESSION['fr_nick'])) {
        echo $_SESSION['fr_nick'];
        unset($_SESSION['fr_nick']);
    }
    ?>" name="nick"/>

    <?php
    if (isset($_SESSION['e_nick'])) {
        echo '<div class="error">' . $_SESSION['e_nick'] . '</div>';
        unset($_SESSION['e_nick']);
    }
    ?><br/>

    E-mail:
    <input id="inpRej1"type="text" name="email"/>
    <?php
    if (isset($_SESSION['fr_email'])) {
        echo $_SESSION['fr_email'];
        unset($_SESSION['fr_email']);
    }
    ?>

    <?php
    if (isset($_SESSION['e_email'])) {
        echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
        unset($_SESSION['e_email']);
    }
    ?><br/>

    Twoje hasło: 
    <input id="inpRej1" type="password" value="<?php
    if (isset($_SESSION['fr_haslo1'])) {
        echo $_SESSION['fr_haslo1'];
        unset($_SESSION['fr_haslo1']);
    }
    ?>" name="haslo1"/>

    <?php
    if (isset($_SESSION['e_haslo'])) {
        echo '<div class="error">' . $_SESSION['e_haslo'] . '</div>';
        unset($_SESSION['e_haslo']);
    }
    ?><br/>

    Powtórz hasło:
    <input id="inpRej1" type="password" value="<?php
    if (isset($_SESSION['fr_haslo2'])) {
        echo $_SESSION['fr_haslo2'];
        unset($_SESSION['fr_haslo2']);
    }
    ?>" name="haslo2"/><br>

    <label>
        <input id="regCheck"type="checkbox" name="regulamin" <?php
        if (isset($_SESSION['fr_regulamin'])) {
            echo "checked";
            unset($_SESSION['fr_regulamin']);
        }
        ?>/> Akceptuję regulamin
    </label><br>
    
    <?php
    if (isset($_SESSION['e_regulamin'])) {
        echo '<div class="error">' . $_SESSION['e_regulamin'] . '</div>';
        unset($_SESSION['e_regulamin']);
    }
    ?>
    
    Plik:
    <input id="inpRej1" type="file" name="file"/><br/>
    <?php
    if (isset($_SESSION['e_file'])) {
        echo '<div class="error">' . $_SESSION['e_file'] . '</div>';
        unset($_SESSION['e_file']);
    }
    ?><br/>


    <input id="inputRej" type="submit" value="Zarejestruj się"/>

</form>

</div>


<div id="downPart">
    <h4> Pobierz naszą aplikację! </h4><br>
    <div id="applikacje">  
    <a href="https://play.google.com/store/account">  <img id="google" src="googleplay.png" >  </a>
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
