<?php
// Inclure le fichier de connexion à la base de données
include('bd.php');

$msg = ''; // Initialisez la variable de message pour éviter les erreurs de non-définition

// Vérifier si un identifiant d'actif a été envoyé via POST pour suppression
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Exécuter la requête d'UPDATE pour définir visible à 0 (supprimer l'actif)
    $update = $variable->prepare('UPDATE actif SET visible = 0 WHERE id = ?');
    if ($update->execute([$id])) {
        $msg = "Actif supprimé avec succès.";
    } else {
        $msg = "Erreur lors de la suppression de l'actif : " . $update->errorInfo()[2];
    }
}

// Traitement du formulaire d'ajout d'actif
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $intituler = isset($_POST['intituler']) ? trim($_POST['intituler']) : '';
    $img = isset($_POST['img']) ? trim($_POST['img']) : '';
    $seuil_faible = isset($_POST['seuil_faible']) ? trim($_POST['seuil_faible']) : '';
    $piece_jointe = isset($_POST['piece_jointe']) ? trim($_POST['piece_jointe']) : '';
    $caracteristique = isset($_POST['caracteristique']) ? trim($_POST['caracteristique']) : '';
    $prix = isset($_POST['prix']) ? trim($_POST['prix']) : '';
    $categorie = isset($_POST['categorie']) ? trim($_POST['categorie']) : '';
    $date_acquisition = isset($_POST['date_acquisition']) ? trim($_POST['date_acquisition']) : '';
    $quantite = isset($_POST['quantite']) ? trim($_POST['quantite']) : '';
    $num_facture = isset($_POST['num_facture']) ? trim($_POST['num_facture']) : '';
    $num_serie = isset($_POST['num_serie']) ? trim($_POST['num_serie']) : '';
    $fournisseur = isset($_POST['fournisseur']) ? trim($_POST['fournisseur']) : '';

    // Valider les champs requis
    if (empty($intituler) || empty($img) || empty($prix) || empty($categorie) || empty($date_acquisition) || empty($quantite)) {
        $msg = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Préparer la requête d'insertion avec des paramètres
        $sql = "INSERT INTO actif (intituler, img, seuil_faible, piece_jointe, caracteristique, prix, categorie, date_acquisition, quantite, num_facture, num_serie, fournisseur, date, visible) 
                VALUES (:intituler, :img, :seuil_faible, :piece_jointe, :caracteristique, :prix, :categorie, :date_acquisition, :quantite, :num_facture, :num_serie, :fournisseur, NOW(), 1)";

        // Préparer et exécuter la requête d'insertion avec les valeurs
        $ajout = $variable->prepare($sql);
        $result = $ajout->execute([
            ':intituler' => $intituler,
            ':img' => $img,
            ':seuil_faible' => $seuil_faible,
            ':piece_jointe' => $piece_jointe,
            ':caracteristique' => $caracteristique,
            ':prix' => $prix,
            ':categorie' => $categorie,
            ':date_acquisition' => $date_acquisition,
            ':quantite' => $quantite,
            ':num_facture' => $num_facture,
            ':num_serie' => $num_serie,
            ':fournisseur' => $fournisseur
        ]);

        // Vérifier si l'insertion a réussi
        if ($result) {
            $msg = "Actif ajouté avec succès.";
        } else {
            $msg = "Erreur lors de l'ajout de l'actif : " . $ajout->errorInfo()[2];
        }
    }
}

// Sélectionner tous les actifs actifs depuis la base de données
$requete = $variable->prepare('SELECT * FROM actif WHERE visible = 1');
$requete->execute();
$actifs = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<body class="hold-transition sidebar-mini">
    <div id="preloader">
        <div id="status"></div>
    </div>
    <div class="wrapper">
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <div class="header-title">
                    <h1>Ajouter un actif</h1>
                    <small>Liste des actifs</small>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonlist"> 
                              <a class="btn btn-add " href="#listeActifs"> 
                              <i class="fa fa-list"></i>  Liste des actifs </a>  
                           </div>
                        </div>
                            <div class="panel-body">
                                <?php if (!empty($msg)) : ?>
                                    <p><?php echo $msg; ?></p>
                                <?php endif; ?>
                                <form class="col-sm-10" method="POST" action="actif.php">
                                    <!-- Champs du formulaire pour ajouter un actif -->
                                    <div class="form-group">
                                        <label>Catégorie</label>
                                        <select class="form-control" name="categorie" required>
                                            <option value="">Sélectionner une catégorie</option>
                                            <?php foreach ($catégories as $catégorie) : ?>
                                                <option value="<?= $catégorie['id'] ?>"><?= $catégorie['code'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Intitulé</label>
                                        <input type="text" class="form-control" name="intituler" placeholder="Intitulé de l'actif" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="picture">
                                        <input type="hidden" name="old_picture" class="img-circle" alt="User Image" width="50" height="50">
                                    </div>
                                    <div class="form-group">
                                        <label>Numero de facture</label>
                                        <input type="text" class="form-control" name="num_facture" placeholder="Numero de facture de l'actif" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Numéro de série</label>
                                        <input type="text" class="form-control" name="num_serie" placeholder="Numéro de série de l'actif" required>
                                    </div>
                                    <div class="form-group">
                                        <label>fournisseur</label>
                                        <select class="form-control" name="categorie" required>
                                            <option value="">Sélectionner une fournisseur</option>
                                            <?php foreach ($fournisseurs as $fournisseur) : ?>
                                                <option value="<?= $fournisseur['id'] ?>"><?= $fournisseur['code'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Prix</label>
                                        <input type="text" class="form-control" name="prix" placeholder="Prix de l'actif" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantité</label>
                                        <input type="text" class="form-control" name="Quantité" placeholder="Quantité de l'actif" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Ajouter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                        <?php
                        include("export.php");
                        ?>
                            <div class="panel-heading" id="listeActifs">
                                <h3 class="panel-title">Liste des actifs</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Titre</th>
                                            <th>Catégorie</th>
                                            <th>Quantité</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($actifs as $actif) : ?>
                                            <tr>
                                                <td><?= $actif['id'] ?></td>
                                                <td><?= $actif['img'] ?></td>
                                                <td><?= $actif['intituler'] ?></td>
                                                <td><?= $actif['categorie'] ?></td>
                                                <td><?= $actif['quantite'] ?></td>
                                                <td>
                                                    <form method="POST" action="actif.php">
                                                        <input type="hidden" name="id" value="<?= $actif['id'] ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php
        include("footer.php");
         ?>
      </div>
      <!-- ./wrapper -->
      <!-- Start Core Plugins
         =====================================================================-->
      <!-- jQuery -->
      <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
      <!-- jquery-ui --> 
      <script src="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
      <!-- Bootstrap -->
      <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <!-- lobipanel -->
      <script src="assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
      <!-- Pace js -->
      <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
      <!-- SlimScroll -->
      <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
      <!-- FastClick -->
      <script src="assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
      <!-- CRMadmin frame -->
      <script src="assets/dist/js/custom.js" type="text/javascript"></script>
      <!-- End Core Plugins
         =====================================================================-->
      <!-- Start Theme label Script
         =====================================================================-->
      <!-- Dashboard js -->
      <script src="assets/dist/js/dashboard.js" type="text/javascript"></script>
      <!-- End Theme label Script
         =====================================================================-->
   </body>
</html>



