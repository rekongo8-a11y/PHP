<?php
require_once "../../auth/session.php";
require_once "../../includes/fonctions-auth.php";

verifierSuperAdmin();

$utilisateurs = lireUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Comptes</title>

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
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #c96b7a;
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

        .delete-btn {
            text-decoration: none;
            background: #8b3a4a;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s;
            display: inline-block;
        }

        .delete-btn:hover {
            background: #6f2d3a;
        }

        .protected {
            color: #999;
            font-weight: bold;
        }

        .bottom-actions {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add-btn,
        .back-btn {
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }

        .add-btn {
            background: #f7a8b8;
            color: #3b1f2b;
        }

        .add-btn:hover {
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

    <h2>👥 Gestion des Utilisateurs</h2>

    <table>
        <tr>
            <th>Identifiant</th>
            <th>Nom complet</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>

        <?php foreach ($utilisateurs as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user["identifiant"]); ?></td>
                <td><?php echo htmlspecialchars($user["nom_complet"]); ?></td>
                <td><?php echo htmlspecialchars($user["role"]); ?></td>
                <td>
                    <?php if ($user["identifiant"] !== "superadmin"): ?>
                        <a
                            class="delete-btn"
                            href="supprimer-compte.php?id=<?php echo urlencode($user["identifiant"]); ?>"
                        >
                            Supprimer
                        </a>
                    <?php else: ?>
                        <span class="protected">Protégé</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

    <div class="bottom-actions">
        <a href="ajouter-compte.php" class="add-btn">
             Ajouter un compte
        </a>

        <a href="../../index.php" class="back-btn">
            ⬅ Retour Dashboard
        </a>
    </div>

</div>

</body>
</html>