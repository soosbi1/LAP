<!doctype html>
<html data-bs-theme="dark">
	<head>
		<?php include 'components/head.php' ?>
	</head>
	<header>
		<?php include 'components/nav.php' ?>
	</header>
	<body>
		<h1>Erfassen</h1>
		<form action="actions/insert-patient.php" method="post">
			<div class="input-group w-25">
				<span class="input-group-text">Vor- und Nachname</span>
				<input type="text" aria-label="First name" class="form-control" id="vorname" name="vorname" required>
				<input type="text" aria-label="Last name" class="form-control" id="nachname" name="nachname" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Geburtstag</span>
				<input type="date" aria-label="Geburtstag" class="form-control" id="geburtstag" name="geburtstag" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">SVNR</span>
				<input type="number" aria-label="SVNR" class="form-control" id="svnr" name="svnr" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Beschwerde</span>
				<input type="text" aria-label="Beschwerde" class="form-control" id="beschreibung" name="beschreibung" required>
			</div>
			<br>
			<div class="input-group w-25">
				<span class="input-group-text">Termin</span>
				<input type="datetime-local" aria-label="Termin" class="form-control" id="datum" name="datum" required>
			</div>
			<br>
			<button type="submit" class="btn btn-primary">Absenden</button>
		</form>
	</body>
</html>