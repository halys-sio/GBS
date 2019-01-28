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

$id_compta    = (isset($_POST["id_compta"]))    ? $_POST["id_compta"]     : "";
$mois    = (isset($_POST["mois"]))    ? $_POST["mois"]     : "";
$justif = (isset($_POST["nbJustificatifs"])) ? $_POST["nbJustificatifs"]  : "";
$valide = (isset($_POST["montantValide"])) ? $_POST["montantValide"]  : "";
$idetat = (isset($_POST["idEtat"])) ? $_POST["idEtat"]  : "";


if ($action == "M"){
    
    $cmd = "select * from fichefrais where id_compta = '$id' ;";
    $res = $dbc->query($cmd);
    $line = $res->fetch();
    
    $id_upd       = $line["id_compta"];
    $mois_upd      = $line["mois"];
    $justif_upd   = $line["nbJustificatifs"];
    $valide_upd   = $line["montantValide"];
    $idetat_upd = $line["idEtat"];
  
    
    
}

if ($action == "S"){
    $cmd = "delete from fichefrais where id_compta='$id' ; ";
    $dbc->query($cmd);
}
$cmd= "select * from fichefrais;";
$res = $dbc->query($cmd);
$table2 = $res->fetchAll();
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
<div class="container">
<h1>Fiche de frais</h1>
<br><br>


<br>


<table class="table">
<thead>
        <td>Mois </td>
        <td>Justificatifs </td>
        <td>Validation du montant </td>
        <td>Etat de la fiche </td>   
</thead>
<?php foreach ($table2 as $line ) {?>
<tr>
        <td><?php echo $line["mois"]; ?></td>
        <td><?php echo $line["nbJustificatifs"]; ?></td>
        <td><?php echo $line["montantValide"]; ?></td>
        <td><?php echo $line["idEtat"]; ?></td>
          <td>
      <form action="cModifComptable.php" method="post">
          <input type="hidden" name="id_compta" value="<?php echo $line["id_compta"];?>">
          <input type="hidden" name="act" value="M"> 
          <input type="submit" value="M">
        </form>
        </td>
        <td> 
        <form action="cComptable.php" method="post">
          <input type="hidden" name="act" value="S"> 
          <input type="hidden" name="id_compta" value="<?php echo $line["id_compta"];?>">
          <input type="submit" value="S">
        </form>
        </td>
    </td>
</tr>
<?php } ?>
</table>
        <form action="cModifComptable.php" method="post">
          <input type="submit" value="Créer">
        </form>
</div>
</body>
</html>
