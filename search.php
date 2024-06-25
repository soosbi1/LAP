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
			<?php
			include("context.php");
			search();
			?>
		</div>
	</body>
</html>