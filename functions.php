<?php

// session_start();

function nbProduits() {
    if(isset($_SESSION["products"]) && !empty($_SESSION["products"])){
        $totalProduct = 0;
        foreach ($_SESSION["products"] as $product) {
            while ( $product['qtt'] > 0) {
                $product['qtt']--;
                $totalProduct++;
            }

        }
        echo " " . $totalProduct;
    }
}

?>