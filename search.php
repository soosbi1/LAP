<?php
require_once 'config.php';

try {
	// If filter request
	if (isset($_GET['search'])) {
		
		// Neither exact nor case sensitive 
		$search = '%' . $_GET['search'] . '%';
		$search = strtolower($search);
		
		// Preparing select statement considering filter
		$stmt = $conn->prepare("
			SELECT p.*, b.beschreibung, t.datum
			FROM patient p
			JOIN befund b ON p.idPatient = b.befID
			JOIN termin t ON b.Termin_terID = t.terID
			WHERE LOWER(p.vorname) LIKE :search
			OR LOWER(p.nachname) LIKE :search"
		);
		// Binding param to value
		$stmt->bindParam(':search', $search);
	}
	else {
		// Preparing select statement
		$stmt = $conn->prepare("
			SELECT p.*, b.beschreibung, t.datum
			FROM patient p
			JOIN befund b ON p.idPatient = b.befID
			JOIN termin t ON b.Termin_terID = t.terID"
		);
	}
	// Executing either filtered or unfiltered statement
	$stmt->execute();
	// Fetching results
	$patients = $stmt->fetchAll();
} catch (PDOException $e) {
	echo "Datenbankfehler: " . $e->getMessage();
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
		<h1>Suche</h1>
		<div class="container mt-5">
			<?php 
			session_start();

			// Check if there is a message in the session
			if (isset($_SESSION['message'])) {
				// Output the message
				echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";

				// Unset the message so it doesn't show again
				unset($_SESSION['message']);
			}
			?>
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