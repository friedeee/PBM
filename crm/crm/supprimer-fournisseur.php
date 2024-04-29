<?php
// Inclure le fichier de connexion à la base de données
include('bd.php');

// Vérifier si des données POST ont été envoyées et si elles contiennent l'identifiant du fournisseur à supprimer
if (isset($_POST['id'])) {
    // Récupérer l'identifiant du fournisseur à partir des données POST
    $id = $_POST['id'];

    try {
        // Préparer et exécuter la requête d'UPDATE pour définir visible à 0 (supprimer)
        $update = $variable->prepare('UPDATE fournisseur SET visible = 0 WHERE id = ?');
        $result = $update->execute([$id]);

        
        // Vérifier si la requête a réussi
        if ($result) {
            // Envoyer une réponse HTTP 200 (OK) pour indiquer que la suppression a réussi
            http_response_code(200);
            echo json_encode(['message' => '
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Success!</strong> Fournisseur supprimé avec succès.
                                </div>']);
        } else {
            // Envoyer une réponse HTTP 500 (Erreur interne du serveur) en cas d'échec de la requête
            http_response_code(500);
            echo json_encode(['message' =>
                                '<div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Danger!</strong> Erreur lors de la suppression du fournisseur.
                                </div>'
        ]);
        }
    } catch (PDOException $e) {
        // Envoyer une réponse HTTP 500 (Erreur interne du serveur) en cas d'erreur PDO
        http_response_code(500);
        echo json_encode(['message' => '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Danger!</strong> Erreur lors de la suppression du fournisseur.
    </div>' . $e->getMessage()]);
    }
} else {
    // Envoyer une réponse HTTP 400 (Requête incorrecte) si l'identifiant du fournisseur n'a pas été fourni
    http_response_code(400);
    echo json_encode(['message' =>
    '<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Warning!</strong> Identifiant du fournisseur manquant dans la requête.']);
}
