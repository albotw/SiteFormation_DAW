<?php
require_once(__DIR__ . "./../class/cours.php");
require_once(__DIR__ . "./../helpers/db.php");

function filtre($filtre) : array
{
	$array = db::getInstance()->get("cours","categorie = $filtre");
	return $array;
}

function coursSuivi($user) : array
{
	$res = array();
	$abo = db::getInstance()->get("abonnements","utilisateur = {$user}", false);
	//print_r($abo);
	for($i = 0;$i < count($abo);$i++)
	{
	    $cours = cours::load($abo[$i]["cours"]);
		//$cours = db::getInstance()->get("cours","id = {$abo[$i]["cours"]}");
		array_push($res, $cours);
	}
	return $res;
	//return db::getInstance()->get("utilisateurs u,cours c,abonnements a","u.nom = $user AND u.id = a.user AND a.cours = c.id");
}

function coursCree()
{
	$cours = db::getInstance()->get("cours","auteur = {$_SESSION["userID"]}", false);
	return $cours;
}

function follow($id, $coursID)
{
    $params=
        [
            "cours"=>$coursID,
            "utilisateur"=>$id
        ];
    db::getInstance()->insert(config::$SUBSCR_TABLE, $params);
    if (db::getInstance()->hasError())
    {
        echo "Une erreur s'est produite";
    }
    else
    {
        echo "Abonnement réussi !";
    }
}

function unfollow($id, $coursID)
{
    db::getInstance()->query("DELETE FROM abonnements WHERE utilisateur = ? AND cours = ?", [$id, $coursID], false);

    if (db::getInstance()->hasError())
        redirect::to("accueil", "Erreur");
    else
        redirect::to("profil");
}

function unfollowAsync($id, $coursID)
{
    db::getInstance()->query("DELETE FROM abonnements WHERE utilisateur = ? AND cours = ?", [$id, $coursID], false);

    if (db::getInstance()->hasError())
        echo "Une erreur s'est produite";
    else
        echo "Désabonnement réussi";
}
?>