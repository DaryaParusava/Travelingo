<?php
require_once "connect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

// Check connection
if ($polaczenie->connect_error) {
    die("Connection failed: " . $polaczenie->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    if (empty($_POST['email']) || empty($_POST['skills']) || empty($_POST['experience']) || empty($_POST['age']) || empty($_POST['english_level']) || empty($_POST['education'])) {
        $message = "Proszę wypełnić wszystkie pola formularza.";
    } else {
        $email = '';
        if (isset($_POST['email'])) {
            $email = $polaczenie->real_escape_string($_POST['email']);
        }

        if (isset($_POST['skills'])) {
            $skills = $polaczenie->real_escape_string($_POST['skills']);
        }


        if (isset($_POST['experience'])) {
            $experience = $polaczenie->real_escape_string($_POST['experience']);
        }

        if (isset($_POST['age'])) {
            $age = $polaczenie->real_escape_string($_POST['age']);
        }

        if (isset($_POST['english_level'])) {
            $english_level = $polaczenie->real_escape_string($_POST['english_level']);
        }

        if (isset($_POST['education'])) {
            $education = $polaczenie->real_escape_string($_POST['education']);
        }

        // Sprawdzenie, czy adres e-mail istnieje w tabeli 'uzytkownicy'
        $query_check_email = "SELECT * FROM uzytkownicy WHERE email='$email'";
        $result_check_email = $polaczenie->query($query_check_email);

        // Jeśli adres e-mail nie istnieje w tabeli 'uzytkownicy'
        if ($result_check_email->num_rows == 0) {
            $message = "Konto z tym adresem e-mail nie istnieje. <br><a id='hrefFam' href='rejestracja.php'>Kliknij tu żeby stworzyc konto</a>.";
        } else {
            // Sprawdzenie roli użytkownika
            $row = $result_check_email->fetch_assoc();
            if ($row['rola'] == 'admin') {
                $message = "Użytkownik już jest administratorem";
            } else {
                // Wstawienie danych do tabeli CV
                $sqlm = "INSERT INTO CV (email, wiek, umiejetnosci, poziom_angielskiego, doswiadczenie, edukacja) 
                        VALUES ('$email', '$age', '$skills', '$english_level', '$experience', '$education')";

                if ($polaczenie->query($sqlm) === TRUE) {
                    $message = "Twoje dane zostały pomyślnie przesłane.";
                } else {
                    $message = "Błąd podczas przesyłania danych: " . $polaczenie->error;
                }
            }
        }
    }
}

$polaczenie->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleTravel.css">
</head>

<body>
    <div id="upPart">
        <a href="index.php" class="up" id="logo">TRAVELINGO</a>
        <a href="my.php" class="up"> my</a>
        <a href="kierunki.php" class="up">kierunki</a>
        <a href="pomoc.php" class="up">pomoc </a>
        <a href="travelFam.php" class="up"><b>travelFam </b></a>
        <a href="konto.php" class="up" id="konto">konto </a>
    </div>
    <div id="mainPart">
        <img id="work" src="work.jpg">
        <div id="mainText">
            <h1>DOŁĄĆ DO NASZEGO ZESPOŁU!</h1><br>
            <h2> Dynamiczne środowisko pracy</h2>
            <h3>Branża transportowa jest nieustannie zmieniającym się środowiskiem, w którym każdego dnia pojawiają się nowe wyzwania i możliwości. Praca w takim dynamicznym otoczeniu stymuluje rozwój osobisty i zawodowy, pozwala na ciągłe doskonalenie umiejętności oraz szybkie reagowanie na zmiany w otoczeniu rynkowym. Travelingo jako firma transportowa jest częścią tego ekscytującego świata, oferując swoim pracownikom możliwość uczestniczenia w fascynujących projektach i operacjach, które sprawiają, że praca nigdy nie staje się nudna. </h3>
            <br>
            <h2>Rozwój zawodowy</h2>
            <h3>W Travelingo mocno wierzymy w rozwój naszych pracowników jako kluczowy element naszego sukcesu. Dlatego oferujemy szeroki zakres szkoleń i programów rozwoju, które pozwalają naszym pracownikom rozwijać swoje umiejętności i zdobywać nowe kwalifikacje. Niezależnie od tego, czy jesteś nowym pracownikiem czy doświadczonym specjalistą, zawsze znajdziesz u nas wsparcie i możliwości rozwoju, które pomogą Ci osiągnąć swoje zawodowe cele.</h3>
            <br>
            <h2> Zespół ekspertów</h2>
            <h3>Nasz zespół składa się z doświadczonych i wykwalifikowanych specjalistów, którzy są ekspertami w swoich dziedzinach. Dołączając do Travelingo, stajesz się częścią tego zgranego zespołu, który wspólnie dąży do osiągania sukcesów. Możesz liczyć na wsparcie, mentorstwo i inspirację ze strony swoich kolegów, którzy chętnie dzielą się swoją wiedzą i doświadczeniem, co przyspiesza Twój rozwój zawodowy i pozwala osiągnąć wyższe cele. </h3>
            <br>
            <h2> Świadczenia dodatkowe</h2>
            <h3> W Travelingo cenimy naszych pracowników i dbamy o ich dobrostan. Dlatego oferujemy atrakcyjny pakiet świadczeń dodatkowych, który obejmuje prywatną opiekę zdrowotną, programy motywacyjne, dodatkowe dni wolne, a także korporacyjne wyjazdy integracyjne. Nasze świadczenia dodatkowe nie tylko podnoszą jakość życia naszych pracowników, ale także budują silne więzi w zespole i motywują do osiągania wspólnych celów.</h3>
            <br>
            <h2>Możliwość podróży </h2>
            <h3> Jako firma transportowa obsługująca różnorodne trasy, Travelingo oferuje swoim pracownikom unikalną możliwość podróżowania i poznawania nowych miejsc. Dzięki pracy w Travelingo możesz odkrywać różnorodne kultury, krajobrazy i doświadczenia, co nie tylko poszerza Twoje horyzonty, ale także sprawia, że praca staje się pasjonującą przygodą. Dodatkowo, podróże służbowe mogą być świetną okazją do budowania relacji z klientami i partnerami biznesowymi, co przyczynia się do rozwoju firmy i umacniania jej pozycji na rynku.</h3>
        </div>
        <h1 id="countdown"></h1>
        <h1 id="CV"> WYŚLIJ NAM SWOJE CV </h1>

        <form action="travelFam.php" id="formPomoc" method="POST">
            <label>Email:</label>
            <input id="inpPomoc" type="email" id="email" name="email"><br>
            Umiejętności:
            <input id="inpPomoc" type="text" id="skills" name="skills"><br>
            Doświadczenie:
            <input id="inpPomoc" id="experience" name="experience"><br>
            Wiek:
            <input id="inpPomoc" type="number" id="age" name="age"><br>
            Poziom angielskiego:
            <select id="inpPomoc" id="english_level" name="english_level">
                <option value="A1">A1</option>
                <option value="A2">A2</option>
                <option value="B1">B1</option>
                <option value="B2">B2</option>
                <option value="C1">C1</option>
                <option value="C2">C2</option>
                <option value="C2+">C2+</option>
            </select><br>
            Edukacja:
            <input id="inpPomoc" type="text" id="education" name="education"><br>
            <input id="inputPomoc" type="submit" value="Wyślij CV">
        </form>
        <?php
        echo "<p id='pBLAD' style='color: navy;  text-align:center; font-weight: bold; margin-bottom: 20px;'>$message</p>";
        ?>
    </div>

    <div id="downPart">
        <h4> Pobierz naszą aplikację! </h4><br>
        <div id="applikacje"> <a href="https://play.google.com/store/account"> <img id="google" src="googleplay.png"> </a>
            <a href="https://www.apple.com/pl/app-store/"> <img id="app" src="app.png"> </a> </div>
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
    <script src="script.js"> </script>
</body>

</html>
