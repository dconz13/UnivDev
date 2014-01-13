<?php

include 'connect.php';
include 'header.php';

echo '<h3>Sign in</h3>';

//first check to see is the user is already signed in. Do not display page if they are.
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
	echo 'You are already signed in. Click here to <a href="signout.php">sign out</a>.';
} 
else{
	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		/*the form hasn't been posted yet, display the form.
		  action="" will cause the form to post to the same page it is on*/
		echo '<form method ="post" action="">
			Username: <input type="text" name="user_name" />
			Password: <input type="password" name="user_pass"/>
			<input type="submit" value="Sign in" />
			</form>';
	} 
	else{
		/* so, the form has been posted:
			1. Check the data
			2. Let the user refill the wrong fields
			3. Verify if the data is correct and return the correct response
		*/
		$errors = array();
		
		if(!isset($_POST['user_name'])){
			$errors[] = 'The username field must not be empty.';
		}
		if(!isset($_POST['user_pass'])){
			$errors[] = 'The password field must not be empty.';
		}
		if(!empty($errors)){ //Checks if errors is an empty array. Empty if no errors.
			echo 'Username or password is incorrect.';
			echo '<u1>';
			foreach($errors as $key => $value){ //pulls all values from $errors array
				echo '<li>' . $value . '</li>';
			}
			echo '</u1>';
		}
		else{
		//no errors, save information. mysql_real_escape_string keeps things safe
		//sha1 function hashes the password.
			$sql ="SELECT
						user_id,
						user_name,
						user_level
					FROM
						users
					WHERE
						user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
					AND
						user_pass = '" . sha1($_POST['user_pass']) . "'";
			$result = mysql_query($sql);
			if(!$result){ //something went wrong. display error
				echo 'Something went wrong while signing in. Please try again.';
				//echo mysql_error(); //for debugging purposes
			}
			else{
			//1. the query returned data, the user can be signed in
			//2. or the query returned an empty result set, wrong credentials
				if(mysql_num_rows($result) == 0){
					echo 'Incorrect username or password. Please try again.';
				}
				else{
					$_SESSION['signed_in'] = true;
					//also store user_id / user_name in $_SESSION so it can be used in other pages
					while($row = mysql_fetch_assoc($result)){
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['user_name'] = $row['user_name'];
						$_SESSION['user_level'] = $row['user_level'];
					}
					echo 'Welcome, ' . $_SESSION['user_name'] . ' . <a href="index.php">Proceed to the forum</a>.';
				}
			}
		}	
		}
		}
		include 'footer.php';
		?>