<?php
	$errors = ""; #要把errors 宣告在全域變數 php跟html才能一起用

	if($_SERVER["REQUEST_METHOD"] == "POST"){
      # $_SERVER['REQUEST_METHOD'] 訪問頁面時的請求方法例如：「GET」、「HEAD」，「POST」，「PUT」。 
		$conn = mysqli_connect("localhost","root","","forum");

		
		$username = htmlspecialchars($_POST["username"]);
		$email = htmlspecialchars($_POST["email"]);
		$password = htmlspecialchars($_POST["password"]);

		if (empty($username) or empty($email) or empty($password) or !filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$errors = "Invalid inputs!";
		}else{
			$query = mysqli_query($conn,"SELECT username FROM register WHERE username = '$username';");
			$data = mysqli_fetch_array($query);
			$query1 = mysqli_query($conn,"SELECT email FROM register WHERE email = '$email';");
			$data1 = mysqli_fetch_assoc($query1);
			 if(!is_null($data["username"])){  #假如搜尋到輸入的username已經在database is_null判斷變量是否為空 false false = true
			 	$errors = "username is exists!"; #顯示用戶名稱已存在
			 }elseif (!is_null($data1["email"])) { #假如搜尋到輸入的email已經在database
			 	$errors = "email is exists!"; #顯示信箱已存在
			 }else{
				$password = password_hash($password,PASSWORD_DEFAULT); #把密碼加密
				$query = mysqli_query($conn,"INSERT INTO register (username,email,password) VALUES ('$username','$email','$password')");
				$errors = "user created!";
					#ALTER TABLE register AUTO_INCREMENT = 1;序列從1重新開始(id)
			 }
			 
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registration</title>
	</head>
	<body>
		<h1>Register page</h1>
		<p style="color: red;"><?php  echo $errors; ?></p>
 		 <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">  <!-- 表示登入成功會跳到的頁面 -->
 			<input type="text" name="username" placeholder="Username" ><br><br> <!--placeholder 表 預設字 -->
 			<input type="text" name="email" placeholder="E-mail" ><br><br>
 			<input type="password" name="password" placeholder="Password" ><br><br>
 			<input type="submit">

 			
 		</form>
 			<a href="login.php">Login</a>
	</body>
</html>