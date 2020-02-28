
<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Forum</title>
	</head>

	<body>
		<?php include("header.php");
			
			$stmt = new PDO("mysql:host=localhost;dbname=forum","root","");
			
			if(isset($_POST["submitDisc"])) {
				if(!empty($_POST["discTitle"])){
					$titre = escapeshellarg(htmlspecialchars($_POST["discTitle"]));
					sql_request("INSERT INTO discussions(`id`, `titre`, `id_topic`, `id_createur`, `date_time`)
					VALUES (NULL, $titre, '".$_GET["topic"]."', '".$_SESSION["id"]."', CURRENT_TIMESTAMP)");
				}
				header("location:forum.php?topic=".$_GET["topic"]);
			}

			if(isset($_POST["submitMsg"])) {
				if(!empty($_POST["msg"])) {
					$message = escapeshellarg(htmlspecialchars($_POST["msg"])); 
					sql_request("INSERT INTO `messages` (`id`, `id_createur`, `texte`, `id_discussion`, `date_time`)
					VALUES (NULL, '".$_SESSION["id"]."', ".$message." , ".$_GET["discussion"]." , CURRENT_TIMESTAMP)");
				}
				header("location:forum.php?topic=".$_GET["topic"]."&&discussion=".$_GET["discussion"]);
			}
			
			if(isset($_SESSION["id"]) && (isset($_GET["like"]) || isset($_GET["dislike"])))
			{
				if(isset($_GET["like"]))
				{
					if( empty($stmt->query("SELECT * FROM likes WHERE id_utilisateur = ".$_SESSION["id"]." AND id_message =".$_GET["like"])->fetch()[0]))
					{
						$stmt->query("INSERT INTO likes (id, id_utilisateur, id_message) VALUE(NULL, ".$_SESSION["id"].", ".$_GET["like"]." )");
						
						if(!empty($stmt->query("SELECT * FROM likes WHERE id_utilisateur = ".$_SESSION["id"]." AND id_message =".$_GET["like"])->fetch()[0]))
						{
							$stmt->query("DELETE FROM dislikes WHERE id_utilisateur = ".$_SESSION["id"]." AND id_message=".$_GET["like"]);
						}
					}
					$discussion_id = $stmt->query("SELECT id_discussion FROM messages WHERE id=".$_GET["like"])->fetch()[0];
					$topic_id = $stmt->query("SELECT id_topic FROM discussions WHERE id=".$discussion_id)->fetch()[0];						
				}
				else if(isset($_GET["dislike"]))
				{
					if(	empty($stmt->query("SELECT * FROM dislikes WHERE id_utilisateur = ".$_SESSION["id"]." AND id_message =".$_GET["dislike"])->fetch()[0]))
					{
						$stmt->query("INSERT INTO dislikes (id, id_utilisateur, id_message) VALUE(NULL, ".$_SESSION["id"].", ".$_GET["dislike"]." )");
						if(!empty($stmt->query("SELECT * FROM dislikes WHERE id_utilisateur = ".$_SESSION["id"]." AND id_message =".$_GET["dislike"])->fetch()[0]))
						{
							$stmt->query("DELETE FROM likes WHERE id_utilisateur = ".$_SESSION["id"]." AND id_message=".$_GET["dislike"]);
						}
					}
					$discussion_id = $stmt->query("SELECT id_discussion FROM messages WHERE id=".$_GET["dislike"])->fetch()[0];
					$topic_id = $stmt->query("SELECT id_topic FROM discussions WHERE id=".$discussion_id)->fetch()[0];
				}
				
				header("location:forum.php?topic=".$topic_id."&&discussion=".$discussion_id);	
			}

		?>



		<main>
		
			<?php

				$topics = sql_request("SELECT titre, utilisateurs.pseudo, DATE_FORMAT(date_time,'%e %M %Y'), visibilite, topics.id 
				FROM topics INNER JOIN utilisateurs ON topics.id_createur = utilisateurs.id 
				ORDER BY date_time DESC", true);
				
				
				echo "<div class='flexc forum-box' id='topic-box'>";
				foreach($topics as $topic) {
					echo create_forum($topic[0],$topic[1],$topic[2],$topic[4], "topic",$topic[3]);
				}
				echo "</div>";
				
				
				if(isset($_GET["topic"])) {
					
					echo "<div class='flexc forum-box' id='discussion-box'>";
					$discussions = sql_request("SELECT titre, utilisateurs.pseudo, DATE_FORMAT(date_time,'%e %M %Y %H:%i'), discussions.id
					FROM discussions INNER JOIN utilisateurs ON discussions.id_createur = utilisateurs.id
					WHERE id_topic = ".$_GET["topic"]." ORDER BY date_time ASC", true);
					
					
					foreach($discussions as $discussion) {
						echo create_forum($discussion[0],$discussion[1],$discussion[2],$discussion[3], "discussion");
					}
					
					if(isset($_SESSION["id"])) {  ?>
					
						<form action="<?php echo "forum.php?topic=".$_GET["topic"]; ?>" method="post" class="disc-form">
							<input type="text" name="discTitle"/>
							<input type="submit" name="submitDisc" value="Envoyer"/>
						</form>
					
					<?php }
					
					echo "</div>";
					
					if (isset($_GET["discussion"])) {
						echo "<div class='flexc forum-box' id='message-box'>";
						$messages = sql_request("SELECT utilisateurs.pseudo, date_time, messages.id, texte
						FROM messages INNER JOIN utilisateurs ON messages.id_createur = utilisateurs.id 
						WHERE id_discussion = ".$_GET["discussion"]." ORDER BY date_time ASC", true);
						
						foreach($messages as $message) {
							echo create_forum("", $message[0],$message[1],$message[2], "message", 1,$message[3]);
						}
						
						if(isset($_SESSION["id"])) {	?>
							 <form action="" method="post" class=" disc-form">
								<textarea name="msg" cols="20" row="10"></textarea>
								<input type="submit" name="submitMsg" value="Envoyer" class="msg-submit"/>
							</form>
					<?php
						}
					}
					echo "</div>";
				}
			?>

		
		</main>

		<?php include("footer.php"); ?>
	</body>

</html>


<?php
	


?>