<?php
$email = "adressemail@gmail.com";
// Inclure le fichier de connexion à la base de données
include('bd.php');

$msg = ''; // Initialisez la variable de message pour éviter les erreurs de non-définition

// Vérifier si un identifiant de fournisseur a été envoyé via POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Exécuter la requête d'UPDATE pour définir visible à 0 (supprimer)
    $update = $variable->prepare('UPDATE fournisseur SET visible = 0 WHERE id = ?');
    if ($update->execute([$id])) {
        $msg = "Fournisseur supprimé avec succès.";
    } else {
        $msg = "Erreur lors de la suppression du fournisseur : " . $update->errorInfo()[2];
    }
}

// Traitement du formulaire d'ajout de fournisseur
// Vérifier si le formulaire d'ajout de fournisseur est soumis
if(isset($_POST['btn']))
 {
    // Récupérer l'identifiant de l'utilisateur
    if (isset($_POST['users'])) {
      $userId = 1;}
   // Vérifier et traiter les données du formulaire
   //if(isset($_POST['nom'], $_POST['ville'], $_POST['fax'], $_POST['email'], $_POST['rue'], $_POST['telephone'], $_POST['postal'], $_POST['site_web'], $_POST['devise'], $_POST['description'], $_POST['taxable'], $_POST['users'])) {
       // Validation des champs

       if(isset($_POST['btn']))
         {
            //Controle du champ nom
            if(isset($_POST['nom']))
            {
                  if(empty(trim($_POST['nom'])))
                  {
                     $error_nom = "Veuillez entrer un nom valide";
                  }
                  else
                  {
                     // Le nom est valide
                     $nom = htmlspecialchars($_POST['nom']);
                  }
            }
            else
            {
                  $error_nom = "Champ obligatoire";
            }
         }
         if(isset($_POST['btn']))
         {
            //Controle du champ ville
            if(isset($_POST['ville']))
            {
                  if(empty(trim($_POST['ville'])))
                  {
                     $error_ville = "Veuillez entrer un nom de ville valide";
                  }
                  else
                  {
                     // Le ville est valide
                     $ville = htmlspecialchars($_POST['ville']);
                  }
            }
            else
            {
                  $error_ville = "Champ obligatoire";
            }
         if(isset($_POST['btn']))
         {
            //Controle du champ fax
            if(isset($_POST['fax']))
            {
                  if(empty(trim($_POST['fax'])))
                  {
                     $error_fax = "Veuillez entrer un fax valide";
                  }
                  else
                  {
                     // Le fax est valide
                     $fax = htmlspecialchars($_POST['fax']);
                  }
            }
            else
            {
                  $error_fax = "Champ obligatoire";
            }
          //Controle du champ email
        if(isset($_POST['email']))
        {
            if(empty($_POST['email']))
            {
                $error_email = "Veuillez entrer une adresse e-mail";
            }
            else
            {
                // Vérifie si l'adresse e-mail est au bon format
                $email = $_POST['email'];
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error_email = "Adresse e-mail invalide";
                } else {
                    // L'adresse e-mail est valide
                    $email = htmlspecialchars($email);

                    // Vérifie si l'adresse e-mail est déjà utilisée
                    $t = $variable->prepare('SELECT COUNT(id) AS nbr FROM fournisseur WHERE email = ?');
                    $t->execute(array($_POST['email']));
                    $ts = $t->fetch();
                    if ($ts['nbr'] > 0) {
                        $error_email = "Cette adresse e-mail est déjà utilisée";
                        }
                    }
            }
        }
        else
        {
            $error_email = "Champ obligatoire";
        }  

          //Controle du champ rue
          if(isset($_POST['rue']))
          {
                if(empty(trim($_POST['rue'])))
                {
                   $error_rue = "Veuillez entrer un rue valide";
                }
                else
                {
                   // La valeur rue est valide
                   $rue = htmlspecialchars($_POST['rue']);
                }
          }
          else
          {
                $error_rue = "Champ obligatoire";
          }

          //Controle du champ tel
          if(isset($_POST['tel']))
          {
                if(empty(trim($_POST['tel'])))
                {
                   $error_tel = "Veuillez entrer un tel valide";
                }
                else
                {
                   // Le tel est valide
                   $tel = htmlspecialchars($_POST['tel']);
                }
          }
          else
          {
                $error_tel = "Champ obligatoire";
          }

          //Controle du champ postal
          if(isset($_POST['postal']))
          {
                if(empty(trim($_POST['postal'])))
                {
                   $error_postal = "Veuillez entrer un postal valide";
                }
                else
                {
                   // Le postal est valide
                   $postal = htmlspecialchars($_POST['postal']);
                }
          }
          else
          {
                $error_postal = "Champ obligatoire";
          }
          //Controle du champ site_web
          if(isset($_POST['site_web']))
          {
                if(empty(trim($_POST['site_web'])))
                {
                   $error_site_web = "Veuillez entrer un site_web valide";
                }
                else
                {
                   // Le site_web est valide
                   $site_web = htmlspecialchars($_POST['site_web']);
                }
          }
          else
          {
                $error_site_web = "Champ obligatoire";
          }
          //Controle du champ devise
          if(isset($_POST['devise']))
          {
                if(empty(trim($_POST['devise'])))
                {
                   $error_devise = "Veuillez entrer un devise valide";
                }
                else
                {
                   // La valeur de devise est valide
                   $devise = htmlspecialchars($_POST['devise']);
                }
          }
          else
          {
                $error_devise = "Champ obligatoire";
          }
         $users = 1;
          //Controle du champ descrition
          if(isset($_POST['descrition']))
          {
                if(empty(trim($_POST['descrition'])))
                {
                   $error_descrition = "Veuillez entrer un descrition valide";
                }
                else
                {
                   // Le descrition est valide
                   $descrition = htmlspecialchars($_POST['descrition']);
                }
          }
          else
          {
                $error_descrition = "Champ obligatoire";
          }

          //Controle du champ taxable
          if(isset($_POST['taxable']))
          {
                if(empty(trim($_POST['taxable'])))
                {
                   $error_taxable = "Veuillez entrer un taxable valide";
                }
                else
                {
                   // Le taxable est valide
                   $taxable = htmlspecialchars($_POST['taxable']);
                }
          }
          else
          {
                $error_taxable = "Champ obligatoire";
          }
         //$taxable = $_POST['taxable'] ; // Par défaut, non taxable
   }
         // Valider les champs requis
         if(empty($nom) || empty($users) ) {
            $msg = "Veuillez saisir votre nom et sélectionner un utilisateur.";
         } else {
            // Préparer la requête d'insertion avec des paramètres
            $sql = 'INSERT INTO fournisseur (nom, description, rue, ville, postal, fax, tel, email, site_web, devise, taxable, users) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )';
                     // Rediriger vers la page actuelle pour éviter la soumission répétée du formulaire
                     header("Location: ".$_SERVER['PHP_SELF']);
                     exit(); 
            // Préparer et exécuter la requête d'insertion avec les valeurs
            $ajout = $variable->prepare($sql);
            $result = $ajout->execute([ $nom, $description, $rue, $ville, $postal, $fax, $tel, $email, $site_web, $devise, $taxable, $users ]);
        // Vérifier si l'insertion a réussi
        if ($result) {
            $msg =
            '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> Fournisseur ajouté avec succès.
           </div>'
            ;
        } else {
            $msg =  '<div class="alert alert-danger alert-dismissible" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <strong>Danger!</strong> Erreur fournisseur non ajouté.
                              </div>' . $ajout->errorInfo()[2];

        }
    }
   }
}

// Sélectionner tous les fournisseurs actifs depuis la base de données
$requete = $variable->prepare('SELECT * FROM fournisseur WHERE visible = 1');
$requete->execute();
$fournisseurs = $requete->fetchAll(PDO::FETCH_ASSOC);
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
               <!--div class="header-icon">
                  <i class="fa fa-users"></i>
               </div-->
               <div class="header-title">
                  <h1>Ajouter un fournisseur</h1>
                  <small>Liste des fournisseurs</small>
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
                              <a class="btn btn-add " href="#listeFournisseurs"> 
                              <i class="fa fa-list"></i>  Liste des fournisseurs </a>  
                           </div>
                        </div>
                        <div class="panel-body">
                        <?php
                        // Afficher le message
                        if (!empty($msg)) {
                           echo "<p>$msg</p>";
                        }
                        ?>
                           <form class="col-sm-12" method="POST" action="add-customer.php">
                             <div class="col-sm-6">
                              <div class="form-group" >
                                 <label>Nom</label>
                                 <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrer votre nom" required>
                                 <?php 
                                 if(isset($error_nom))
                                 {
                                    echo $error_nom;
                                 }
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label>Ville</label>
                                 <input type="text" id="ville" name="ville" class="form-control" placeholder="Entrer votre ville" required>
                                 <?php 
                                 if(isset($error_ville))
                                 {
                                    echo $error_ville;
                                 }
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label>Fax</label>
                                 <input type="text" id="fax" name="fax" class="form-control" placeholder="Entrer votre fax" required>
                                 <?php 
                                 if(isset($error_fax))
                                 {
                                    echo $error_fax;
                                 }
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" id="email" name="email" class="form-control" placeholder="Entrer votre Email" required>
                                    <?php 
                                    if(isset($error_email))
                                    {
                                       echo $error_email;
                                    }
                                    ?>
                              </div>
                              <div class="form-group">
                                 <label>Rue</label>
                                 <input type="text" id="rue" name="rue" class="form-control" placeholder="rue" required>
                                 <?php 
                                 if(isset($error_rue))
                                 {
                                    echo $error_rue;
                                 }
                                 ?>
                              </div>
                             </div>   
                             <div class="col-md-6">
                              <div class="form-group">
                                 <label>Téléphone</label>
                                 <input type="text" id="tel" name="tel" class="form-control" placeholder="telephone" required>
                                 <?php 
                                 if(isset($error_tel))
                                 {
                                    echo $error_tel;
                                 }
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label>Code Postal</label>
                                 <input type="text" id="postal" name="postal" class="form-control" placeholder="code postal" required>
                                 <?php 
                                 if(isset($error_postal))
                                 {
                                    echo $error_postal;
                                 }
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label>Site web</label>
                                 <input type="text" id="site_web" name="site_web" class="form-control" placeholder="site web" required>
                                 <?php 
                                 if(isset($error_site_web))
                                 {
                                    echo $error_site_web;
                                 }
                                 ?>
                              </div>
                              <input type="hidden" name="users" value="<?php echo 1; ?>">
                              <div class="form-group">
                                 <label>Devise</label>
                                 <input type="text" id="devise" name="devise" class="form-control" placeholder="devise" required>
                                 <?php 
                                 if(isset($error_devise))
                                 {
                                    echo $error_devise;
                                 }
                                 ?>
                              </div>
                              <div class="orm-group">
                                        <label for="description">Description :</label>
                                        <textarea id="description" class="form-control" id="description"  name="description" required rows="2" cols="70"></textarea>
                                        <?php 
                                       if(isset($error_descrition))
                                       {
                                          echo $error_descrition;
                                       }
                                       ?>
                              </div>
                            </div>
                              <!--div class="form-group">
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
                              </div-->
                              <div class="form-check">
                                 <label>Taxable</label><br>
                                 <label class="radio-inline">
                                 <input type="radio" name="taxable" value="1" checked="checked">Active</label>
                                 <label class="radio-inline"><input type="radio" name="taxable" value="0" >Imposable</label>
                              </div>
                              <div class="reset-button">
                              <button type="submit" name="btn">Enregistrer</button>
                                 <!--a href="#" class="btn btn-warning">Réinitialiser</a>
                                 <a href="#" class="btn btn-success">Enregistrer</a-->
                                 <?php if(isset($msg)) { echo $msg; } ?>
                              </div>
                           </form>

                           <?php  
                              if(isset($msg))
                              {
                                  echo $msg;
                              }
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                        <?php
                        include("export.php");
                        ?>
                            <div class="panel-heading" id="listeFournisseurs">
                                <h3 class="panel-title">Liste des fournisseurs</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                             <tr>
                                                <th>Identifiant</th>
                                                <th>Nom</th>
                                                <th>Email</th>
                                                <th>Téléphone</th>
                                                <th>Taxable</th>
                                                <th>Action</th>
                                            </tr>
                                    <tbody>
                                            <?php foreach ($fournisseurs as $fournisseur) : ?>
                                                <tr>
                                                    <td><?= $fournisseur['id'] ?></td>
                                                    <td><?= $fournisseur['nom'] ?></td>
                                                    <td><?= $fournisseur['email'] ?></td>
                                                    <td><?= $fournisseur['tel'] ?></td>
                                                    <td><?= $fournisseur['taxable'] == 1 ? 'Oui' : 'Non' ?></td>
                                                    <td>
                                                      <a href="modifierCategorie.php?idCategorie=<?php echo $categorie['idCategorie']; ?>" class="modifier">Modifier</a>
                                                      <a href="#" class="supprimer" data-id="<?= $fournisseur['id'] ?>">Supprimer</a>
                                                    </td>
                                                    <!--td>
                                                      <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#customer1"><i class="fa fa-pencil"></i></button>
                                                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#customer2"><i class="fa fa-trash-o"></i> </button>
                                                    </td-->
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                                
                                <script>
                                    // Attendez que le DOM soit chargé
                                    document.addEventListener("DOMContentLoaded", function() {
                                       // Sélectionnez tous les liens avec la classe "supprimer"
                                       var supprimerLinks = document.querySelectorAll('.supprimer');

                                       // Parcourez chaque lien
                                       supprimerLinks.forEach(function(link) {
                                             // Ajoutez un écouteur d'événement de clic à chaque lien
                                             link.addEventListener('click', function(event) {
                                                // Empêchez le comportement par défaut du lien (ne pas suivre le lien)
                                                event.preventDefault();

                                                // Récupérez l'identifiant du fournisseur à supprimer depuis l'attribut data-id
                                                var fournisseurId = this.getAttribute('data-id');

                                                // Construisez l'URL pour la suppression du fournisseur
                                                var url = 'supprimer-fournisseur.php'; // Remplacez cela par l'URL correcte de votre script de suppression

                                                // Envoyez une requête AJAX au serveur
                                                fetch(url, {
                                                   method: 'POST',
                                                   body: JSON.stringify({ id: fournisseurId }), // Envoyez l'identifiant du fournisseur dans le corps de la requête
                                                   headers: {
                                                         'Content-Type': 'application/json' // Indiquez que le contenu est JSON
                                                   }
                                                })
                                                .then(response => {
                                                   // Vérifiez si la réponse est OK (200)
                                                   if (response.ok) {
                                                         // Rafraîchissez la page ou effectuez une autre action
                                                         location.reload(); // Rechargez la page pour mettre à jour la liste des fournisseurs
                                                   } else {
                                                         // Gérez les erreurs de réponse ici
                                                         console.error('Erreur lors de la suppression du fournisseur');
                                                   }
                                                })
                                                .catch(error => {
                                                   // Gérez les erreurs de requête ici
                                                   console.error('Erreur lors de la requête AJAX :', error);
                                                });
                                             });
                                       });
                                    });
                                 </script>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
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