
<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $remember = isset($_POST['remember']) ? 1 : 0;
		
        // Créez votre requête SQL en utilisant des paramètres préparés pour éviter les attaques par injection SQL
        $sql = "INSERT INTO last (username, password, remember) VALUES (?, ?, ?)";
        
        // Préparez la requête
        $stmt = $conn->prepare($sql);
        
        // Liez les paramètres et exécutez la requête
        $stmt->bind_param("ssi", $username, $password, $remember);
        
        if ($stmt->execute()) {
            echo "Les données ont été enregistrées avec succès dans la base de données.";
        } else {
            echo "Erreur lors de l'insertion des données : " . $stmt->error;
        }
    } else {
        echo "Les données 'username' et 'password' n'ont pas été correctement soumises.";
    }
}


$conn->close();
?>