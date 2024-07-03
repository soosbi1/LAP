<?php
require_once '../config.php';

try {
    // Requesting variable from submitted form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $geburtstag = $_POST['geburtstag'];
        $svnr = $_POST['svnr'];
        $beschreibung = $_POST['beschreibung'];
        $datum = $_POST['datum'];

        // Starting transaction for multiple statements
        $conn->beginTransaction();

        // Insert into patient table
        $stmt = $conn->prepare("INSERT INTO patient (vorname, nachname, geburtstag, svnr, Sozialversicherung_sozID, Arztpraxis_idArztpraxis) 
                                VALUES (:vorname, :nachname, :geburtstag, :svnr, 1, 1)");
        // Binding params to values
        $stmt->bindParam(':vorname', $vorname);
        $stmt->bindParam(':nachname', $nachname);
        $stmt->bindParam(':geburtstag', $geburtstag);
        $stmt->bindParam(':svnr', $svnr);
        // Executing statement
        $stmt->execute();

        $patient_id = $conn->lastInsertId();

        // Insert into termin table
        $stmt = $conn->prepare("INSERT INTO termin (datum) VALUES (:datum)");
        // Binding param to value
        $stmt->bindParam(':datum', $datum);
        // Executing statement
        $stmt->execute();
        
        $termin_id = $conn->lastInsertId();

        // Insert into befund table
        $stmt = $conn->prepare("INSERT INTO befund (beschreibung, Patient_id, Termin_terID) VALUES (:beschreibung, :patient_id, :termin_id)");
        // Binding params to values
        $stmt->bindParam(':beschreibung', $beschreibung);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':termin_id', $termin_id);
        // Executing statement
        $stmt->execute();
        
        // Commit the transaction
        $conn->commit();

        // Starting session
        session_start();
        // Setting session variable
        $_SESSION['message'] = 'Patient angelegt!';

        // Setting location
		header('Location: ../search.php');
    }
}
catch (PDOException $e) {
    echo "Datenbankfehler: ". $e->getMessage();
}