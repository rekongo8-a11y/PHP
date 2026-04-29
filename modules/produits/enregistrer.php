<?php
require_once "../../auth/session.php";
require_once "../../includes/fonctions-produits.php";

$message = "";
$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code_barre = trim($_POST["code_barre"]);
    $nom = trim($_POST["nom"]);
    $prix = trim($_POST["prix"]);
    $date_expiration = trim($_POST["date_expiration"]);
    $quantite = trim($_POST["quantite"]);

    if (
        empty($code_barre) ||
        empty($nom) ||
        empty($prix) ||
        empty($date_expiration) ||
        empty($quantite)
    ) {
        $erreur = "Tous les champs sont obligatoires.";
    }
    elseif (produitExiste($code_barre)) {
        $erreur = "Ce produit existe déjà.";
    }
    elseif (!is_numeric($prix) || $prix <= 0) {
        $erreur = "Prix invalide.";
    }
    elseif (!is_numeric($quantite) || $quantite < 0) {
        $erreur = "Quantité invalide.";
    }
    else {
        $produits = lireProduits();

        $nouveauProduit = [
            "code_barre" => $code_barre,
            "nom" => $nom,
            "prix_unitaire_ht" => (float)$prix,
            "date_expiration" => $date_expiration,
            "quantite_stock" => (int)$quantite,
            "date_enregistrement" => date("Y-m-d")
        ];

        $produits[] = $nouveauProduit;
        enregistrerProduits($produits);

        $message = "Produit enregistré avec succès 🔥";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enregistrer Produit</title>
</head>
<body>

<h2>Enregistrement Produit</h2>

<?php if ($message): ?>
    <p style="color:green;"><?php echo $message; ?></p>
<?php endif; ?>

<?php if ($erreur): ?>
    <p style="color:red;"><?php echo $erreur; ?></p>
<?php endif; ?>

<form method="POST">

    <label>Code-barres :</label><br>
    <input type="text" name="code_barre" required><br><br>

    <label>Nom du produit :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Prix unitaire HT :</label><br>
    <input type="number" name="prix" required><br><br>

    <label>Date expiration :</label><br>
    <input type="date" name="date_expiration" required><br><br>

    <label>Quantité stock :</label><br>
    <input type="number" name="quantite" required><br><br>

    <button type="submit">Enregistrer</button>

</form>

<br>
<a href="liste.php">Voir la liste des produits</a>

</body>
</html>