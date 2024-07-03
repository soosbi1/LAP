<?php
require_once '../config.php';
try {
    // Requesting variable from submitted form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
		$vorname = $_POST['vorname'];
		$nachname = $_POST['nachname'];
		$geburtstag = $_POST['geburtstag'];
		$svnr = $_POST['svnr'];
		$beschreibung = $_POST['beschreibung'];
		$datum = $_POST['datum'];

		// Starting transaction for multiple statements
        $conn->beginTransaction();

    	// Update patient table
        $stmt = $conn->prepare("UPDATE patient as p
								JOIN befund as b ON p.idPatient = b.Patient_id
								JOIN termin as t ON b.Termin_terID = t.terID 
								SET
								p.vorname = :vorname,
								p.nachname = :nachname,
								p.geburtstag = :geburtstag,
								p.svnr = :svnr,
								b.beschreibung = :beschreibung,
								t.datum = :datum,
								Sozialversicherung_sozID = 1,
								Arztpraxis_idArztpraxis = 1
								WHERE idPatient = :id");
		// Binding params to values
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':vorname', $vorname);
        $stmt->bindParam(':nachname', $nachname);
        $stmt->bindParam(':geburtstag', $geburtstag);
        $stmt->bindParam(':svnr', $svnr);
        $stmt->bindParam(':beschreibung', $beschreibung);
        $stmt->bindParam(':datum', $datum);
		// Executing statement
        $stmt->execute();

        // Commit the transaction
        $conn->commit();

		// Starting session
        session_start();
        // Setting session variable
		$_SESSION['message'] = 'Patient aktualisiert!';

		// Setting location
		header('Location: ../search.php');
    }
}
catch (PDOException $e) {
    echo "Datenbankfehler: ". $e->getMessage();
}