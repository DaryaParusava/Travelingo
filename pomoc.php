
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylePomoc.css">
</head>
<body>
<div id="upPart">
   <a href="index.php" class="up" id="logo">TRAVELINGO</a>
   <a href="my.php" class="up"> my</a>
   <a href="kierunki.php" class="up">kierunki</a>
   <a href="pomoc.php" class="up"><b>pomoc </b></a>
   <a href="travelFam.php" class="up">travelFam </a>
   <a href="konto.php" class="up" id="konto">konto </a>
</div>
<div id="mainPart">
<div class="first">
<img id="img" src="busPomoc2.jpg">

<h4 class="p4"> Jak Wrocić bilet?</h4><br><br>
<h3>W przypadku rezygnacji z podróży z inicjatywy Pasażera, zostaną mu zwrócone koszty podróży z potrąceniem następujących opłat:</h3>
  <ul>
<li>Jeśli bilet zostanie zwrócony później niż 30 dni, zwrócone zostanie 80% ceny biletu.</li>
<li>Jeśli bilet zostanie zwrócony w ciągu 30 do 15 dni, zwrócone zostanie 70% ceny biletu. </li>
<li>Jeśli bilet zostanie zwrócony w ciągu 15 do 3 dni, zwrócone zostanie 60% ceny biletu.</li>
<li>Jeśli bilet zostanie zwrócony w ciągu 3 do 1 dni, zwrócone zostanie 50% ceny biletu.</li></ul>
</div>

<div class="second">
<img class="img2" src="busPomoc4.jpg">

<h4 class="p4Second">Przystanki</h4><br><br>
<h3 class="h3second">Autobus zatrzymuje się na przystankach technicznych co 4-4,30 godziny. Czas trwania postojów ogłasza kierowca. Spóźniony pasażer SAMODZIELNIE kontynuuje podróż bez rekompensaty za przejazd! Ponadto autobus nie czeka na pasażera, jeśli ma on trudności na granicy.</h3>
</div>


<div class="first">
<img id="img" src="busPomoc3.jpg">
<h4 class="p4"> Jak Wrocić bilet?</h4><br><br>
<h3 class="h3first">Pasażer ma obowiązek obchodzić się z wyposażeniem autobusu ostrożnie i unikać jego uszkodzenia.
Picie napojów alkoholowych i palenie we wnętrzu autobusu oraz w toalecie jest BEZWZGLĘDNIE ZABRONIONE! 
Śmieci należy umieszczać w osobnych workach i wrzucać do koszy na śmieci znajdujących się na parkingach.
Za szkody wyrządzone w pojeździe odpowiada pasażer.
Półki nad siedzeniami przeznaczone są wyłącznie na mały bagaż podręczny.</h3>

</div>

<div class="second">
<img class="img2" src="buspomoc.jpg">

<h4 class="p4Second">WYPOSAŻENIE TECHNICZNE AUTOBUSU</h4><br><br>
<h3 class="h3second">Informujemy, że w serwisie sprzedawane są bilety na loty różnych przewoźników, dlatego środki transportu mogą się różnić i są przydzielane przez samych przewoźników.
Jeżeli siedzenia w autobusie odchylają się, podczas postojów należy je przywrócić do pierwotnego położenia.
 Wizyta w suchej szafie w autobusie nie jest zapewniona.</h3>
</div>





  <h1> W czym możemy ci pomoc?</h1>
    <form id="formPomoc" method="post" action="pomoc.php">
        E-mail:<input id="inpPomoc"type="text" name="email" ><br>
        <textarea name="question" placeholder="TREŚĆ TWOJEGO PYTANIA"></textarea><br>
        <input id="inputPomoc"type="submit" value="WYŚLIJ">
    </form>
    <div id="message"></div>
    <?php

require_once "connect.php";
$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['question'])) {
        $email = $_POST['email'];
        $question = $_POST['question'];
        
        if (!empty($email) && !empty($question)) {
            $sql = "SELECT * FROM uzytkownicy WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $sql = "INSERT INTO pytania (tresc_pytania, email_odprawiciela) VALUES ('$question', '$email')";

                if ($conn->query($sql) === TRUE) {
                    echo "Twoje pytanie jest wysłane!<br> Dziękujemy za korzystanie z naszego komunikatu";
                } else {
                    echo "Błąd: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Niestety nie mamy takiego emaila w naszej bazie. <br> <a href='rejestracja.php' style='color:darkblue;'> <b>ZAŁÓŻ KONTO </b></a>";
            }
        } else {
            echo "Wpisz poprawne dane";
        }
    } else {
        echo "Brak danych";
    }
}
?>


</div>
<div id="downPart">
    <h4> Pobierz naszą aplikację! </h4><br>
    <div id="applikacje">  
        <a href="https://play.google.com/store/account">  
            <img id="google" src="googleplay.png" >  
        </a>
        <a href="https://www.apple.com/pl/app-store/"> 
            <img id="app" src="app.png"> 
        </a>  
    </div>
    <h4>Znajdź nas:</h4> <br>
    <div id="logos">
        <a href="https://www.instagram.com/"><img class="img" src="inst.jpg"></a>
        <a href="https://www.tiktok.com/"><img class="img" src="tt.jpg"></a>
        <a href="https://m.youtube.com/?gl=PL&hl=pl"><img class="img" src="yt.jpg"></a>
        <a href="https://web.whatsapp.com/"><img class="img" src="wa.jpg"></a>
        <a href="https://web.telegram.org/"><img class="img" src="tg.jpg"></a>
        <a href="https://twitter.com/?lang=pl"><img class="img" src="tw.jpg"><br></a>
    </div>
</div>
</body>
</html>
