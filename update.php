<?php
require_once 'config.php';

try {
	// Request Id to update
	if (isset($_GET['id'])) {
	
		$id = $_GET['id'];

		// Preparing statement
    	$stmt = $conn->prepare(
			"SELECT * FROM patient as p
			JOIN befund as b
			ON p.idPatient = b.Patient_id
			JOIN termin as t
			ON b.Termin_terID = t.terID
			WHERE idPatient = :id"
		);
		// Binding parameter to value
		$stmt->bindParam(':id', $id);
		// Executing statement
    	$stmt->execute();
		// Declaring and initializing variable to result
    	$patient = $stmt->fetch();
	}
} 
catch (Exception $e) {
    echo 'Fehler beim Abrufen des Benutzers: ' . $e->getMessage();
}
?>

<!doctype html>
<html data-bs-theme="dark">
	<head>
		<?php include 'components/head.php' ?>
	</head>
	<header>
		<?php include 'components/nav.php' ?>
	</header>
	<body>
		<h1>Bearbeiten</h1>
		<form action="actions/update-patient.php" method="post">
			<input type="hidden" id="id" name="id" value="<?php echo $patient["idPatient"]; ?>">
			<div class="input-group w-25">
				<span class="input-group-text">Vor- und Nachname</span>
				<input type="text" aria-label="First name" class="form-control" id="vorname" name="vorname" value="<?php echo $patient["vorname"]; ?>" required>
				<input type="text" aria-label="Last name" class="form-control" id="nachname" name="nachname" value="<?php echo $patient["nachname"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Geburtstag</span>
				<input type="date" aria-label="Geburtstag" class="form-control" id="geburtstag" name="geburtstag" value="<?php echo $patient["geburtstag"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">SVNR</span>
				<input type="number" aria-label="SVNR" class="form-control" id="svnr" name="svnr" value="<?php echo $patient["svnr"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Beschwerde</span>
				<input type="text" aria-label="Beschwerde" class="form-control" id="beschreibung" name="beschreibung" value="<?php echo $patient["beschreibung"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Termin</span>
				<input type="datetime-local" aria-label="Termin" class="form-control" id="datum" name="datum" value="<?php echo $patient["datum"]; ?>" required>
			</div>
			<br>
			<button type="submit" class="btn btn-primary">Absenden</button>
		</form>
		<br>
		<form action="" method="get">
			<input type="hidden" id="id" name="id" value="<?php echo $patient["idPatient"]; ?>">
			<a type="submit" href="actions/delete-patient.php?id=<?php echo $patient['idPatient'] ?>" class="btn btn-danger">Löschen</a>
		</form>
	</body>
</html>