<?php
require_once "auth/session.php";

$user = $_SESSION["utilisateur"];
$role = $user["role"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FacturationPro</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff5f7;
            display: flex;
            color: #3b1f2b;
        }

        .sidebar {
            width: 270px;
            height: 100vh;
            background: #8b3a4a;
            color: white;
            padding: 30px 20px;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 26px;
            color: #ffd6de;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
            padding: 14px 16px;
            margin-bottom: 12px;
            border-radius: 10px;
            transition: 0.3s;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #a94f61;
        }

        .sidebar i {
            width: 20px;
            text-align: center;
        }

        .logout {
            background: #5f2230;
            margin-top: 30px;
        }

        .logout:hover {
            background: #4a1a25;
        }

        .main-content {
            margin-left: 270px;
            padding: 40px;
            width: 100%;
        }

        .welcome-box {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .welcome-box h1 {
            margin-bottom: 10px;
            color: #8b3a4a;
            font-size: 30px;
        }

        .welcome-box p {
            font-size: 16px;
            color: #6b4a57;
        }

        .welcome-box strong {
            color: #c96b7a;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card h3 {
            color: #c96b7a;
            margin-bottom: 12px;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card p {
            color: #7b5b67;
            line-height: 1.6;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>FacturationPro</h2>

    <a href="index.php">
        <i class="fas fa-house"></i>
        Tableau de bord
    </a>
    <a href="modules/facturation/afficher-facture.php">
        <i class="fas fa-file-invoice"></i>
        Liste des factures
    </a>
    <?php if ($role === "manager" || $role === "super_admin"): ?>
        <a href="modules/produits/enregistrer.php">
            <i class="fas fa-box-open"></i>
            Enregistrer produit
        </a>

        <a href="modules/produits/liste.php">
            <i class="fas fa-list"></i>
            Liste produits
        </a>

        <a href="rapports/rapport-journalier.php">
            <i class="fas fa-chart-column"></i>
            Rapport journalier
        </a>

        <a href="rapports/rapport-mensuel.php">
            <i class="fas fa-chart-line"></i>
            Rapport mensuel
        </a>
    <?php endif; ?>

    <?php if ($role === "super_admin"): ?>
        <a href="modules/admin/gestion-comptes.php">
            <i class="fas fa-users"></i>
            Gestion utilisateurs
        </a>

       
    <?php endif; ?>

    <a href="auth/logout.php" class="logout">
        <i class="fas fa-right-from-bracket"></i>
        Déconnexion
    </a>
</div>

<div class="main-content">

    <div class="welcome-box">
        <h1>
            Bienvenue <?php echo htmlspecialchars($user["nom_complet"]); ?>
        </h1>

        <p>
            Connecté en tant que :
            <strong><?php echo htmlspecialchars($role); ?></strong>
        </p>
    </div>

    <div class="cards">

        <div class="card">
            <h3>
                <i class="fas fa-receipt"></i>
                Facturation
            </h3>
            <p>
                Scanner les articles, générer automatiquement
                les factures et gérer les ventes.
            </p>
        </div>

        <div class="card">
            <h3>
                <i class="fas fa-box-open"></i>
                Produits
            </h3>
            <p>
                Ajouter de nouveaux produits, gérer les stocks
                et afficher les codes-barres.
            </p>
        </div>

        <div class="card">
            <h3>
                <i class="fas fa-chart-pie"></i>
                Rapports
            </h3>
            <p>
                Consulter les ventes journalières et mensuelles
                avec les statistiques globales.
            </p>
        </div>

        <div class="card">
            <h3>
                <i class="fas fa-user-shield"></i>
                Administration
            </h3>
            <p>
                Gérer les comptes utilisateurs et contrôler
                les accès selon les rôles.
            </p>
        </div>

    </div>

</div>

</body>
</html>