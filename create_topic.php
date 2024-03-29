<?php
include 'connect.php';
include 'header.php';

echo '<h2>Create a topic</h2>';
if($_SESSION['signed_in'] == false){
	//the user is not signed in
		echo 'Sorry you have to be <a href="signin.php">signed in</a> to create a topic.';
}
else{
	//the user is already signed in
	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		//the form hasn't been posted yet, so display it
		//retrieve the categories from the database for use in the dropdown
		$sql = "SELECT
					cat_id,
					cat_name,
					cat_description
				FROM
					categories";
		$result = mysql_query($sql);
		
		if(!$result){
			//the query failed
			echo 'Error while selecting from database. Please contact admin.';
		}
		else{
			if(mysql_num_rows($result)==0){
				//there are no categories so a topic cannot be posted
				if($_SESSION['user_level'] == 1){
					echo 'You have not created categories yet.';
				}
				else{
					echo 'Before you can post a topic, you must wait for an admin to create categories';
				}
			}
			else{
				echo '<form method="post" action="">
					Subject: <input type="text" name="topic_subject"/>
					Category;';
				echo '<select name="topic_cat">';
					while($row = mysql_fetch_assoc($result)){
						echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
					}
				echo '</select>';
				echo 'Message: <textarea name="post_content" /> </textarea>
					<input type="submit" value="Create topic" />
					</form>';
			}	
		}
		
		//start the transaction? what does this mean
		$query = "BEGIN WORK;";
		$result = mysql_query($query);
		
		if(!$result){
			//the query timed failed. quit
			echo 'An error occurred while creating your topic. Please try again later.';
		}
		else{
			//the form has been posted. need to save it
			//insert the topic into the topics table, then save the post in posts table.
			$sql = "INSERT INTO
						topics(topic_subject,
								topic_date,
								topic_cat,
								topic_by)
					VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
							NOW(),
							" . mysql_real_escape_string($_POST['topic_cat']) . ",
							" . $_SESSION['user_id'] . "
						   )";
			$result = mysql_query($sql);
			if(!$result){
				//something went wrong, display the error
				echo 'An error occurred while inserting your data. Please try again later.' . mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			}
			else{
				//the first query worked, now start the second
				//retrieve the id of the freshly created topic for usage in the posts query
				$topicid = mysql_insert_id();
				
				$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . mysql_real_escape_string($_POST['post_content']) . "',
								NOW(),
								" . $topicid . ",
								" . $_SESSION['user_id'] . "
							)";
				$result = mysql_query($sql);
				
				if(!$result){
					//something went wrong, display error
					echo 'An error occurred while inserting your post. Please try again later.' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysql_query($sql);
				}
				else{
					$sql = "COMMIT;";
					$result = mysql_query($sql);
					echo 'You have successfully create a <a href="topic.php?id=' . $topicid . '"> your new topic</a>';
					
				}
			}
		}
	}
}
include 'footer.php';
?>