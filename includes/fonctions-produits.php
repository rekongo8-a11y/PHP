<?php

function lireProduits() {
    $fichier = __DIR__ . '/../data/produits.json';

    if (!file_exists($fichier)) {
        return [];
    }

    $contenu = file_get_contents($fichier);
    return json_decode($contenu, true) ?? [];
}

function enregistrerProduits($produits) {
    $fichier = __DIR__ . '/../data/produits.json';
    file_put_contents($fichier, json_encode($produits, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function produitExiste($code_barre) {
    $produits = lireProduits();

    foreach ($produits as $produit) {
        if ($produit["code_barre"] === $code_barre) {
            return $produit;
        }
    }

    return false;
}