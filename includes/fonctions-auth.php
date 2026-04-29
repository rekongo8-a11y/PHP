<?php

function lireUtilisateurs() {
    $fichier = __DIR__ . '/../data/utilisateurs.json';

    if (!file_exists($fichier)) {
        return [];
    }

    $contenu = file_get_contents($fichier);
    return json_decode($contenu, true) ?? [];
}

function trouverUtilisateur($identifiant) {
    $utilisateurs = lireUtilisateurs();

    foreach ($utilisateurs as $user) {
        if ($user['identifiant'] === $identifiant) {
            return $user;
        }
    }

    return null;
}

function enregistrerUtilisateurs($utilisateurs) {
    $fichier = __DIR__ . '/../data/utilisateurs.json';

    file_put_contents(
        $fichier,
        json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}

function verifierSuperAdmin() {
    if (
        !isset($_SESSION["utilisateur"]) ||
        $_SESSION["utilisateur"]["role"] !== "super_admin"
    ) {
        die("Accès refusé. Super Administrateur uniquement.");
    }
}