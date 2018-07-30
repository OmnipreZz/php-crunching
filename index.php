<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>php-crunching</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    

    <h1 style="text-align:center">Php-crunching</h1>
    <br><br>
    <h2>Exercices Dictionnaire</h2>
    <br>
    <?php
        $string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
        $dico = explode("\n", $string);
        // var_dump($dico);
    ?>


    <p>Combien de mots contient ce dictionnaire ?</p>
    <?php
        echo 'il contient '.count($dico).' '.'mots.';
    ?>
    <br><br><br>


    <p>Combien de mots font exactement 15 caractères ?</p>
    <?php
        $nbr = 0;
        foreach ($dico as $value) {
            if (strlen($value) == 15) {
               $nbr++; 
            }
        }
        echo $nbr.' '.'mots font exactement 15 caractères.';
    ?>
    <br><br><br>



    <p>Combien de mots contiennent la lettre « w » ?</p>
    <?php
        $nb = 0;
        foreach ($dico as $value) {
            if (strpos($value,  "w")) {
                $nb += 1;
            }
        }
        echo $nb.' '.'mots contiennent la lettre « w ».';
    ?>
    <br><br><br>



    <p>Combien de mots finissent par la lettre « q » ?</p>
    <?php
        $n = 0;
        foreach ($dico as $value) {

            if ($value[strlen($value)-1] == "q") {
                $n++;
            }
        }
        echo $n.' '.'mots finissent par la lettre « q ».';
    ?>
    <br><br><br>



    <h2>Exercices liste de films</h2>
    <br>
    <?php
        $string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
        $brut = json_decode($string, true);
        $top = $brut["feed"]["entry"]; # liste de films
        // var_dump($top);
    ?>



    <p>Afficher le top10 des films?</p>
    <?php
        foreach ($top as $index => $array) {
            if ($index < 9) {
                foreach ($array as $key => $value) {
                    if ($key == "title") {
                        foreach ($value as $val) {
                            echo $val.'<br>';
                        }
                    }
                }
            }
        }
    ?>
    <br><br><br>



    <p>Quel est le classement du film « Gravity » ?<p>
    <?php
        foreach ($top as $index => $array) {
            foreach ($array as $key => $value) {
                if ($key == "title") {
                    foreach ($value as $val) {
                        if (substr($val, 1, 6) == "ravity") {
                            echo 'le classement de Gravity est '.$index.'.';
                        }
                    }
                }
            }
        }
    ?>
    <br><br><br>



    <p>Combien de films sont sortis avant 2000 ?<p>
    <?php
        $count = 0;
        foreach ($top as $key => $value) {
            if(substr($value["im:releaseDate"]["label"], 0, 4) < 2000) {
                $count ++;
            }
        }
        echo $count." "."films sont sortis avant 2000.";
    ?>
    <br><br><br>



    <p>Quel est le film le plus récent ? Le plus vieux ?<p>
    <?php
        $arr = [];
        foreach ($top as $key => $value) {
            $arr[$value["im:name"]["label"]] = substr($value["im:releaseDate"]["label"], 0, 10);
        }
        $desc = max($arr);
        $asc = min($arr);
        foreach ($arr as $key => $value) {
            if ($value == $desc) {
                echo 'le film le plus récent est : '.' '.$key.'<br>';
            }
            if ($value == $asc) {
                echo 'le film le plus vieux est : '.' '.$key;
            }
        }
    ?>
    <br><br><br>



    <p>Quelle est la catégorie de films la plus représentée ?<p>
    <?php
        $array = [];
        foreach ($top as $key => $value) {
            array_push($array, $value["category"]["attributes"]["label"]);
        }
        $arrMax = array_count_values($array);
        $max = max($arrMax);
        foreach ($arrMax as $key => $value) {
            if ($value == $max) {
                echo 'la catégorie de films la plus représentée est '.$key.'.'.'<br>';
            }
        }
    ?>
    <br><br><br>



    <p>Quel est le réalisateur le plus présent dans le top100 ?<p>
    <?php
        $array = [];
        foreach ($top as $key => $value) {
            array_push($array, $value["im:artist"]["label"]);
        }
        $arrMax = array_count_values($array);
        $max = max($arrMax);
        foreach ($arrMax as $key => $value) {
            if ($value == $max) {
                echo 'le réalisateur le plus présent dans le top100 est '.$key.'.'.'<br>';
            }
        }
    ?>
    <br><br><br>



    <p>Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ?<p>
    <?php
        $ar = [];
        foreach ($top as $key => $value) {
            if ($key < 10) {
               array_push($ar, substr($value["im:price"]["label"], 1, 5)); 
            }
        }
        echo "acheter le top10 coûterait ".array_sum($ar)."$.";
    ?>
    <br><br><br>



    <p>Quel est le mois ayant vu le plus de sorties au cinéma ?<p>
    <?php
        $mois = [];
        $cal = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "décembre"];
        foreach ($top as $key => $value) {
            array_push($mois, substr($value["im:releaseDate"]["label"], 5, 2));
        }
        $dateVal = array_count_values($mois);
        $moisMax = max($dateVal);
        foreach ($dateVal as $key => $value) {
            if ($value == $moisMax) {
                echo "le mois ayant vu le plus de sorties au cinéma est le mois de ".$cal[(substr($key, 1, 1))-1]." "."avec ".$value." sorties.<br>";
            }
        } 
    ?>
    <br><br><br>



    <p>Quels sont les 10 meilleurs films à voir en ayant un budget limité ?<p>
    <?php
        $prix = [];
        foreach ($top as $key => $value) {
            $prix[$value["im:name"]["label"]] = substr($value["im:price"]["label"], 1, 5);
        }
        $minPrix = min($prix);;
        foreach ($prix as $key => $value) {
            if ($value == $minPrix) {
                echo $key."<br>";
            }
        }
        foreach ($top as $key => $value) {
            if ($key < 6) {
                echo $value["im:name"]["label"]."<br>";
            }
        }
    ?>

</body>
</html>