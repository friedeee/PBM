<?php
// Inclure le fichier de connexion à la base de données
include('bd.php');

$msg = ''; // Initialisez la variable de message pour éviter les erreurs de non-définition

// Vérifier si un identifiant de poste a été envoyé via POST pour suppression
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Exécuter la requête d'UPDATE pour définir visible à 0 (supprimer le poste)
    $update = $variable->prepare('UPDATE poste SET visible = 0 WHERE id = ?');
    if ($update->execute([$id])) {
        $msg = "Poste supprimé avec succès.";
    } else {
        $msg = "Erreur lors de la suppression du poste : " . $update->errorInfo()[2];
    }
}

// Sélectionner toutes les agences actives depuis la base de données pour la liste déroulante
$requeteAgences = $variable->prepare('SELECT id, intituler FROM agence WHERE visible = 1');
$requeteAgences->execute();
$postes = $requeteAgences->fetchAll(PDO::FETCH_ASSOC);

// Sélectionner tous les services actifs depuis la base de données pour la liste déroulante
$requeteServices = $variable->prepare('SELECT id, intituler FROM service WHERE visible = 1');
$requeteServices->execute();
$postes = $requeteServices->fetchAll(PDO::FETCH_ASSOC);
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
                    <i class="fa fa-suitcase"></i>
                </div>
                <div class="header-title">
                    <h1>Ajouter un poste</h1>
                    <small>Liste des postes</small>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                        <div class="btn-group" id="buttonlist"> 
                                    <a class="btn btn-add" href="#listePostes"> 
                                        <i class="fa fa-list"></i> Liste des postes 
                                    </a>  
                                </div>
                            <div class="panel-body">
                                <?php if (!empty($msg)) : ?>
                                    <p><?php echo $msg; ?></p>
                                <?php endif; ?>
                                <form class="col-sm-6" method="POST" action="add-poste.php">
                                <div class="form-group">
                                        <label>Agence</label>
                                        <select class="form-control" name="agence" required>
                                            <option value="">Sélectionner une agence</option>
                                            <?php foreach ($agences as $agence) : ?>
                                                <option value="<?= $agence['id'] ?>"><?= $agence['nom'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select class="form-control" name="service" required>
                                            <option value="">Sélectionner un service</option>
                                            <?php foreach ($services as $service) : ?>
                                                <option value="<?= $service['id'] ?>"><?= $service['intituler'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Intitulé</label>
                                        <input type="text" class="form-control" name="intituler" placeholder="Intitulé du poste" required>
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
                            <div class="panel-heading" id="listePostes">
                                <h3 class="panel-title">Liste des postes</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Identifiant</th>
                                            <th>Nom</th>
                                            <th>Agence</th>
                                            <th>Service</th>
                                            <th>Adresse</th>
                                            <th>Date de création</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($postes as $poste) : ?>
                                            <tr>
                                                <td><?= $poste['id'] ?></td>
                                                <td><?= $poste['intituler'] ?></td>
                                                <td><?= $poste['agence'] ?></td>
                                                <td><?= $poste['service'] ?></td>
                                                <td><?= $poste['adresse'] ?></td>
                                                <td><?= $poste['dat'] ?></td>
                                                <td>
                                                      <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#customer1"><i class="fa fa-pencil"></i></button>
                                                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#customer2"><i class="fa fa-trash-o"></i> </button>
                                                </td>
                                            </tr>
                                            <!-- Modals for Delete -->
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

