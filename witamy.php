<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: konto.php");
}
require_once "connect.php";
$conn = new mysqli($host, $db_user, $db_password, $db_name);

if (isset($_SESSION['ticket_id'])) {
    $id_uzytkownika = $_SESSION['id'];
    $id_biletu = $_SESSION['ticket_id'];

    $sql = "UPDATE uzytkownicy SET id_akt_podrozy = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_biletu, $id_uzytkownika); //Wiąże parametry zapytania SQL z wartościami zmiennych. Litery "ii" wskazują, że oba parametry są liczbami całkowitymi.
    $stmt->execute(); //Wykonuje zapytanie SQL na serwerze bazy danych, aktualizując odpowiedni rekord.
    $stmt->close();
}

$sql = "SELECT * FROM `Uzytkownicy` WHERE `id` = {$_SESSION['id']} LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $uzytkownik = $result->fetch_assoc();
    $actualTicketId = $uzytkownik['id_akt_podrozy'];

    if($actualTicketId) { // not null
        $sql = "SELECT * FROM `Kierunki` WHERE `id` = {$actualTicketId} LIMIT 1";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $currentTrip = $result->fetch_assoc();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleWitamy.css">
</head>

<body>
    <div id="upPart">
        <a href="index.php" class="up" id="logo">TRAVELINGO</a>
        <a href="my.php" class="up">my</a>
        <a href="kierunki.php" class="up">kierunki</a>
        <a href="pomoc.php" class="up">pomoc </a>
        <a href="travelFam.php" class="up">travelFam </a>
        <a href="#" class="up" id="konto" onclick="document.getElementById('wyloguj-form').submit()"><b>Wyloguj<b></a> 
    </div>

    <form action='wyloguj.php' method='post' id="wyloguj-form" style="display:none"></form>
    <div id="mainPart">
        <?php
        if (isset($_SESSION['username'])) {
            echo "<h1>Witamy, " . $_SESSION['username'] . "</h1><br>";
        }

        if (isset($currentTrip)) {
            echo "<h2>Szczegóły biletu:</h2>";
            echo "<p>Kierunek: {$currentTrip['punkt_od']} - {$currentTrip['punkt_do']}</p>";
            echo "<p>Cena: {$currentTrip['cena']}zł</p>";
            echo "<br>";
            echo "<p>Nie zapomnij zabrać ze sobą dokumentów i pieniędzy!</p>";
            echo "<p>Życzymy udanej podróży!</p>";
        } else {
            echo "<p>Jeszcze nie masz biletów. <a id='a' href='kierunki.php'>Wybierz</a> swój kierunek</p>";
        }
    
        if (isset($_POST['delete_cv'])) { 
            $cv_id = $_POST['cv_id']; 
            $sql_get_email = "SELECT email FROM cv WHERE id = ?"; 
            $stmt_get_email = $conn->prepare($sql_get_email); 
            $stmt_get_email->bind_param("i", $cv_id); // jest liczbą całkowitą (integer) i jest przekazywany jako parametr zapytania SQL. 
            $stmt_get_email->execute(); 
            $result_email = $stmt_get_email->get_result(); // pobiera wynik z wykonanego zapytania SQL. W tym przypadku, jeśli zapytanie zwraca jakieś wyniki, będą one dostępne w zmiennej $result_email
            $row_email = $result_email->fetch_assoc(); 
            $email = $row_email['email']; 
 
            $sql_delete_cv = "DELETE FROM cv WHERE id = ?"; 
            $stmt_delete_cv = $conn->prepare($sql_delete_cv); 
            $stmt_delete_cv->bind_param("i", $cv_id); 
            $stmt_delete_cv->execute(); 
 
            
            if ($stmt_delete_cv->affected_rows > 0) { 
                if (isset($_POST['change_role']) && $_POST['change_role'] == 'true') { 
                    $sql_update_role = "UPDATE uzytkownicy SET rola = 'admin' WHERE email = ?"; 
                    $stmt_update_role = $conn->prepare($sql_update_role); 
                    $stmt_update_role->bind_param("s", $email); //przekazana jako wartość tego parametru w zapytaniu SQL.
                    $stmt_update_role->execute(); 
                } 
 
                echo "<script>alert('CV jest usunięte" . (isset($_POST['change_role']) && $_POST['change_role'] == 'true' ? ", osoba została administratorem" : "") . "');</script>"; 
                echo "<script>window.location = 'witamy.php';</script>"; 
            } else { 
                echo "<script>alert('Błąd');</script>"; 
                echo "<script>window.location = 'witamy.php';</script>"; 
            } 
        } 
 
        if (isset($_SESSION['id'])) { 
            $id_uzytkownika = $_SESSION['id']; 
 
            $sql_user = "SELECT * FROM uzytkownicy WHERE id = ?"; 
            $stmt_user = $conn->prepare($sql_user); 
            $stmt_user->bind_param("i", $id_uzytkownika); 
            $stmt_user->execute(); 
            $result_user = $stmt_user->get_result(); 
            $row_user = $result_user->fetch_assoc(); 
 
            if ($row_user['rola'] == 'admin') { 
            
                
                $sql_kierunki = "SELECT kierunki.punkt_od, kierunki.punkt_do, autobusy.numer, kierunki.cena, kierunki.czas, COUNT(uzytkownicy.id) AS ilosc_passenger
                                 FROM kierunki
                                 JOIN autobusy ON kierunki.id_autobusa = autobusy.id
                                 LEFT JOIN uzytkownicy ON kierunki.id = uzytkownicy.id_akt_podrozy
                                 GROUP BY kierunki.id
                                 ORDER BY cena ASC";
                $result_kierunki = $conn->query($sql_kierunki);
                
                echo "<h3>Wszystkie kierunki:</h3>";
                echo "<table>";
                echo "<tr><th>Od</th><th>Do</th><th>aut</th><th>Cena</th><th>Czas</th><th>Ilość</th></tr>";
                while ($row_kierunki = $result_kierunki->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_kierunki['punkt_od'] . "</td>";
                    echo "<td>" . $row_kierunki['punkt_do'] . "</td>";
                    echo "<td>" . $row_kierunki['numer'] . "</td>";
                    echo "<td>" . $row_kierunki['cena'] . "</td>";
                    echo "<td>" . $row_kierunki['czas'] . "</td>";
                    if ($row_kierunki['ilosc_passenger'] == 0) {
                        echo "<td style='color: white; background-color:red;'>" . $row_kierunki['ilosc_passenger'] . "</td>"; 
                    } else {
                        echo "<td>" . $row_kierunki['ilosc_passenger'] . "</td>"; 
                    }
                    echo "</tr>";
                }
                echo "</table>";
             
                
            
                


                $sql_pytania = "SELECT * FROM pytania"; 
                $result_pytania = $conn->query($sql_pytania); 
 
                echo "<h3>Wszystkie pytania:</h3>"; 
                echo "<table id='table2' >"; 
                echo "<tr><th>Email odprawiciela</th><th id='pytTH'>Tresc pytania</th></tr>"; 
                while ($row_pytania = $result_pytania->fetch_assoc()) { 
                    echo "<tr>"; 
                    echo "<td>" . $row_pytania['email_odprawiciela'] . "</td>"; 
                    echo "<td>" . $row_pytania['tresc_pytania'] . "</td>"; 
                    echo "</tr>"; 
                } 
                echo "</table>"; 
 
 
        $sql_users = "SELECT uzytkownicy.login, uzytkownicy.email, uzytkownicy.rola, 
        uzytkownicy.id_akt_podrozy, kierunki.punkt_od, kierunki.punkt_do
        FROM uzytkownicy
        JOIN kierunki 
        ON uzytkownicy.id_akt_podrozy=kierunki.id"; 
        $result_users = $conn->query($sql_users); 
 
        echo "<h3>Wszyscy użytkownicy:</h3>"; 
        echo "<table id='table3' >"; 
        echo "<tr><th>Login</th><th>Email</th><th>Rola</th><th>OD</th><th>DO</th></tr>"; 
        while ($row_user = $result_users->fetch_assoc()) { 
            echo "<tr>"; 
            echo "<td>" . $row_user['login'] . "</td>"; 
            echo "<td>" . $row_user['email'] . "</td>"; 
            echo "<td>" . $row_user['rola'] . "</td>"; 
            echo "<td>" . $row_user['punkt_od']."</td>";
            echo "<td>" . $row_user['punkt_do']. "</td>"  . "</td>"; 
            echo "</tr>"; 
        } 
        echo "</table>"; 
 
        $sql_autobusy = "SELECT autobusy.numer, kierunki.punkt_od, kierunki.punkt_do, kierunki.czas 
        FROM autobusy 
        JOIN kierunki ON kierunki.id=autobusy.id_kierunka"; 
        $result_autobusy = $conn->query($sql_autobusy); 
 
        echo "<h3>Wszystkie autobusy:</h3>"; 
        echo "<table id='table4'>"; 
        echo "<tr><th>Numer autobusu</th><th>Od</th><th>Do</th><th>Czas</th></tr>"; 
        while ($row_autobus = $result_autobusy->fetch_assoc()) { 
            echo "<tr>"; 
            echo "<td>" . $row_autobus['numer'] . "</td>"; 
            echo "<td>" . $row_autobus['punkt_od'] . "</td>"; 
            echo "<td>" . $row_autobus['punkt_do'] . "</td>"; 
            echo "<td>" . $row_autobus['czas'] . "</td>"; 
            echo "</tr>"; 
        } 
        echo "</table>"; 


                $sql_cv = "SELECT * FROM cv"; 
                $result_cv = $conn->query($sql_cv); 
 
                echo "<h3>Wszystkie CV:</h3>"; 
                echo "<table id='table5'>"; 
                echo "<tr><th>Email</th><th>Umiejętności</th><th>Doświadczenie</th><th>Wiek</th><th>Poziom angielskiego</th><th>Edukacja</th></tr>"; 
                while ($row_cv = $result_cv->fetch_assoc()) { 
                    echo "<tr>"; 
                    echo "<td>" . $row_cv['email'] . "</td>"; 
                    echo "<td>" . $row_cv['umiejetnosci'] . "</td>"; 
                    echo "<td>" . $row_cv['doswiadczenie'] . "</td>"; 
                    echo "<td>" . $row_cv['wiek'] . "</td>"; 
                    echo "<td>" . $row_cv['poziom_angielskiego'] . "</td>"; 
                    echo "<td>" . $row_cv['edukacja'] . "</td>"; 
                    echo "<td id='idZATR'>"; 
                    echo "<form method='post'>"; 
                    echo "<input type='hidden' name='cv_id' value='" . $row_cv['id'] . "'>"; 
                    echo "<input type='hidden' name='change_role' value='true'>"; 
                    echo "<input type='submit' name='delete_cv' id='zatr' value='zatrudnić'>"; 
                    echo "</form>"; 
                    echo "<form method='post'>"; 
                    echo "<input type='hidden' name='cv_id' value='" . $row_cv['id'] . "'>"; 
                    echo "<input type='hidden' name='change_role' value='false'>"; 
                    echo "<input type='submit' name='delete_cv' id='us' value='usunąć'>"; 
                    echo "</form>"; 
                    echo "</td>"; 
                    echo "</tr>"; 
                } 
                echo "</table></br>"; 
            } 
        }
 
        $conn->close(); 
        ?> 

    </div>
</body>

</html>
