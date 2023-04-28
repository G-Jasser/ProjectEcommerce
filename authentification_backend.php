
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <style>
    label { display: block; }
    input[type="submit"] { margin-top: 10px; }
    .error { color: red; }
  </style>
</head>
<body>
  <h1>Inscription</h1>
  <?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
  <?php endif; ?>
  <form method="post">
    <label for="email">Adresse email :</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="S'inscrire">
  </form>
</body>
</html>

<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les données du formulaire
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Vérifier que l'adresse email est valide
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Adresse email invalide.";
  }

  // Vérifier que le mot de passe est suffisamment fort
  if (strlen($password) < 8) {
    $error = "Le mot de passe doit comporter au moins 8 caractères.";
  }

  // Si les données sont valides, les stocker dans la base de données
  if (!isset($error)) {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=nom_de_la_base_de_donnees', 'nom_d_utilisateur', 'mot_de_passe');

    // Préparer la requête SQL
    $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
    $stmt->execute(array(
      ':email' => $email,
      ':password' => password_hash($password, PASSWORD_DEFAULT)
    ));

    // Rediriger l'utilisateur vers une page de confirmation
    header('Location: autrepage.php');
    exit;
  }
}
?>
