<?php
require_once "../../auth/session.php";

$factures = json_decode(
    file_get_contents("../../data/factures.json"),
    true
) ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>

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
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #8b3a4a;
            font-size: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 14px;
        }

        th {
            background: #c96b7a;
            color: white;
            padding: 16px;
            font-size: 15px;
        }

        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #f3d9df;
            background: #fffafb;
        }

        tr:hover td {
            background: #fff0f3;
        }

        .total {
            font-weight: bold;
            color: #8b3a4a;
        }

        .bottom-actions {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn,
        .new-btn {
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }

        .new-btn {
            background: #f7a8b8;
            color: #3b1f2b;
        }

        .new-btn:hover {
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

    <h2>📄 Liste des Factures</h2>

    <table>
        <tr>
            <th>ID Facture</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Caissier</th>
            <th>Total HT</th>
            <th>TVA</th>
            <th>Total TTC</th>
        </tr>

        <?php foreach ($factures as $facture): ?>
            <tr>
                <td><?php echo htmlspecialchars($facture["id_facture"]); ?></td>
                <td><?php echo htmlspecialchars($facture["date"]); ?></td>
                <td><?php echo htmlspecialchars($facture["heure"]); ?></td>
                <td><?php echo htmlspecialchars($facture["caissier"]); ?></td>
                <td><?php echo $facture["total_ht"]; ?> CDF</td>
                <td><?php echo $facture["tva"]; ?> CDF</td>
                <td class="total">
                    <?php echo $facture["total_ttc"]; ?> CDF
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

    <div class="bottom-actions">

        <a href="nouvelle-facture.php" class="new-btn">
             Nouvelle facture
        </a>

        <a href="../../index.php" class="back-btn">
            Retour Dashboard
        </a>

    </div>

</div>

</body>
</html>