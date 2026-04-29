<?php
require_once "../../auth/session.php";
require_once "../../includes/fonctions-auth.php";

verifierSuperAdmin();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $utilisateurs = lireUtilisateurs();

    $nouvelleListe = [];

    foreach ($utilisateurs as $user) {
        if ($user["identifiant"] !== $id) {
            $nouvelleListe[] = $user;
        }
    }

    enregistrerUtilisateurs($nouvelleListe);
}

header("Location: gestion-comptes.php");
exit();