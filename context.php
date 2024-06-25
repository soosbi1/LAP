<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patientenverwaltung";
	function open() {
		global $servername, $username, $password, $dbname;
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//bei Bedarf anzeigen lassen
			//echo "Connected successfully";
		} 
		catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
		return $conn;
	}
	function search() {
		$conn = open();
		try {
			if (isset($_GET['search'])) {
				// Suchparameter abrufen
				$search = '%' . $_GET['search'] . '%';
				$search = strtolower($search);

				// Prepared Statement für sichere Abfrage
				$stmt = $conn->prepare("
					SELECT p.*, b.beschreibung, t.datum
					FROM patient p
					JOIN befund b ON p.idPatient = b.befID
					JOIN termin t ON b.Termin_terID = t.terID
					WHERE LOWER(p.vorname) LIKE :search
					OR LOWER(p.nachname) LIKE :search"
				);
				$stmt->bindParam(':search', $search);
				$stmt->execute();
			}
			else {
				$stmt = $conn->prepare("
					SELECT p.*, b.beschreibung, t.datum
					FROM patient p
					JOIN befund b ON p.idPatient = b.befID
					JOIN termin t ON b.Termin_terID = t.terID"
				);
				$stmt->execute();
			}
			if ($stmt->rowCount() > 0) {
				echo "<h3>Gefundene Patienten:</h3>";
				echo "<div class='table-responsive'>";
				echo "<table class='table table-bordered'>";
				echo "<thead class='thead-dark'>";
				echo "<tr>";
				echo "<th>Vorname</th>";
				echo "<th>Nachname</th>";
				echo "<th>Geburtstag</th>";
				echo "<th>SVNR</th>";
				echo "<th>Beschwerde</th>";
				echo "<th>Termin</th>";
				echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "<tr>";
					echo "<td>{$row['vorname']}</td>";
					echo "<td>{$row['nachname']}</td>";
					echo "<td>{$row['geburtstag']}</td>";
					echo "<td>{$row['svnr']}</td>";
					echo "<td>{$row['beschreibung']}</td>";
					echo "<td>{$row['datum']}</td>";
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
			} else {
				echo "<div class='alert alert-info mt-3'>Keine Patienten gefunden.</div>";
			}
		} catch (PDOException $e) {
			echo "<div class='alert alert-danger mt-3'>Datenbankfehler: " . $e->getMessage() . "</div>";
		}
		finally{
			$conn = null;
		}
	}
	function insert() {
		$conn = open();
		try {
			if (isset($_GET['vorname'])) {
				$vorname = $_GET['vorname'];
				$nachname = $_GET['nachname'];
				$geburtstag = $_GET['geburtstag'];
				$svnr = $_GET['svnr'];
				$beschreibung = $_GET['beschreibung'];
				$datum = $_GET['datum'];

				$conn->beginTransaction();

				// Insert into patient table
				$stmt = $conn->prepare("INSERT INTO patient (vorname, nachname, geburtstag, svnr, Sozialversicherung_sozID, Arztpraxis_idArztpraxis) 
										VALUES (:vorname, :nachname, :geburtstag, :svnr, 1, 1)");
				$stmt->bindParam(':vorname', $vorname);
				$stmt->bindParam(':nachname', $nachname);
				$stmt->bindParam(':geburtstag', $geburtstag);
				$stmt->bindParam(':svnr', $svnr);
				$stmt->execute();

				$patient_id = $conn->lastInsertId();

				// Insert into termin table
				$stmt = $conn->prepare("INSERT INTO termin (datum) VALUES (:datum)");
				$stmt->bindParam(':datum', $datum);
				$stmt->execute();
				
				$termin_id = $conn->lastInsertId();

				// Insert into befund table
				$stmt = $conn->prepare("INSERT INTO befund (beschreibung, Patient_id, Termin_terID) VALUES (:beschreibung, :patient_id, :termin_id)");
				$stmt->bindParam(':beschreibung', $beschreibung);
				$stmt->bindParam(':patient_id', $patient_id);
				$stmt->bindParam(':termin_id', $termin_id);
				$stmt->execute();
				

				// Commit the transaction
				$conn->commit();
			}
		}
		catch (PDOException $e) {
			echo "<div class='alert alert-danger mt-3'>Datenbankfehler: ". $e->getMessage() . "</div>";
		}
		finally {
			$conn = null;
		}
	}