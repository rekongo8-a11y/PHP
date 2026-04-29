<?php
require_once "../../auth/session.php";
require_once "../../includes/fonctions-produits.php";

$produits = lireProduits();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste Produits</title>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>

<h2>Liste des Produits</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Code-barres</th>
        <th>Nom</th>
        <th>Prix HT</th>
        <th>Expiration</th>
        <th>Stock</th>
    </tr>

    <?php foreach ($produits as $produit): ?>
        <tr>

            <td>
                <?php echo $produit["code_barre"]; ?>

                <br><br>

                <svg id="barcode-<?php echo $produit["code_barre"]; ?>"></svg>

                <br><br>

                <button onclick="telechargerPDF('<?php echo $produit['code_barre']; ?>')">
                    Télécharger PDF
                </button>

                <script>
                    JsBarcode(
                        "#barcode-<?php echo $produit["code_barre"]; ?>",
                        "<?php echo $produit["code_barre"]; ?>",
                        {
                            format: "CODE128",
                            width: 2,
                            height: 50,
                            displayValue: false
                        }
                    );
                </script>
            </td>

            <td><?php echo $produit["nom"]; ?></td>
            <td><?php echo $produit["prix_unitaire_ht"]; ?> CDF</td>
            <td><?php echo $produit["date_expiration"]; ?></td>
            <td><?php echo $produit["quantite_stock"]; ?></td>

        </tr>
    <?php endforeach; ?>

</table>

<br>
<a href="enregistrer.php">Ajouter un produit</a>

<script>
async function telechargerPDF(codeBarre) {
    const { jsPDF } = window.jspdf;

    let svg = document.getElementById("barcode-" + codeBarre);

    let serializer = new XMLSerializer();
    let svgString = serializer.serializeToString(svg);

    let canvas = document.createElement("canvas");
    let ctx = canvas.getContext("2d");

    let img = new Image();

    let svgBlob = new Blob([svgString], {
        type: "image/svg+xml;charset=utf-8"
    });

    let url = URL.createObjectURL(svgBlob);

    img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;

        ctx.drawImage(img, 0, 0);

        let imgData = canvas.toDataURL("image/png");

        let pdf = new jsPDF();

        pdf.text("Code Barre Produit", 20, 20);
        pdf.addImage(imgData, "PNG", 15, 30, 180, 50);

        pdf.save("barcode-" + codeBarre + ".pdf");

        URL.revokeObjectURL(url);
    };

    img.src = url;
}
</script>

</body>
</html>