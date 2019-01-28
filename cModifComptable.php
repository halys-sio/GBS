<?php
/** 
 * Page d'accueil de l'application web AppliFrais
 * @package default
 * @todo  RAS
 */
  /*$repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) 
  {
        header("Location: cSeConnecter.php");  
  }
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Bienvenue sur l'intranet GSB</h2>
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  require($repInclude . "_fin.inc.php");*/

$dbc = new PDO("mysql:host=localhost;dbname=gsb_valide" , "root", "");
$action = (isset($_POST["act"])) ? $_POST["act"] : "";
$id = (isset($_POST["id_compta"])) ? $_POST["id_compta"] : "";

//variables vide lorsque l'on crée une nouvelle fiche
$mois_upd = "";
$justif_upd = "";
$valide_upd = "";
$idetat_upd = "";
$idvisiteur_upd = "";
$visiteur = false;

$mois    = (isset($_POST["mois"]))    ? $_POST["mois"]     : "";
$justif = (isset($_POST["nbJustificatifs"])) ? $_POST["nbJustificatifs"]  : "";
$valide = (isset($_POST["montantValide"])) ? $_POST["montantValide"]  : "";
$idetat = (isset($_POST["idEtat"])) ? $_POST["idEtat"]  : "";
$id_visiteur = (isset($_POST["id_visiteur"])) ? $_POST["id_visiteur"]  : "";


if ($action == "N"){
    if ($id == ""){
//uniqid permet de générer un id "aléatoire" pour récupérer un id_compta différent et différencier les fiches
      $unique_id = uniqid();
        $cmd = "INSERT INTO `fichefrais` (id_compta, idVisiteur, `mois`, `nbJustificatifs`, `montantValide`, `idEtat`)
        VALUES ('$unique_id','$id_visiteur', '$mois', '$justif', '$valide', '$idetat');";
    }else{
        $cmd = "update fichefrais set mois='$mois' , idVisiteur='$id_visiteur',
                                      nbJustificatifs='$justif', montantValide='$valide', 
                                      idEtat='$idetat' 
                where id_compta='$id' ;";
    }
    $dbc->query($cmd);
    header('Location: cComptable.php');
}
$visiteurs = $dbc->query("SELECT * FROM visiteur");

//permet lorsque $id est différent de vide de récupérer toutes les valeures préremplies
if ($id != ""){
  $cmd= "select * from fichefrais where id_compta='$id' ;";
  $res = $dbc->query($cmd);
  $fiche = $res->fetch();
  $mois_upd = $fiche['mois'];
  $justif_upd = $fiche['nbJustificatifs'];
  $valide_upd = $fiche['montantValide'];
  $idetat_upd = $fiche['idEtat'];
  $idvisiteur_upd = $fiche['idVisiteur'];

  $visiteur=$dbc->query("select * from visiteur where id='$idvisiteur_upd'")->fetch();
}
?>

<!doctype html>
<html>
<head>
                <meta charset="utf-8">
                <!-- Bootstrap -->
            <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
                <title>Comptable</title>        
</head>
<body>
  <!-- fonction if permettant de récupérer le nom du visiteur à qui on modifie la fiche -->
  <?php if ($visiteur): ?>
    <h1 id="name">Informations sur la fiche de <?= $visiteur['nom'] ?></h1>
    <?php else:   ?>
      <h1 id="creation">Création d'une nouvelle fiche</h1>
  <?php endif; ?>

<form method="post">
    <input type="hidden" name="act" value="N">
    <input type="hidden" name="id_compta" value="<?php echo $id ; ?>">
        
        <label for="mois">Mois</label>
        <input type="text" id="mois" name="mois" value="<?php echo $mois_upd ; ?>">
        <br><br>
        
        <label for="nbJustificatifs">Justificatifs</label>
        <input type="text" id="nbJustificatifs" name="nbJustificatifs" value="<?php echo $justif_upd ; ?>">
        <br><br>
        
        <label for="montantValide">Validation du montant</label>
        <input type="text" id="montantValide" name="montantValide" value="<?php echo $valide_upd ; ?>">
        <br><br>

        <label for="idEtat">Etat de la fiche</label>
        <input type="text" id="idEtat" name="idEtat" value="<?php echo $idetat_upd ; ?>">
        <br><br>
        
        <select name="id_visiteur">
          <?php foreach ($visiteurs as $visiteur): ?>
            <option value="<?= $visiteur['id'] ?>" <?php if ($visiteur['id'] == $idvisiteur_upd){echo 'selected';}  ?>> <?=$visiteur['nom']?></option>
          <?php endforeach; ?>
        </select>
        
        
        <input type="submit" value="Enregistrer">
        <a href="cComptable.php">Retour</a>
</form>
</div>
</body>
</html>