<?php 

if(isset($_POST['vydaj'])){
    $id = $_POST['id'];
    $ks = $_POST['ks'];
    
    $itemExist = "SELECT * from items WHERE itemID=$id";
    $q = mysqli_query($dbhandle, $itemExist);
    //overujem, ci produkt so zadanym id ktory chcem vydat, je na sklade
    if(mysqli_num_rows($q) > 0){
        $oldKs = mysqli_fetch_array($q);
        $newKs = $oldKs{'pocetKs'} - $ks;

        if($newKs < 0){
            $_SESSION['err'] = "Na sklade nieje dostatok produktov";
        }
        else{
            $_SESSION['err'] = "";
            $update = "UPDATE items SET pocetKs = $newKs WHERE itemID=$id";
            $updateQuery = mysqli_query($dbhandle, $update);
        }
        header("Location: index.php");
    }
    else{
        $_SESSION['err'] = "Produkt so zadanym ID nieje na sklade.";
        header("Location: index.php");
    }
}

if(isset($_POST['prijem'])){
    $id = $_POST['id'];
    $ks = $_POST['ks'];
    
    if(isset($_POST['cena'])){
        $cena = $_POST['cena'];
    }

    $itemExist = "SELECT * from items WHERE itemID=$id";
    $q = mysqli_query($dbhandle, $itemExist);
    
    //ak uz v db existuje produkt s danym id, idem len pridat pocet kusov
    if(mysqli_num_rows($q) > 0){
        $oldKs = mysqli_fetch_array($q);
        $newKs = $ks + $oldKs{'pocetKs'};
        $update = "UPDATE items SET pocetKs = $newKs WHERE itemID=$id";
        $updateQuery = mysqli_query($dbhandle, $update);

        //Ak chcem upozornit na rozdiel medzi cenou v databaze a zadanou cenou u rovnakeho id
        if(isset($cena) && $oldKs{'cenaZaKs'} !== $cena){
            
            $_SESSION['err'] = "Zadana cena za kus sa nezhoduje s cenou v databaze produktov"; 
        }
        header("Location: index.php");
    }
    else{
        //ak v databaze doteraz nebol produkt s zadanym id, vlozim novy produkt
        if($cena){
            $_SESSION['err'] = "";
            $insertSql = "INSERT INTO items (`itemID`, `pocetKs`, `cenaZaKs`) VALUES ($id, $ks, $cena)";
            $insert = mysqli_query($dbhandle, $insertSql);
            header("Location: index.php");
        }
        else{
            //ak nebola zadana cena produktu za kus, neviem pridat novy produkt
            $_SESSION['err'] = "Nezadali ste cenu za kus";
            header("Location: index.php");
        }
    }
}

?>