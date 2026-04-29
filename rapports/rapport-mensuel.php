<?php
require_once "../auth/session.php";

$factures = json_decode(file_get_contents("../data/factures.json"), true) ?? [];

$mois_actuel = date("Y-m");
$total_mois = 0;
$nombre_factures = 0;
$factures_du_mois = [];

foreach ($factures as $facture) {
    if (substr($facture["date"], 0, 7) === $mois_actuel) {
        $factures_du_mois[] = $facture;
        $total_mois += $facture["total_ttc"];
        $nombre_factures++;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rapport Mensuel</title>
</head>
<body>

<h2>Rapport Mensuel</h2>

<p><strong>Mois :</strong> <?php echo $mois_actuel; ?></p>
<p><strong>Nombre de factures :</strong> <?php echo $nombre_factures; ?></p>
<p><strong>Total des ventes :</strong> <?php echo $total_mois; ?> CDF</p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID Facture</th>
        <th>Date</th>
        <th>Caissier</th>
        <th>Total TTC</th>
    </tr>

    <?php foreach ($factures_du_mois as $facture): ?>
        <tr>
            <td><?php echo $facture["id_facture"]; ?></td>
            <td><?php echo $facture["date"]; ?></td>
            <td><?php echo $facture["caissier"]; ?></td>
            <td><?php echo $facture["total_ttc"]; ?> CDF</td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>