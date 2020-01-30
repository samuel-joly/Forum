
<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Forum</title>
	</head>

	<body>
		<?php include("header.php");

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
					
						<form action="<?php echo "forum.php?topic=".$_GET["topic"]; ?>" method="post" id="disc-form">
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
					
							 <form action="" method="post" id="disc-form">
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

		<footer>
		</footer>
	</body>

</html>
