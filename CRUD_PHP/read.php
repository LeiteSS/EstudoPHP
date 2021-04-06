<?php
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
	</head>	
	
	<body>
		<div class="container">
			<div class="span10 offset1">
				<div class="row">
					<h3>Consulta</h3>
				</div>
				
				<div class="form-horizontal">
					<div class="control-group">	
						<label class="control-label">Nome:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['name'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['email'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Numero de Telefone:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['mobile'];?>
							</label>
						</div>
					</div>
					<div class="form-actions">
						<a class="btn" href="index.php">Voltar</a>
					</div>
				</div>
			</div>
		</div>
	</body>	
</html>	