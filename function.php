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
			
			return "<div class='flexc topic just-around ".currTopic($topic_id)."'>
						<a class='a-null flex just-betw' href='forum.php?topic=".$topic_id."'>	
						
							<div class='created-zone flexc'>
								<div class='topicPic' style='background-image:url(\"".$infos[0]."\"');'></div>
								<i class='date'>".$date."</i>
								<b>".$creator."</b>
							</div>
							<div class='flexc topic-infos'>
								<span class='flex just-betw'> <p class='topic-title'>".$title."</p> </span>
								<div class='flex just-around'>
									<p class='stat-value flexc'><b>".$infos[1]."</b>Discussions</p>
									<p class='stat-value flexc'><b>".$infos[2]."</b>Messages</p>
									<p class='stat-value flexc'><b>".count($usrInfos)."</b>Utilisateurs</p>
								</div>
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
			
			return"<div class='flexc discussion ".currTopic($topic_id, true)."'>
					<a class='a-null flex just-betw' href='forum.php?topic=".$_GET["topic"]."&&discussion=".$topic_id."'>	
						
						<div class='flex just-center disc-profil'>
							<img class='disc-profilPic' src='".$profilPic[0]."'/>
							<p class='flexc disc-info-auteur'>
								<u>".$creator."</u> 
								<i>".$date."</i>
								<span class='disc-titre'>".$title."</span>
							</p>
						</div>
						<div class='disc-stat flexc'><b>".$stat_message[0]."</b>Réponses</div>
					</a>
				  </div>";
		
		}
		if($type == "message") {
			return "<div class='message'>
						<p>Par <u>".$creator."</u> le ".$date."</p>
						<h3>".$message."</h3>
				  </div>";
		}
	}

?>