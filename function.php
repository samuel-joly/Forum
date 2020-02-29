<?php
	function required($form) {
		foreach($form as $input)
		{
			if(empty($input)) {
				return false;
				break;
			}
		}
		return   true;
	}
	
	function sql_request($request, bool $isData=false, bool $isSingle=false) {
		$connexion = mysqli_connect("localhost","root","","forum");
		$query = mysqli_query($connexion,$request);
		
		if($isData) {
			if($isSingle) {
				return mysqli_fetch_row($query);
			}
			else {
				return mysqli_fetch_all($query);
			}
		}
	}
	
	function currTopic($id, $is_message = false) {
		
		if(isset($_GET["topic"])) {
			if ($is_message) {
				
				if(isset($_GET["discussion"])) {
					if($_GET["discussion"] == $id) {
						return "currDiscussion";
					}
				}
			}
			else
			{
				if($_GET["topic"] == $id) {
					return "currTopic";
				}
			}			
		}
	}

	function create_forum($title, $creator, $date , $topic_id, $type, $access = 1, $message="") {
		if($type == "topic") {
			
			$infos = sql_request("
				SELECT (SELECT topics.image FROM topics WHERE topics.id = '".$topic_id."') AS 'profilPic' ,
				(SELECT COUNT(*) FROM discussions WHERE discussions.id_topic= '".$topic_id."') AS 'countDisc' ,
				(SELECT COUNT(*) FROM messages INNER JOIN discussions ON messages.id_discussion = discussions.id 
					INNER JOIN topics ON discussions.id_topic = topics.id WHERE topics.id = '".$topic_id."') as 'countMsg'"
			,true,true);
			
			$usrInfos = sql_request("SELECT messages.id_createur FROM messages
			INNER JOIN discussions ON messages.id_discussion = discussions.id 
			WHERE discussions.id_topic = '".$topic_id."'
			GROUP BY messages.id_createur",true);
			
			$creator_id = sql_request("SELECT id_createur FROM topics WHERE  id='".$topic_id."'",true,true)[0];
			return "<div class='flexc topic just-around ".currTopic($topic_id)."'>
						<a class='a-null flex just-betw big-link' href='forum.php?topic=".$topic_id."'>	
						
							<div class='created-zone flex'>
								<div class='topicPic' style='background-image:url(\"".$infos[0]."\"');'></div>
								<div class='flexc center'>
									<i class='date'>".$date."</i>
									<b><a href='profil.php?id=".$creator_id."'>".$creator."</a></b>
								</div>
							</div>
							<div >
								<a class='a-null flexc topic-infos' href='forum.php?topic=".$topic_id."'>	
									<span class='flex just-betw'> <p class='topic-title'>".$title."</p> </span>
									<div class='flex just-around'>
										<p class='stat-value flexc'><b>".$infos[1]."</b>Discussions</p>
										<p class='stat-value flexc'><b>".$infos[2]."</b>Messages</p>
										<p class='stat-value flexc'><b>".count($usrInfos)."</b>Utilisateurs</p>
									</div>
								</a>
							</div>
						</a>
				  </div>";
		}
		if($type == "discussion") {
			
			$stat_message = sql_request("SELECT COUNT(*) FROM messages
			INNER JOIN discussions ON messages.id_discussion = discussions.id
			INNER JOIN topics ON discussions.id_topic = topics.id
			WHERE discussions.id =".$topic_id, true, true);
			
			
			$profilPic = sql_request("SELECT utilisateurs.profilPic FROM utilisateurs
			INNER JOIN discussions ON utilisateurs.id = discussions.id_createur
			WHERE discussions.id=".$topic_id,true,true);
			$creator_id = sql_request("SELECT id_createur FROM discussions WHERE  id='".$topic_id."'",true,true)[0];
			
			return"<div class='flex discussion ".currTopic($topic_id, true)."'>
					<a class=' a-null flex just-betw big-link' href='forum.php?topic=".$_GET["topic"]."&&discussion=".$topic_id."'>	
						
							<a class='flexc' href='forum.php?topic=".$_GET["topic"]."&&discussion=".$topic_id."'>								
								<img class='disc-profilPic' src='".$profilPic[0]."'/>
							</a>							
							
							<div class='flexc discussion-infos'>
								<a href='profil.php?id=".$creator_id."'>".$creator."</a>
								<i>".$date."</i>
							</div>
							
							<a class='flex a-null just-between discussion-title' href='forum.php?topic=".$_GET["topic"]."&&discussion=".$topic_id."'>
								<span class='disc-titre center'>".$title."</span>
								<div class='disc-stat flexc'><b>".$stat_message[0]."</b>Réponses</div>
							</a>
					</a>
				  </div>";
		
		}
		if($type == "message") {
			$creator_id = sql_request("SELECT id FROM utilisateurs WHERE pseudo ='".$creator."'",true,true)[0];
			return "<div class='message'>
						<p>Par <a href='profil.php?id=".$creator_id."' class='creator-link'><u>".$creator."</u></a> le ".$date."</p>
						<h3>".$message."</h3>
						".get_likes($topic_id)."
				  </div>";
		}
	}
	
	function get_likes($id)
	{
		$likes = sql_request("SELECT COUNT(*) FROM likes WHERE id_message = ".$id,true,true)[0];
		$dislikes = sql_request("SELECT COUNT(*) FROM dislikes WHERE id_message = ".$id,true,true)[0];
		
		$returned = "<div class='flex just-center like-zone'>";
		if(isset($_SESSION["id"]))
		{
			if(!empty(sql_request("SELECT id_utilisateur FROM likes WHERE id_message =".$id." AND id_utilisateur = ".$_SESSION["id"],true,true)))
			{ 
				$returned .= "<div class='flex just-center'>";
				$returned .= "<a href='forum.php?unlike=".$id."'><img src='Images/liked.png' class='thumb-btn'></a>";
			}
			else
			{
				$returned .= "<div class='flex just-center'>";
				$returned .= "<a href='forum.php?like=".$id."'><img src='Images/like.png' class='thumb-btn'></a>";
			}
			if($likes != 0)
			{
				$returned .= "<p>".$likes."</p></div>";
			}
			else
			{
				$returned .= "</div>";
			}
			
			if(!empty(sql_request("SELECT id_utilisateur FROM dislikes WHERE id_message =".$id." AND id_utilisateur = ".$_SESSION["id"],true,true)))
			{ 
				$returned .= "<div class='flex just-center center'>";
				$returned .= "<a href='forum.php?undislike=".$id."'><img src='Images/disliked.png' class='thumb-btn'></a>";
			}
			else
			{
				$returned .= "<div class='flex just-center'>";
				$returned .= "<a href='forum.php?dislike=".$id."'><img src='Images/dislike.png' class='thumb-btn'></a>";
			}
			if($dislikes != 0)
			{
				$returned .= "<p>".$dislikes."</p></div>";
			}
			else
			{
				$returned .= "</div>";
			}
		}
		else
		{ 
			$returned .= "<a href='connexion.php'><img src='Images/like.png' class='thumb-btn'></a>";
			$returned .= "<a href='connexion.php'><img src='Images/dislike.png' class='thumb-btn'></a>";	
		}
		
		$returned .= "</div>";
		
		return $returned;
	}

?>