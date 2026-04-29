<?php
require_once "../../auth/session.php";
require_once "../../includes/fonctions-auth.php";

verifierSuperAdmin();

$message = "";
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"]);
    $nom_complet = trim($_POST["nom_complet"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);
    $role = trim($_POST["role"]);

    if (
        empty($identifiant) ||
        empty($nom_complet) ||
        empty($mot_de_passe) ||
        empty($role)
    ) {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $utilisateurs = lireUtilisateurs();

        if (trouverUtilisateur($identifiant)) {
            $erreur = "Utilisateur déjà existant.";
        } else {
            $nouveauUser = [
                "identifiant" => $identifiant,
                "mot_de_passe" => password_hash($mot_de_passe, PASSWORD_DEFAULT),
                "role" => $role,
                "nom_complet" => $nom_complet,
                "date_creation" => date("Y-m-d"),
                "actif" => true
            ];

            $utilisateurs[] = $nouveauUser;
            enregistrerUtilisateurs($utilisateurs);

            $message = "Compte créé avec succès 🔥";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter Compte</title>
</head>
<body>

<h2>Créer un compte utilisateur</h2>

<?php if ($message): ?>
    <p style="color:green;"><?php echo $message; ?></p>
<?php endif; ?>

<?php if ($erreur): ?>
    <p style="color:red;"><?php echo $erreur; ?></p>
<?php endif; ?>

<form method="POST">

    <label>Identifiant :</label><br>
    <input type="text" name="identifiant" required><br><br>

    <label>Nom complet :</label><br>
    <input type="text" name="nom_complet" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>

    <label>Rôle :</label><br>
    <select name="role" required>
        <option value="caissier">Caissier</option>
        <option value="manager">Manager</option>
    </select><br><br>

    <button type="submit">Créer le compte</button>

</form>

<br>
<a href="gestion-comptes.php">Gestion des comptes</a>

</body>
</html>