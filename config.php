<?php

include ("connection.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//    echo "Initial character set is: " . $conn -> character_set_name();
$conn -> set_charset("utf8");
//    echo "Current character set is: " . $conn -> character_set_name();


$sql = "SELECT oblast.nazov AS \"Oblast\", utvary.nazov, osoby.meno AS \"Ministerstvo\", osoby.datumOD,
            osoby.datumDO, DATEDIFF(osoby.datumDO, osoby.datumOD) AS \"Pocet dni pri svojej funkcii\" 
            FROM utvary, osoby, oblast 
            WHERE (osoby.id_utvary = utvary.id AND instr(utvary.nazov, oblast.skratka))";
$result = $conn->query($sql);

function WriteLineTable($row){
    echo "<tr><td>" .
        $row["Oblast"]. "</td><td> ".
        $row["nazov"] . "</td><td>" .
        $row["Ministerstvo"] . "</td><td>" .
        $row["datumOD"]. "</td><td>".
        $row["datumDO"] ."</td><td>".
        $row["Pocet dni pri svojej funkcii"]. "</td></tr>";
}

if ($result->num_rows > 0) {
    // table start
    echo "";
    echo "<input type=\"text\" id=\"myInput\" 
            onkeyup=\"myFunction()\" placeholder=\"Vyhladavanie podla oblasti..\" 
            title=\"Type in a name\">";
    echo "<table id='myTable'>";
    echo "      
                <tr class=\"header\">
                <th onclick>Oblast</th> 
                <th onclick>Ministerstvo</th> 
                <th onclick>Meno ministra</th>
                <th onclick>Datum OD</th>
                <th onclick>Datum DO</th>
                <th onclick>Pocet dni vo funkcii</th>
              </tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        WriteLineTable($row);
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
