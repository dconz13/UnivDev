<?php

include 'connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	echo 'This file cannot be called directly.';
}
else{
	//check for sign in status
	if(!$_SESSION['signed_in']){
		echo 'You must be signed in to post a reply.';
	}
	else{
		$sql = "INSERT INTO
					posts(post_content,
						  post_date,
						  post_topic,
						  post_by)
				VALUES('" . $_POST['reply-content'] . "',
						NOW(),
						" . mysql_real_escape_string($_GET['id']) . ",
						" . $SESSION['user_id'] . ")";
		$result = mysql_query($sql);
		
		if(!$result){
			echo 'An error occurred saving your reply. Please try again later.';
		}
		else{
			echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
		}
	}
}

include 'footer.php';
?>