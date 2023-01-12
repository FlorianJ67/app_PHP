<?php
    session_start();
    include "functions.php";

    // remember to look for preg_filter(pattern, replacement, input, limit, count)
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device_width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <title>Ajout produit</title>
    </head>
    <body>
        <header>
            <nav>
                <a href="index.php">
                    <i class="fa fa-home"></i>
                </a>
                <ul>
                    <li>
                        <a href="index.php">INDEX</a>
                    </li>
                    <li>
                        <a href="recap.php">RÉCAP</a>
                    </li>
                </ul>
                <a href="recap.php" <?php if(nbProduits() == null || nbProduits() == 0){echo "style= 'display: none'"; } ?>>
                    <i class="fa fa-shopping-cart"></i>
                    <p id="shoppingCart"><?=nbProduits()?></p>
                </a>
            </nav>
        </header>
        <div id="container">
            <div id="createProduct">

                <h1>Ajouter un produit</h1>
                <form action="traitement.php?action=ajouterProduit" method="post">
                    <p>
                        <label>
                            Nom du produit :
                            <input type="text" name="name">
                        </label>
                    </p>
                    <p>
                        <label>
                            Prix du produit :
                            <input type="number" step="any" name="price" min="0">
                        </label>
                    </p>
                    <p>
                        <label>
                            Quantité désirée :
                            <input type="number" name="qtt" value="1" min="0">
                        </label>
                    </p>
                    <p >
                        <input type="submit" name="submit" value="Ajouter le produit">
                    </p>
                </form>
            </div>
            <?php 
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                } 
            ?>
        </div>
            
        
</body>
</html>