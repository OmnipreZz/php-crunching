<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>php-crunching</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
    <script src="main.js"></script>
</head>
<body>
    

    <h1>Php-crunching</h1>
    <br><br>


                    <!-- ////////////////EXERCICES DICTIONNAIRE//////////////// -->

    <h2>Exercices Dictionnaire</h2>
    <br>
    <?php
        $string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
        $dico = explode("\n", $string);
        // var_dump($dico);


        // exception qui test que le dico est bien chargé!!
        function dicoLoad($string) {
            if (!$string) {
                throw new Exception('Dictionnaire Manquant!');
            } else {
                echo '<p style="color: red;">Dictionnaire bien chargé!</p><br>';
            }
            
        }
        try {
            dicoLoad($string);
        }catch (Exception $e) {
            echo '<p style="color: red;">Message d\'erreur : ', $e->getMessage().'</p><br>';
        }
    ?>



    <p class='line'>Combien de mots contient ce dictionnaire ?</p>
    <?php
        echo '<p>il contient '.count($dico).' '.'mots.</p>';
    ?>
    <br><br><br>



    <p class='line'>Combien de mots font exactement 15 caractères ?</p>
    <?php
        $count = 0;
        foreach ($dico as $value) {
            if (strlen($value) == 15) {
               $count++; 
            }
        }
        echo '<p>'.$count.' '.'mots font exactement 15 caractères.</p>';
    ?>
    <br><br><br>



    <p class='line'>Combien de mots contiennent la lettre « w » ?</p>
    <?php
        $count = 0;
        foreach ($dico as $value) {
            if (stristr($value,  "w")) {
                $count++;
            }
        }
        echo '<p>'.$count.' '.'mots contiennent la lettre « w ».</p>';
    ?>
    <br><br><br>



    <p class='line'>Combien de mots finissent par la lettre « q » ?</p>
    <?php
        $count = 0;
        foreach ($dico as $value) {
            if ($value[strlen($value) -1] == "q") {
                $count++;
            }
        }
        echo '<p>'.$count.' '.'mots finissent par la lettre « q ».</p>';
    ?>
    <br><br><br>



                        <!-- ////////////////EXERCICES LISTE DE FILMS//////////////// -->

    <h2>Exercices liste de films</h2>
    <br>
    <?php
        $string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
        $brut = json_decode($string, true);
        $GLOBALS['top'] = $brut["feed"]["entry"]; # liste de films
        // var_dump($top);

        //exception qui test que la liste de films est bien chargé!!
        function filmLoad($string) {
            if (!$string) {
                throw new Exception('Liste de films manquante!');
            } else {
                echo '<p style="color: red;">Liste de films ok!</p><br>';
            }
            
        }
        try {
            filmLoad($string);
        }catch (Exception $e) {
            echo '<p style="color: red;">Message d\'erreur : ', $e->getMessage().'</p><br>';
        }
    ?>



    <p class='line'>Afficher le top10 des films?</p>
    <?php
        //ici j'ai fait une fonction pour pouvoir faire un test unitaire
        function topTen() {
            $topFilm = [];
            foreach ($GLOBALS['top'] as $index => $array) {
                if ($index < 10) {
                    // $text .= '<p>'.$array['title']['label'].'</p>';
                    $topFilm[$index] = $array['title']['label'];
                }
            } 
            foreach ($topFilm as $key => $value) {
            echo '<p>'.$value.'</p>';
        }
            return $topFilm;
        }
        topTen();

    ?>
    <br><br><br>



    <p class='line'>Quel est le classement du film « Gravity » ?<p>
    <?php
        foreach ($GLOBALS['top'] as $key => $array) {
            if($array['im:name']['label'] == "Gravity") {
                echo '<p>le classement de Gravity est '.($key + 1).'eme.</p>';
            }
        }
    ?>
    <br><br><br>



    <p class='line'>Combien de films sont sortis avant 2000 ?<p>
    <?php
        $count = 0;
        foreach ($GLOBALS['top'] as $key => $value) {
            if(substr($value["im:releaseDate"]["label"], 0, 4) < 2000) {
                $count ++;
            }
        }
        echo '<p>'.$count." "."films sont sortis avant 2000.</p>";
    ?>
    <br><br><br>



    <p class='line'>Quel est le film le plus récent ? Le plus vieux ?<p>
    <?php
        $arr = [];
        foreach ($GLOBALS['top'] as $key => $value) {
            $arr[$value["im:name"]["label"]] = substr($value["im:releaseDate"]["label"], 0, 10);
        }
        foreach ($arr as $key => $value) {
            if ($value == max($arr)) {
                echo '<p>le film le plus récent est : '.' '.$key.'</p>';
            }
            if ($value == min($arr)) {
                echo '<p>le film le plus vieux est : '.' '.$key.'</p>';
            }
        }
    ?>
    <br><br><br>



    <p class='line'>Quelle est la catégorie de films la plus représentée ?<p>
    <?php
        $array = [];
        foreach ($GLOBALS['top'] as $key => $value) {
            array_push($array, $value["category"]["attributes"]["label"]);
        }
        $arrMax = array_count_values($array);
        foreach ($arrMax as $key => $value) {
            if ($value == max($arrMax)) {
                echo '<p>la catégorie de films la plus représentée est '.$key.'.'.'</p><br>';
            }
        }
    ?>
    <br><br><br>



    <p class='line'>Quel est le réalisateur le plus présent dans le top100 ?<p>
    <?php
        $arr = [];
        foreach ($GLOBALS['top'] as $key => $value) {
            array_push($arr, $value["im:artist"]["label"]);
        }
        $arrMax = array_count_values($arr);
        foreach ($arrMax as $key => $value) {
            if ($value == max($arrMax)) {
                echo '<p>le réalisateur le plus présent dans le top 100 est '.$key.'.'.'</p><br>';
            }
        }
    ?>
    <br><br><br>



    <p class='line'>Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ?<p>
    <?php
        $arr = [];
        foreach ($GLOBALS['top'] as $key => $value) {
            if ($key < 10) {
               array_push($arr, substr($value["im:price"]["label"], 1, 5)); 
            }
        }
        echo "<p>acheter le top10 coûterait ".array_sum($arr)."$.</p>";
    ?>
    <?php
        $arr = [];
        foreach ($GLOBALS['top'] as $key => $value) {
            if ($key < 10) {
               array_push($arr, substr($value["im:rentalPrice"]["label"], 1, 5)); 
            }
        }
        echo "<p>louer le top10 coûterait ".array_sum($arr)."$.</p>";
    ?>
    <br><br><br>



    <p class='line'>Quel est le mois ayant vu le plus de sorties au cinéma ?<p>
    <?php
        $mois = [];
        $cal = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "décembre"];
        foreach ($GLOBALS['top'] as $key => $value) {
            array_push($mois, substr($value["im:releaseDate"]["label"], 5, 2));
        }
        $dateVal = array_count_values($mois);
        foreach ($dateVal as $key => $value) {
            if ($value == max($dateVal)) {
                echo "<p>le mois ayant vu le plus de sorties au cinéma est le mois de ".$cal[(substr($key, 1, 1))-1]." "."avec ".$value." sorties.</p>";
            }
        } 
    ?>
    <br><br><br>



    <p class='line'>Quels sont les 10 meilleurs films à voir en ayant un budget limité ?<p>
    <?php
        $prix = [];
        $stopCount = 0;
        foreach ($GLOBALS['top'] as $key => $value) {
            $prix[$value["im:name"]["label"]] = substr($value["im:price"]["label"], 1, 5);
        }
        asort($prix);
        foreach ($prix as $key => $value) {
            echo '<p>'.$key.'</p>';
            $stopCount++;
            if ($stopCount == 10) {
            break;
            }
        }
    ?>



</body>
</html>