</br>
<div class="cours">
    <img class="box1" src="<?= $icon?>" onclick="location.href=">
    <h3 class="box2" onclick="location.href='index.php?page=structureCours&id=1'"><?= $nomCours?> </h3>
    <p class="box3"><?= $difficulte ?> </p>
    <!--<p class="box4"> Ceci est une description</p>-->
    <button class="bouton box5"  onclick="location.href='/back/router.php?action=unfollow&cours=<?= $id?>&csrf_token=<?= Token::get()?>'" type="button" value="désabo">Se désabonner</button>
</div>