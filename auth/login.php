<?php
session_start();
require_once "../includes/fonctions-auth.php";

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    $user = trouverUtilisateur($identifiant);

    if ($user && password_verify($mot_de_passe, $user["mot_de_passe"])) {
        $_SESSION["utilisateur"] = $user;

        header("Location: ../index.php");
        exit();
    } else {
        $erreur = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<?php if ($erreur): ?>
    <p style="color:red;"><?php echo $erreur; ?></p>
<?php endif; ?>

<form method="POST">
    <label>Identifiant :</label><br>
    <input type="text" name="identifiant" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>