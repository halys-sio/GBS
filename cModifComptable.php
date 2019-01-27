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
$cmd = "select * from fichefrais";
$res = $dbc->query($cmd);


$id_upd = "";
$mois_upd = "";
$justif_upd = "";
$valide_upd = "";
$idetat_upd = "";

$mois    = (isset($_POST["mois"]))    ? $_POST["mois"]     : "";
$justif = (isset($_POST["nbJustificatifs"])) ? $_POST["nbJustificatifs"]  : "";
$valide = (isset($_POST["montantValide"])) ? $_POST["montantValide"]  : "";
$idetat = (isset($_POST["idEtat"])) ? $_POST["idEtat"]  : "";

if ($action == "N"){
    
    if ($id == ""){
        $cmd = "INSERT INTO `fichefrais` (`id_compta`, `mois`, `nbJustificatifs`, `montantValide`, `idEtat`)
        VALUES (NULL, '$mois', '$justif', '$valide', 'idetat');";
    $dbc->query($cmd);
    }else{
        $cmd = "update `fichefrais` set mois='$mois' , nbJustificatifs='$justif',
                                montantValide='$valide', idEtat='$idetat' ;";
    $dbc->query($cmd);
    }
    echo $cmd;

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
<form action="cComptable.php" method="post">
    <input type="hidden" name="act" value="N">
    <input type="hidden" name="id_compta" value="<?php echo $id_upd ; ?>">
        
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
        
        
        
        <input type="submit" value="Enregistrer">
</form>
</div>
</body>
</html>