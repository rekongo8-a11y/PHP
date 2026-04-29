<?php
require_once "../../auth/session.php";
require_once "../../includes/fonctions-produits.php";

$message = "";
$erreur = "";
$produit = null;
$total_ht = 0;
$tva = 0;
$total_ttc = 0;
$quantite = 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $code_barre = trim($_POST["code_barre"]);
    $quantite = (int) $_POST["quantite"];

    $produit = produitExiste($code_barre);

    if (!$produit) {
        $erreur = "Produit introuvable. Faites appel au Manager.";
    }

    elseif ($quantite <= 0) {
        $erreur = "Quantité invalide.";
    }

    elseif ($quantite > $produit["quantite_stock"]) {
        $erreur = "Stock insuffisant.";
    }

    else {

        $total_ht = $produit["prix_unitaire_ht"] * $quantite;
        $tva = $total_ht * 0.16;
        $total_ttc = $total_ht + $tva;

        $fichierFactures = "../../data/factures.json";
        $factures = [];

        if (file_exists($fichierFactures)) {
            $factures = json_decode(
                file_get_contents($fichierFactures),
                true
            ) ?? [];
        }

        $nouvelleFacture = [
            "id_facture" => "FAC-" . date("Ymd-His"),
            "date" => date("Y-m-d"),
            "heure" => date("H:i:s"),
            "caissier" => $_SESSION["utilisateur"]["identifiant"],

            "articles" => [
                [
                    "code_barre" => $produit["code_barre"],
                    "nom" => $produit["nom"],
                    "prix_unitaire_ht" => $produit["prix_unitaire_ht"],
                    "quantite" => $quantite,
                    "sous_total_ht" => $total_ht
                ]
            ],

            "total_ht" => $total_ht,
            "tva" => $tva,
            "total_ttc" => $total_ttc
        ];

        $factures[] = $nouvelleFacture;

        file_put_contents(
            $fichierFactures,
            json_encode(
                $factures,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );

        $produits = lireProduits();

        foreach ($produits as &$p) {
            if ($p["code_barre"] === $code_barre) {
                $p["quantite_stock"] -= $quantite;
            }
        }

        enregistrerProduits($produits);

        $message = "Facture enregistrée automatiquement 🔥";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Facture</title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff5f7;
            padding: 40px;
            color: #3b1f2b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #8b3a4a;
            font-size: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        #reader {
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #8b3a4a;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border: 1px solid #f3d9df;
            border-radius: 10px;
            background: #fffafb;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: #c96b7a;
            color: white;
            font-size: 15px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #b85b6b;
        }

        .success {
            background: #f0fff4;
            color: #166534;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error {
            background: #fff1f2;
            color: #be123c;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .invoice-box {
            margin-top: 25px;
            padding: 20px;
            background: #fffafb;
            border: 1px solid #f3d9df;
            border-radius: 14px;
        }

        .invoice-box h3 {
            color: #8b3a4a;
            margin-bottom: 15px;
        }

        .invoice-box p {
            margin-bottom: 10px;
            color: #5c3a44;
        }

        .bottom-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .link-btn {
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }

        .factures-btn {
            background: #f7a8b8;
            color: #3b1f2b;
        }

        .factures-btn:hover {
            background: #ef8ea2;
        }

        .back-btn {
            background: #8b3a4a;
            color: white;
        }

        .back-btn:hover {
            background: #6f2d3a;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>🧾 Nouvelle Facture</h2>

    <?php if ($message): ?>
        <div class="success">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <?php if ($erreur): ?>
        <div class="error">
            <?php echo $erreur; ?>
        </div>
    <?php endif; ?>

    <div class="grid">

        <div class="card">
            <h3 style="margin-bottom:20px; color:#8b3a4a;">
                📷 Scanner Code-Barres
            </h3>

            <div id="reader"></div>
        </div>

        <div class="card">
            <h3 style="margin-bottom:20px; color:#8b3a4a;">
                📝 Informations Facture
            </h3>

            <form method="POST" id="factureForm">

                <label>Code-barres scanné</label>
                <input
                    type="text"
                    name="code_barre"
                    id="code_barre"
                    required
                    readonly
                >

                <label>Quantité vendue</label>
                <input
                    type="number"
                    name="quantite"
                    id="quantite"
                    value="1"
                    min="1"
                    required
                >

                <button type="submit">
                    Enregistrer automatiquement
                </button>

            </form>

            <?php if ($produit && !$erreur): ?>
                <div class="invoice-box">
                    <h3>📄 Résumé Facture</h3>

                    <p><strong>Produit :</strong> <?php echo $produit["nom"]; ?></p>
                    <p><strong>Prix HT :</strong> <?php echo $produit["prix_unitaire_ht"]; ?> CDF</p>
                    <p><strong>Quantité :</strong> <?php echo $quantite; ?></p>
                    <p><strong>Total HT :</strong> <?php echo $total_ht; ?> CDF</p>
                    <p><strong>TVA (16%) :</strong> <?php echo $tva; ?> CDF</p>
                    <p><strong>Net à payer :</strong> <?php echo $total_ttc; ?> CDF</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="bottom-actions">
        <a href="afficher-facture.php" class="link-btn factures-btn">
            📄 Liste des factures
        </a>

        <a href="../../index.php" class="link-btn back-btn">
            ⬅ Retour Dashboard
        </a>
    </div>

</div>

<script>
function onScanSuccess(decodedText, decodedResult) {
    document.getElementById("code_barre").value = decodedText;

    document.getElementById("factureForm").submit();
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    {
        fps: 10,
        qrbox: 250
    }
);

html5QrcodeScanner.render(onScanSuccess);
</script>

</body>
</html>