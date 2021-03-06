<?php
require_once(__DIR__ . "./../class/cours.php");
require_once(__DIR__ . "./../class/categorie.php");
require_once(__DIR__ . "./../helpers/db.php");
require_once (__DIR__ . "./../helpers/warning2error.php");

function deleteCours($id)
{
    try{
        deleteCoursFile($id);
        cours::delete($id);
        redirect::to("profilAdmin", "Cours supprimé");
    }
    catch(Exception $e)
    {
        logger::log("Erreur pendant la suppression du cours {$id}");
        redirect::to("profilAdmin", "Erreur, impossible de supprimer le cours");
    }
}

function saveCoursFold()
{
	if(isset($_POST['repCours']))
	{
		$cours = $_POST['repCours'];
		$difficulte = "Débutant";
		switch(rand(1,4))
		{
			case 1 : $difficulte = "Débutant";break;
			case 2 : $difficulte = "Intermédiaire";break;
			case 3 : $difficulte = "Avancé";break;
			case 4 : $difficulte = "Expert";break;
		}
		
		$params = [
			"nom"=>"",
			"difficulte"=>$difficulte,
			"auteur"=>$_SESSION["admin"],
			"categorie"=>rand(1,4)
			];
			db::getInstance()->insert(config::$COURS_TABLE, $params);
			$c = db::getInstance()->query("SELECT * FROM cours ORDER BY id desc")[0];
			$lastID = $c['id'];
		
		if(!file_exists(__DIR__ . "./../data/cours/$lastID/index.html"))
		{
			$tabcours = json_decode($cours);
			$exp = explode(">",$tabcours[1]);
			echo $exp[1];
			$exp = explode("<",$exp[1]);
			echo $exp[0];
			$titre = $exp[0];
			mkdir(__DIR__ . "./../data/cours/$lastID");
			$f = fopen(__DIR__ . "./../data/cours/$lastID/index.html","w+");
			for($i = 0;$i < count($tabcours);$i++)
			{
				if($i < count($tabcours)-1)
					fputs($f,$tabcours[$i]."\n");
				else
				{
					$test = explode(" ",$tabcours[$i]);
					fputs($f,$test[0]."\n".$test[1]);
				}
				
			}
			fclose($f);
			$param = [
			"nom"=>$titre
			];
			db::getInstance()->update(config::$COURS_TABLE,"id = $lastID", $param );
		}
		else
		{
			db::getInstance()->delete(config::$COURS_TABLE,$lastID);
		}
		redirect::to("profilAdmin", "Cours ajouté avec succès");
		
	}
	
}