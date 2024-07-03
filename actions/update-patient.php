<?php
require_once '../config.php';
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
		$vorname = $_POST['vorname'];
		$nachname = $_POST['nachname'];
		$geburtstag = $_POST['geburtstag'];
		$svnr = $_POST['svnr'];
		$beschreibung = $_POST['beschreibung'];
		$datum = $_POST['datum'];

        $conn->beginTransaction();

    	// update patient table
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
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':vorname', $vorname);
        $stmt->bindParam(':nachname', $nachname);
        $stmt->bindParam(':geburtstag', $geburtstag);
        $stmt->bindParam(':svnr', $svnr);
        $stmt->bindParam(':beschreibung', $beschreibung);
        $stmt->bindParam(':datum', $datum);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();

		session_start();
		$_SESSION['message'] = 'Patient aktualisiert!';

		header('Location: ../search.php');
    }
}
catch (PDOException $e) {
    echo "Datenbankfehler: ". $e->getMessage();
}