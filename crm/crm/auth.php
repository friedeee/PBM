<?php
include('bd.php');

// Vérification des identifiants
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Remplacez ceci par votre logique d'authentification réelle en utilisant la base de données
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
        // Définir le mode d'erreur PDO sur exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = friedboton@gmail.com");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Vérifier si l'utilisateur existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['friedboton123'])) {
                // Authentification réussie, rediriger vers une page sécurisée
                header("Location: welcome.php");
                exit();
            } else {
                // Mot de passe incorrect
                header("Location: index.html?message=Mot%20de%20passe%20incorrect.");
                exit();
            }
        } else {
            // Utilisateur non trouvé
            header("Location: index.html?message=Utilisateur%20non%20trouvé.");
            exit();
        }
    } catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Authentification</title>

    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    width: 300px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

h2 {
    text-align: center;
    color: #333;
}

.input-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 8px;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 3px;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 3px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Authentification</h2>
        <form id="loginForm" method="post" action="login.php">
            <div class="input-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
            <p id="message"><?php if(isset($_GET['message'])) { echo $_GET['message']; } ?></p>
        </form>
    </div>
</body>
</html>
