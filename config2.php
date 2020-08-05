<?php

include ("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// change utf to make sure that SK language will ok on web
$conn -> set_charset("utf8");

function writeTableLine2($row){
    echo "<tr><td>" .
        $row["nazov"]. "</td><td> ".
        $row["skratka"] . "</td><td>" .
        $row["kresla"] . "</td><td>" .
        $row["koalicia"]. "</td></tr>";
}
function writeTableLine3($row){
    echo "<tr><td>" .
        $row["Id"]. "</td><td> ".
        $row["Datum OD"] . "</td><td>" .
        $row["Datum DO"] . "</td></tr>";
}

//table for volby
$sql = "SELECT volby.den1 FROM volby";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<form action=\"\" method=\"POST\">
            <input list=\"volby\" name=\"volby\" type = 'text'>
            <datalist id=\"volby\">
            <select>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=$row[den1]>";
    }
    echo "</select></datalist>
            <input type=\"submit\" name='submit' value='Get submit'>
            </form>";
} else {
    echo "0 results";
}
if(isset($_POST["volby"]) != null){
    $selected_val = $_POST["volby"];  // Storing Selected Value In Variable
//    echo "<br>You have selected :" .$selected_val . "<br><br>";  // Displaying Selected Value
    echo "<br>";
    tableVolby($conn, $selected_val);
    tableVolbySum($conn, $selected_val);
    tableVladyVolby($conn, $selected_val);
}
$result->free();

//table for volby by selected value
function tableVolby($conn ,$selected_val){
    $sql = "SELECT strany.nazov as nazov, strany.skratka as skratka, vysledky.kresla as kresla, 
                vysledky.koalicia as koalicia
                FROM strany, vysledky, volby WHERE ((strany.id = vysledky.id_strany) 
                                                AND (vysledky.id_volby = volby.id))
                AND(volby.den1 = '$selected_val')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table id='myTable'>";
        echo "      
                <tr class=\"header\">
                <th onclick>Nazov</th> 
                <th onclick>Skratka</th> 
                <th onclick>Kresla</th>
                <th onclick>Koalicia</th>
              </tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            writeTableLine2($row);
        }
        echo "</table><br>";
    }
//        else {
//            echo "0 results";
//        }
    $result->free();
}

function tableVolbySum($conn, $selected_val){
    $sql1 = "SELECT sum(kresla) as kresla_koalicie FROM 
                (SELECT strany.nazov, strany.skratka, vysledky.kresla as kresla, vysledky.koalicia 
                FROM strany, vysledky, volby WHERE ((strany.id = vysledky.id_strany)
                                                AND (vysledky.id_volby = volby.id))
                AND(volby.den1 = '$selected_val')) as tabulka WHERE koalicia = '1'";
    $result = $conn->query($sql1);

    if ($result->num_rows > 0) {
        echo "<table id='myTable2'>";
        echo "
                    <tr class=\"header\">
                    <th>Kresla Koalicie</th>
                  </tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" .
                $row["kresla_koalicie"]. "</td></tr>";
        }
        echo "</table><br>";
    }
    $result->free();
}

function tableVladyVolby($conn, $selected_val){
    $sql = "SELECT vlady.id as 'Id', vlady.datumOD as 'Datum OD', vlady.datumDO as 'Datum DO'
                FROM vlady
                WHERE vlady.id_volby = (SELECT volby.id from volby WHERE volby.den1 = '$selected_val')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table id='myTable'>";
        echo "      
                    <tr class=\"header\">
                    <th onclick>Id</th> 
                    <th onclick>Datum OD</th> 
                    <th onclick>Datum DO</th>
                  </tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            writeTableLine3($row);
        }
        echo "</table><br>";
    }
    $result->free();
}
