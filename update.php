<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    echo 'Benutzer-ID nicht gefunden!';
    exit;
}

$id = $_GET['id'];

try {
    $sql = 'SELECT * FROM patient as p
	JOIN befund as b
	ON p.idPatient = b.Patient_id
	JOIN termin as t
	ON b.Termin_terID = t.terID
	WHERE idPatient = :id';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $patient = $stmt->fetch();
} catch (Exception $e) {
    echo 'Fehler beim Abrufen des Benutzers: ' . $e->getMessage();
}
?>

<!doctype html>
<html data-bs-theme="dark">
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<header>
		<?php
		include("nav.php");
		?>
	</header>
	<body>
		<h1>Bearbeiten</h1>
		<form action="" method="get">
			<div class="input-group w-25">
				<span class="input-group-text">Vor- und Nachname</span>
				<input type="text" aria-label="First name" class="form-control" id="vorname" name="vorname" value="<?php echo $patient["vorname"]; ?>" required>
				<input type="text" aria-label="Last name" class="form-control" id="nachname" name="nachname" value="<?php echo $patient["nachname"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Geburtstag</span>
				<input type="text" aria-label="Geburtstag" class="form-control" id="geburtstag" name="geburtstag" value="<?php echo $patient["geburtstag"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">SVNR</span>
				<input type="text" aria-label="SVNR" class="form-control" id="svnr" name="svnr" value="<?php echo $patient["svnr"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Beschwerde</span>
				<input type="text" aria-label="Beschwerde" class="form-control" id="beschreibung" name="beschreibung" value="<?php echo $patient["beschreibung"]; ?>" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Termin</span>
				<input type="text" aria-label="Termin" class="form-control" id="datum" name="datum" value="<?php echo $patient["datum"]; ?>" required>
			</div>
			<br>
			<a type="submit" href="update-user.php" class="btn btn-primary">Absenden</a>
		</form>
	</body>
</html>