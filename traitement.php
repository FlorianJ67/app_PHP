<?php
    session_start();

    switch($_GET["action"]){

        case "ajouterProduit" :
            if(isset($_POST['submit'])){
        
                $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
        
                if($name && $price && $qtt){
        
                    $product = [
                        "name" => $name,
                        "price" => $price,
                        "qtt" => $qtt,
                        "total" => $price*$qtt
                    ];
        
                    $_SESSION['products'][] = $product;

                    // stock the last product info to display it when submiting
                    if($product['qtt'] > 1){
                        // more than 1 article
                        $_SESSION['message'] = "<div class='message' ><p>Le dernier produit ajouter est :<br>«" . ucfirst($product['name']) . "» en " . $product['qtt'] . " exemplaires à " . $product['price'] . "€ l'unité </p></div>";
                    } else {
                        // 1 article
                        $_SESSION['message'] = "<div class='message' ><p>Le dernier produit ajouter est :<br>«" . ucfirst($product['name']) . "» en " . $product['qtt'] . " exemplaire à " . $product['price'] . "€ l'unité </p></div>";
        
                    }

                } else {
                    // stock an error message to display when it failed to submit
                    $_SESSION['message'] = "<div class='message' ><p class='error'>Le produit ". ucfirst($name) ." n'a pas pu être ajouté</p></div>";
                    if (!$name){
                        //make the "name" input background red and the label color if null
                        $_SESSION['message'] .= "<style>form p:first-child label input{background-color:var(--redError);}form p:first-child label{color:var(--redError);}</style>";
                    } 
                    if (!$price){
                        //make the "price" input background and the label color red if null
                        $_SESSION['message'] .= "<style>form p:nth-child(2) label input{background-color:var(--redError);}form p:nth-child(2) label{color:var(--redError);}</style>";
                    } 
                }
            } 
        
            header("Location:index.php");
            break;

        // Clear all
        case "viderPanier":
            unset($_SESSION["products"]);
            $_SESSION['message'] = "<div class='message' ><p class='error'>L'ensemble panier a été supprimer</p></div>";
            header("Location:recap.php");die;
            break;
        
        // Up the quantity
        case "upQty":
            // up the product quantity by 1
            $_SESSION["products"][$_GET["id"]]["qtt"]++;
            // refresh the price
            $_SESSION["products"][$_GET["id"]]["total"] = $_SESSION["products"][$_GET["id"]]["qtt"]*$_SESSION["products"][$_GET["id"]]["price"];
            header("Location:recap.php");die;
            break;

        // Down the quantity
        case "downQty":
            // down the product quantity by 1
            $_SESSION["products"][$_GET["id"]]["qtt"]--;
            // refresh the price
            $_SESSION["products"][$_GET["id"]]["total"] = $_SESSION["products"][$_GET["id"]]["qtt"]*$_SESSION["products"][$_GET["id"]]["price"];
            // if quantity = 0 ; delete the article
            if($_SESSION["products"][$_GET["id"]]["qtt"] < 1){
                $_SESSION['message'] = "<div class='message' ><p class='error'>Le produit ". ucfirst($_SESSION["products"][$_GET["id"]]["name"]) ." a été retiré de la liste</p></div>";
                unset($_SESSION["products"][$_GET["id"]]);
            }
            header("Location:recap.php");die;
            break;

        // Delete 1 product
        case "suppProduit":
            $_SESSION['message'] = "<div class='message' ><p class='error'>Le produit ". ucfirst($_SESSION["products"][$_GET["id"]]["name"]) ." a été retiré de la liste</p></div>";
            unset($_SESSION["products"][$_GET["id"]]);
            header("Location:recap.php");die;
            break;
    }

?>