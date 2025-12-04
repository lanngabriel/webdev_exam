<?php
session_start();

$name = $_SESSION['name'] ?? null;
$profile = $_SESSION['profile'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$active_form = $_SESSION['active_form'] ?? '';

session_unset();

if ($name !== null) $_SESSION['name'] = $name;

?>

<!DOCTYPE html>
<html lang="en">
	

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>DLSU-D Better Schoolbook</title>
	<link rel="stylesheet" href="style.css">
	<link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>
	<header>
		<a href="#" class = "logo">WebDev Exam</a>

		<div class="user-auth">
			<?php if (!empty($name)) : ?>
			<div class = "profile-box" >
				<div class = "avatar-circle"><?= strtoupper($name[0]) ?></div>
				<div class = "dropdown">
					<a href ="logout.php">Logout</a>
				</div>
			</div>
			<?php else : ?>
			<button type="button" class = "login-btn-modal" >Login</button>
			<?php endif; ?>
		</div>

	</header>

	<section>
		<?php if (!empty($name)) : ?>
			<div class="center-profile-box">
			<div class="center-avatar">
				<img src="<?=$profile ?>" style="width: auto; height: 300px;"  >
		
			</div>
			<div class="center-username"> <h2><?= $name ?></h2></div>
			</div>
		<?php endif; ?>
		<h1>Hello, <?= $name ?? 'Stranger' ?></h1>
	</section>



	<?php if (!empty($alerts)) : ?>
	<div class = "alert-box">
		<?php foreach ($alerts as $alert) : ?>
		<div class="alert <?= $alert['type']; ?>">

			<i class='bx <?= $alert['type'] === 'success' ? 'bxs-check-circle' : 'bxs-x-circle' ?>'></i>
			<span><?= $alert['message']; ?></span>

		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<div class="auth-modal" <?= $active_form === 'register' ? 'show-slide' : ($active_form === 'login' ? 'show' : ''); ?>>

		<button type="button" class = "close-btn-modal"><i class='bx  bx-x'></i> </button>

		<div class="form-box login">
		
			<h2>Login</h2>
			<form action="loginregister.php" method = "POST">
				<div class="input-box">
					<input type="email" required name = "email" placeholder="Email">
					<i class='bx bxs-envelope'  ></i> 
				</div>
				<div class="input-box">
					<input type="password" required name = "password" placeholder="Password">
					<i class='bx bxs-lock'  ></i> 
				</div>
				<button type="submit" name = "login_btn" class = "btn">Login</button>
				<p>Don't have an account? <a href="#" class="register-link">Register</a></p>
			</form>
		</div>

		<div class="form-box register">
		
			<h2>Register</h2>
			<form action="loginregister.php" method = "POST" enctype="multipart/form-data">
				<div class="input-box">
					<input type="text" required name = "name" placeholder="Name">
					<i class='bx  bxs-user'  ></i> 
				</div>
				<div class="input-box">
					<input type="email" required name = "email" placeholder="Email">
					<i class='bx bxs-envelope'  ></i> 
				</div>
				<div class="input-box">
					<input type="password" required name = "password" placeholder="Password">
					<i class='bx bxs-lock'  ></i> 
				</div>
				<div class="input-box">
					<input type="password" required name = "confirm_password" placeholder="Confirm Password">
					<i class='bx bxs-lock'  ></i> 
				</div>
				<div class="input-box">
					<input type="file" required name = "picture" placeholder="Profile Picture" accept=".jpg, .jpeg, .png">
					<i class='bx  bx-image'></i> 
				</div>				
				<button type="submit" name = "register_btn" class = "btn">Register</button>
				<p>Already have an account? <a href="#" class="login-link">Login</a></p>
			</form>
		</div>

	</div>

	<script src="script.js"></script>

</body>
</html>
