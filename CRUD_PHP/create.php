<?php
	require 'database.php';
	
	if ( !empty($_POST)) {
		#Keep track validation errors
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		#Keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		
		#validation input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Digite um nome';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Digite um email';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Digite um email valido';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Digite um numero de telefone';
			$valid = false;
		}
		
		
		#insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers (name, email, mobile) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile));
			Database::disconnect();
			header("Location: index.php");
		}
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
				<h3>Registrar cliente</h3>
			</div>
			
			<form class="form-horizontal" action="create.php" method="post">
				<div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					<label class="control-label">Nome</label>
					<div class="controls">
						<input name="name" type="text" placeholder="Nome" value="<?php echo !empty($name)?$name:'';?>">
						<?php if (!empty($nameError)): ?>
							<span class="help-inline"><?php echo $nameError;?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					<label class="control-label">Email</label>
					<div class="controls">
						<input name="email" type="text" placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
						<?php if (!empty($emailError)): ?>
							<span class="help-inline"><?php echo $emailError;?></span>
						<?php endif;?>
					</div>
				</div>
				 <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                        <label class="control-label">Numero de Telefone</label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Numero de Telefone" value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Registrar</button>
					<a class="btn" href="index.php">Voltar</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>	

	