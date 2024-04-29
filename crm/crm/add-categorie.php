<?php
include('bd.php');

$msg = ''; // Initialisez la variable de message pour éviter les erreurs de non-définition

// Vérifier si le formulaire d'ajout de catégorie est soumis
if(isset($_POST['btn'])) {
    // Vérifier et traiter les données du formulaire
    if(isset($_POST['code'], $_POST['intituler'])) {
        // Validation des champs
        $code = trim($_POST['code']);
        $intituler = trim($_POST['intituler']);

        if(empty($code) || empty($intituler)) {
            $msg = "Veuillez remplir tous les champs.";
        } else {
            // Insérer les données de la catégorie dans la base de données
            $ajout = $variable->prepare('INSERT INTO categorie(code, intituler) VALUES (?, ?)');
            if($ajout->execute([$code, $intituler])) {
                $msg = "La catégorie a été ajoutée avec succès.";
            } else {
                $msg = "Une erreur s'est produite lors de l'ajout de la catégorie.";  
            }
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
    }
}
// Sélectionner toutes les catégories actives depuis la base de données
$requete = $variable->prepare('SELECT * FROM categorie WHERE visible = 1');
$requete->execute();
$categories = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php
    include("head.php");
?>
   <body class="hold-transition sidebar-mini">
   <!--preloader-->
      <div id="preloader">
         <div id="status"></div>
      </div>
      <!-- Site wrapper -->
      <div class="wrapper">
         <?php
         include("header.php");
         ?>
         <!-- =============================================== -->
         <!-- Left side column. contains the sidebar -->
         
         <?php
         include("sidebar.php");
         ?>
         <!-- =============================================== -->
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-users"></i>
               </div>
               <div class="header-title">
                  <h1>Ajouter une catégorie</h1>
                  <small>Liste des catégories</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonlist"> 
                              <a class="btn btn-add " href="#listeCategories"> 
                              <i class="fa fa-list"></i>  Liste des catégories </a>  
                           </div>
                        </div>
                        <div class="panel-body">
                        <?php if (!empty($msg)) : ?>
                                    <p><?php echo $msg; ?></p>
                                <?php endif; ?>
                           <form class="col-sm-6" method="POST" action="add-categorie.php">
                              <div class="form-group">
                                 <label>Code</label>
                                 <input type="text" class="form-control" name="code" placeholder="Entrer le code" required>
                              </div>
                              <div class="form-group">
                                 <label>Titre</label>
                                 <input type="text" class="form-control" name="intituler" placeholder="Entrer le titre" required>
                              </div>
                              <!--div class="form-group">
                                 <label>Fax</label>
                                 <input type="text" class="form-control" placeholder="Entrer votre fax" required>
                              </div>
                              <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" class="form-control" placeholder="Entrer votre Email" required>
                              </div>
                              <div class="form-group">
                                 <label>Rue</label>
                                 <input type="text" class="form-control" placeholder="rue" required>
                              </div>
                              <div class="form-group">
                                 <label>Téléphone</label>
                                 <input type="number" class="form-control" placeholder="telephone" required>
                              </div>
                              <div class="form-group">
                                 <label>Code Postal</label>
                                 <input type="text" class="form-control" placeholder="code postal" required>
                              </div>
                              <div class="form-group">
                                 <label>Site web</label>
                                 <input type="text" class="form-control" placeholder="siteweb" required>
                              </div>
                              <div class="form-group">
                                 <label>Devise</label>
                                 <input type="text" class="form-control" placeholder="devise" required>
                              </div>
                              <div class="form-group">
                                 <label>Picture upload</label>
                                 <input type="file" name="picture">
                                 <input type="hidden" name="old_picture">
                              </div>
                              <div class="form-group">
                                 <label>Bank details</label>
                                 <input type="text" class="form-control" placeholder="Enter Bank details" required>
                              </div>
                              <div class="form-group">
                                 <label>Passport</label>
                                 <input type="text" class="form-control" placeholder="Enter Passport details" required>
                              </div>
                              <div class="form-group">
                                 <label>Facebook Id</label>
                                 <input type="text" class="form-control" placeholder="Enter Facebook details" required>
                              </div>
                              <div class="form-group">
                                 <label>Date of Birth</label>
                                 <input id='minMaxExample' type="text" class="form-control" placeholder="Enter Date...">
                              </div>
                              <div class="form-group">
                                 <label>Address</label>
                                 <textarea class="form-control" rows="3" required></textarea>
                              </div>
                              <div class="form-group">
                                 <label>Customer type</label>
                                 <select class="form-control">
                                    <option>vendor</option>
                                    <option>vip</option>
                                    <option>regular</option>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label>Sex</label><br>
                                 <label class="radio-inline"><input name="sex" value="1" checked="checked" type="radio">Male</label> 
                                 <label class="radio-inline"><input name="sex" value="0" type="radio">Female</label>
                              </div>
                              <div class="form-check">
                                 <label>Status</label><br>
                                 <label class="radio-inline">
                                 <input type="radio" name="status" value="1" checked="checked">Active</label>
                                 <label class="radio-inline"><input type="radio" name="status" value="0" >Inctive</label>
                              </div-->
                              <!--div class="reset-button">
                                 <a href="#" class="btn btn-warning">Réinitialiser</a>
                                 <a href="#" class="btn btn-success">Enregistrer</a>
                              </div-->
                              <button type="submit" name="btn">Ajouter</button>
                              <?php if(isset($msg)) { echo $msg; } ?>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                        <?php
                            include("export.php");
                            ?>
                            <div class="panel-heading" id="listeCategories">
                            
                                <h3 class="panel-title">Liste des catégories</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Identifiant</th>
                                            <th>Code</th>
                                            <th>Titre</th>
                                            <th>Date de création</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $categorie) : ?>
                                            <tr>
                                                <td><?= $categorie['id'] ?></td>
                                                <td><?= $categorie['code'] ?></td>
                                                <td><?= $categorie['intituler'] ?></td>
                                                <td><?= $categorie['dat'] ?></td>
                                                <td><?= $categorie['users'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#editCategory<?= $categorie['id'] ?>"><i class="fa fa-pencil"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCategory<?= $categorie['id'] ?>"><i class="fa fa-trash-o"></i></button>
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
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php
         include("footer.php");?>
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

