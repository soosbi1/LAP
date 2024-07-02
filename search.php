<?php
require_once 'config.php';

try {
	if (isset($_GET['search'])) {
		
		$search = '%' . $_GET['search'] . '%';
		$search = strtolower($search);

		$stmt = $conn->prepare("
			SELECT p.*, b.beschreibung, t.datum
			FROM patient p
			JOIN befund b ON p.idPatient = b.befID
			JOIN termin t ON b.Termin_terID = t.terID
			WHERE LOWER(p.vorname) LIKE :search
			OR LOWER(p.nachname) LIKE :search"
		);
		$stmt->bindParam(':search', $search);
	}
	else {
		$stmt = $conn->prepare("
			SELECT p.*, b.beschreibung, t.datum
			FROM patient p
			JOIN befund b ON p.idPatient = b.befID
			JOIN termin t ON b.Termin_terID = t.terID"
		);
	}
	$stmt->execute();
	$patients = $stmt->fetchAll();
} catch (PDOException $e) {
	echo "<div class='alert alert-danger mt-3'>Datenbankfehler: " . $e->getMessage() . "</div>";
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
		<h1>Suche</h1>
		<div class="container mt-5">
			<h2>Patienten abfragen</h2>
			<form action="" method="get">
				<div class="form-group">
					<label for="search">Suche nach Vorname oder Nachname:</label>
					<input type="text" class="form-control" id="search" name="search" required>
				</div>
				<button type="submit" class="btn btn-primary">Suchen</button>
			</form>
			<h3>Gefundene Patienten:</h3>
			<div class='table-responsive'>
				<table class='table table-bordered'>
					<thead class='thead-dark'>
						<tr>
							<td>Vorname</td>
							<td>Nachname</td>
							<td>Geburtstag</td>
							<td>SVNR</td>
							<td>Beschwerde</td>
							<td>Termin</td>
							<td>Aktion</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($patients as $patient): ?>
							<tr>
								<td><?php echo $patient['vorname']; ?></td>
								<td><?php echo $patient['nachname']; ?></td>
								<td><?php echo $patient['geburtstag']; ?></td>
								<td><?php echo $patient['svnr']; ?></td>
								<td><?php echo $patient['beschreibung']; ?></td>
								<td><?php echo $patient['datum']; ?></td>
								<td>
									<a href="update.php?id=<?php echo $patient['idPatient']; ?>" class="btn btn-primary">Bearbeiten</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>	
			</div>
		</div>
	</body>
</html>