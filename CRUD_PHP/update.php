<?php
	require 'database.php';
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		#validação de erros
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		#validação de valores
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		
		#validação das entradas
		$valid = true;
		if (empty($name)) {
			$nameError = 'Entre com um nome!';
			$valid = false;
		}
		
		if (empty($email)) {
			$nameError = 'Entre com um email!';
			$valid = false;
		}else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Entre com um email valido!';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Entre com um numero de telefone!';
			$valid = false;
		}
		
		#atualiza banco de dados
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers set name = ?, email = ?, mobile = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$email = $data['email'];
		$mobile = $data['mobile'];
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
					<h3>Atualizar cliente Cadastrado</h3>
				</div>
				
				<form class="form-horizontal" action="update.php?=id=<?php echo $id?>" method="post">
					<div class="control-group <?php echo !empty($nameError)?'error':'';?>">
						<label class="control-label">Nome</label>
						<div class="control">
							<input name="name" type="text" placeholder="Nome" value="<?php echo !empty($name)?$name:'';?>">
							<?php if (!empty($nameError)): ?>
								<span class="help-inline"><?php echo $nameError;?></span>
							<?php endif;?>
						</div>
					</div>
					<div class="control-group <?php echo !empty($emailError)?'error':'';?>">
						<label class="control-label">Email</label>
						<div class="control">
							<input name="email" type="text" placeholder="Endereço de Email" value="<?php echo !empty($email)?$email:'';?>">
							<?php if (!empty($emailError)): ?>
								<span class="help-inline"><?php echo $emailError;?></span>
							<?php endif;?>
						</div>
					</div>
					<div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
						<label class="control-label">Numero de Telefone</label>
						<div class="control">
							<input name="mobile" type="text" placeholder="Numero de Telefone" value="<?php echo !empty($mobile)?$mobile:'';?>">
							<?php if (!empty($mobileError)): ?>
								<span class="help-inline"><?php echo $mobileError;?></span>
							<?php endif;?>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-success">Alterar</button>
						<a class="btn" href="index.php">Voltar</a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>