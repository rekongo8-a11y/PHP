<?php
require_once "../auth/session.php";

$factures = json_decode(file_get_contents("../data/factures.json"), true) ?? [];

$date_du_jour = date("Y-m-d");
$total_jour = 0;
$nombre_factures = 0;
$factures_du_jour = [];

foreach ($factures as $facture) {
    if ($facture["date"] === $date_du_jour) {
        $factures_du_jour[] = $facture;
        $total_jour += $facture["total_ttc"];
        $nombre_factures++;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rapport Journalier</title>
</head>
<body>

<h2>Rapport Journalier</h2>

<p><strong>Date :</strong> <?php echo $date_du_jour; ?></p>
<p><strong>Nombre de factures :</strong> <?php echo $nombre_factures; ?></p>
<p><strong>Total des ventes :</strong> <?php echo $total_jour; ?> CDF</p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID Facture</th>
        <th>Heure</th>
        <th>Caissier</th>
        <th>Total TTC</th>
    </tr>

    <?php foreach ($factures_du_jour as $facture): ?>
        <tr>
            <td><?php echo $facture["id_facture"]; ?></td>
            <td><?php echo $facture["heure"]; ?></td>
            <td><?php echo $facture["caissier"]; ?></td>
            <td><?php echo $facture["total_ttc"]; ?> CDF</td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>