<?php
require_once '../config.php';
try {
    // Request Id to delete
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Starting transaction for multiple statements
        $conn->beginTransaction();

    	// Delete from patient table
        $stmt = $conn->prepare("DELETE bhm
                                FROM befund_has_medikament as bhm
                                JOIN Befund as b ON bhm.Befund_befID = b.befID
                                WHERE b.Patient_id = :id");
        // Binding param to value
        $stmt->bindParam(':id', $id);
        // Executing statement in transaction
        $stmt->execute();

        // Delete from patient table
        $stmt = $conn->prepare("DELETE FROM Befund
                                WHERE Patient_id = :id");
        // Binding param to value
        $stmt->bindParam(':id', $id);
        // Executing statement in transaction
        $stmt->execute();

        // Delete from patient table
        $stmt = $conn->prepare("DELETE FROM Patient
                                WHERE idPatient = :id");
        // Binding param to value
        $stmt->bindParam(':id', $id);
        // Executing statement in transaction
        $stmt->execute();
        
        
        // Commit the transaction
        $conn->commit();
        
        // Starting session
        session_start();
        // Setting session variable
		$_SESSION['message'] = 'Patient gelöscht!';

        // Setting location
		header('Location: ../search.php');
    }
}
catch (PDOException $e) {
    echo "Datenbankfehler: ". $e->getMessage();
}