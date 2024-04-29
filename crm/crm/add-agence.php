<?php
// Inclure le fichier de connexion à la base de données
include('bd.php');

$msg = ''; // Initialisez la variable de message pour éviter les erreurs de non-définition

// Vérifier si un identifiant d'agence a été envoyé via POST pour suppression
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Exécuter la requête d'UPDATE pour définir visible à 0 (supprimer l'agence)
    $update = $variable->prepare('UPDATE agence SET visible = 0 WHERE id = ?');
    if ($update->execute([$id])) {
        $msg = "Agence supprimée avec succès.";
    } else {
        $msg = "Erreur lors de la suppression de l'agence : " . $update->errorInfo()[2];
    }
}

// Traitement du formulaire d'ajout d'agence
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $ville = isset($_POST['ville']) ? trim($_POST['ville']) : '';
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';

    // Valider les champs requis
    if (empty($nom) || empty($adresse) || empty($ville) || empty($telephone)) {
        $msg = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Préparer la requête d'insertion avec des paramètres
        $sql = "INSERT INTO agence (nom, adresse, ville, telephone, dat, visible) 
                VALUES (:nom, :adresse, :ville, :telephone, NOW(), 1)";

        // Préparer et exécuter la requête d'insertion avec les valeurs
        $ajout = $variable->prepare($sql);
        $result = $ajout->execute([
            ':nom' => $nom,
            ':adresse' => $adresse,
            ':ville' => $ville,
            ':telephone' => $telephone,
        ]);

        // Vérifier si l'insertion a réussi
        if ($result) {
            $msg = "Agence ajoutée avec succès.";
        } else {
            $msg = "Erreur lors de l'ajout de l'agence : " . $ajout->errorInfo()[2];
        }
    }
}

// Sélectionner toutes les agences actives depuis la base de données
$requete = $variable->prepare('SELECT * FROM agence WHERE visible = 1');
$requete->execute();
$agences = $requete->fetchAll(PDO::FETCH_ASSOC);
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
                    <i class="fa fa-building"></i>
                </div>
                <div class="header-title">
                    <h1>Ajouter une agence</h1>
                    <small>Liste des agences</small>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonlist"> 
                                    <a class="btn btn-add" href="#listeAgences"> 
                                        <i class="fa fa-list"></i> Liste des agences 
                                    </a>  
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php if (!empty($msg)) : ?>
                                    <p><?php echo $msg; ?></p>
                                <?php endif; ?>
                                <form class="col-sm-6" method="POST" action="add-agence.php">
                                    <div class="form-group">
                                        <label>Titre</label>
                                        <input type="text" class="form-control" name="titre" placeholder="Nom de l'agence" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <input type="text" class="form-control" name="adresse" placeholder="Adresse" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Ville</label>
                                        <input type="text" class="form-control" name="ville" placeholder="Ville" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Téléphone</label>
                                        <input type="text" class="form-control" name="telephone" placeholder="Téléphone" required>
                                    </div>
                                    <div class="reset-button">
                                        <button type="reset" class="btn btn-warning">Réinitialiser</button>
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                        <?php
                        include("export.php");
                        ?>
                            <div class="panel-heading" id="listeAgences">
                                <h3 class="panel-title">Liste des agences</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Identifiant</th>
                                            <th>Nom</th>
                                            <th>Adresse</th>
                                            <th>Date de création</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($agences as $agence) : ?>
                                            <tr>
                                                <td><?= $agence['id'] ?></td>
                                                <td><?= $agence['nom'] ?></td>
                                                <td><?= $agence['adresse'] ?></td>
                                                <td><?= $agence['dat'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#editAgence<?= $agence['id'] ?>"><i class="fa fa-pencil"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAgence<?= $agence['id'] ?>"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                            </tr>
                                            <!-- Modals for Edit and Delete -->
                                            <!-- Include modal code here -->
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

