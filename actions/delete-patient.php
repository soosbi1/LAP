<?php
require_once '../config.php';
try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn->beginTransaction();

    	// Delete from patient table
        $stmt = $conn->prepare("DELETE bhm
                                FROM befund_has_medikament as bhm
                                JOIN Befund as b ON bhm.Befund_befID = b.befID
                                WHERE b.Patient_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Delete from patient table
        $stmt = $conn->prepare("DELETE FROM Befund
                                WHERE Patient_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Delete from patient table
        $stmt = $conn->prepare("DELETE FROM Patient
                                WHERE idPatient = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        
        // Commit the transaction
        $conn->commit();
        
        session_start();
		$_SESSION['message'] = 'Patient gelöscht!';

		header('Location: ../search.php');
    }
}
catch (PDOException $e) {
    echo "Datenbankfehler: ". $e->getMessage();
}