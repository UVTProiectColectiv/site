  
<?php
session_start();

// initializare variabile
$username = "";
$email = "";
$password_1 = "";
$password_2 = ""; 
$errors = array(); 

// conectare la baza de date
$db = mysqli_connect('localhost', 'root', '', 'login_db');

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// inregistrare utilizator
if (isset($_POST['reg_user'])) {
  // primirea valorilor de intrare din formular
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // adaugarea (array_push()) erorii corespunzatoare la $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // verificarea mai întâi a bazei de date pentru a ma asigura ca 
  // un utilizator nu există deja cu același nume de utilizator și / sau e-mail
  $user_check_query = "SELECT * FROM members WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { 
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  //  înregistrare utilizator dacă nu există erori în formular
  if (count($errors) == 0) {
  	$password = md5($password_1);//criptare parola înainte de a salva în baza de date

  	$query = "INSERT INTO members (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

$errors2 = array(); 
// logare utilizator
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors2, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors2, "Password is required");
  }

  if (count($errors2) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM members WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: site.html');
  	}else {
  		array_push($errors2, "Wrong username/password combination");
  	}
  }
}

?>