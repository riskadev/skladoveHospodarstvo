<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklad</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php session_start();?> 
    <?php include 'dblogin.php' ?>
    <?php include 'logic.php' ?>

    <?php 
        if(isset($_SESSION['err']) && $_SESSION['err'] !== ""){
            echo "<h2 class='err'>" . $_SESSION['err'] . "</h2>";
        }
    ?>
    <form method="post">
    <h1>Sklad</h1>
        <input class="in" type="number" name="id" required placeholder="Id produktu..."/>
        <input class="in" type="number" name="ks" required placeholder="Počet kusov..."/>
        <input class="in" type="text" name="cena" placeholder="Cena za kus..."/>
        <input id="vydaj" class="sub" type="submit" name="vydaj" required value="VÝDAJ"/>
        <input id="prijem" class="sub" type="submit" name="prijem" required value="PRÍJEM"/>
    </form>

    <div class="listContainer">
        <div class="list">
            <h3>ZOZNAM PRODUKTOV NA SKLADE</h3>
            
            <div class="firstRow">
                <p>ID PRODUKTU</p>
                <p>POČET KUSOV</p>
                <p>CENA ZA KUS</p>
                <p>CENA CELKOM</p>
            </div>
            <?php 
                
                $sqlList = "SELECT * from items ORDER BY itemID";
                $list = mysqli_query($dbhandle, $sqlList);
                $sum = 0.00;
                while($row = mysqli_fetch_array($list)){
                    $cenaSpolu = $row{'pocetKs'}*$row{'cenaZaKs'}?>
                    <div class="row">
                        <p class="ID"><?php echo $row{'itemID'} ?></p>
                        <p class="ks"><?php echo $row{'pocetKs'} ?></p>
                        <p class="cenaKs"><?php echo sprintf("%.2f", $row{'cenaZaKs'}) ?> €</p>
                        <p class="cenaCelkom"><?php echo sprintf("%.2f", $cenaSpolu) ?> €</p>
                    </div>
                <?php
                $sum += $cenaSpolu;
                }
             ?>
            <hr>
            <?php echo "<p class='sum'>Cena celého skladu: " . $sum . " €</p>" ?>
        </div>
    </div>
</body>
</html>