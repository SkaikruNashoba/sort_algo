<?php


if ((in_array('-h', $argv)) || (in_array('--help', $argv))) {
    echo "\nPour utiliser la moulinette correctement et voir toutes les informations disponibles,
    \e[31m\e[1m(vérifiez que vous soyez bien dans le dossier bonus (`cd Bonus/`))\e[0m\n
    Voici une petite liste d'arguments à ajouter à la commande 'php my_mouli.php'\n
    \e[1mAfficher le numéro de chaque test : '-NbrTest'\e[0m
    \e[4mexemple:\e[0m 'php my_mouli.php -NbrTest'\n
    \e[1mAfficher les Valeurs d\'entrées et de sortie :'-VtoEandS'\e[0m
    \e[4mexemple:\e[0m 'php my_mouli.php -VtoEandS'\n
    \e[1mAfficher le nombre total de tests : '-NT'\e[0m
    \e[4mexemple:\e[0m 'php my_mouli.php -NT'\n
    \e[1mAfficher les deux taux de réussite et d\'échec : '-StoF'\e[0m
    \e[4mexemple:\e[0m 'php my_mouli.php -StoF'\n
    \e[1mAfficher le temps total d'exécution : '-time'\e[0m
    \e[4mexemple:\e[0m 'php my_mouli.php -time'\n
    Vous pouvez utiliser toutes les commandes dans n'importe quel sens et en même temps.
    \e[4mexemple:\e[0m 'php my_mouli.php -StoF -NT -time -NbrTest -VtoEandS'\n\n";
    exit();
}
function generateRandomList()
{
    $list = [];
    $NbrValueEnter = 100;
    $NbrofNumberRandomLeft = 0;
    $NbrofNumberRandomRight = 1000000000;
    
    for ($i = 0; $i < $NbrValueEnter; $i++) {
        $list[] = rand($NbrofNumberRandomLeft, $NbrofNumberRandomRight);
    }
    return $list;
}


$NbrOfTest = 100;
$CountSuccess = 0;
$CountFail = 0;
$CountTest = 0;

$start_time = microtime(true);


echo "\n\e[32m\e[1mDébut des tests\e[0m\n\n";

for ($i = 0; $i < $NbrOfTest; $i++) {
    $list = generateRandomList();
    $input = implode(' ', $list);
    $command = "php push_swap.php $input | cat -e";
    $output = shell_exec($command);
    $CountTest++;

    echo "__________________________________________________________\n";
    if (in_array('-NbrTest', $argv)) {
        echo "\nTest n°$CountTest\n\n";
    }

    echo "\e[4mValeurs d'entrées :\n\e[0m\n$input\n\n";

    if (in_array('-VtoS', $argv)) {
        echo "\e[4mValeurs de sorties\e[0m\n\n";
        if (in_array('-BackLine', $argv)) {
            $output = preg_replace('/\b([a-z]+) (?!\g1)/', "$1\n", $output);
            $output = preg_replace('/\n /', "\n\n", $output);
        }
        if (in_array('-ColorVtoS', $argv)) {
            $output = 
            preg_replace('/\bpa\b/', "\e[31m$0\e[0m",
            preg_replace('/\bpb\b/', "\e[32m$0\e[0m",
            preg_replace('/\bsa\b/', "\e[33m$0\e[0m",
            preg_replace('/\bsb\b/', "\e[34m$0\e[0m",
            preg_replace('/\bra\b/', "\e[35m$0\e[0m",
            preg_replace('/\brb\b/', "\e[36m$0\e[0m",
            preg_replace('/\brra\b/', "\e[96m$0\e[0m",
            preg_replace('/\brrb\b/', "\e[38m$0\e[0m", 
            $output))))))));
        }
        echo "$output\n";
    }

    $outputList = explode(' ', trim($output));

    $outputList = array_map(function ($value) {
        if (preg_match('/^-?\d+$/', $value)) {
            return intval($value);
        }
        return $value;
    }, $outputList);


    $outputList = array_map('intval', $outputList);

    $isValid = true;
    $length = count($outputList);
    for ($j = 1; $j < $length; $j++) {
        if ($outputList[$j - 1] > $outputList[$j]) {
            $isValid = false;
            break;
        }
    }

    if ($isValid) {
        echo "\n__________________________________________________________\n";
        echo "\n\e[1mLa liste de sortie est \e[32m\e[1mvalide\e[0m \e[1m(ordre croissant)\e[0m.\n";
        $CountSuccess++;
    } else {
        echo "__________________________________________________________\n";
        echo "\n\e[1mLa liste de sortie n'est \e[31mpas valide\e[0m \e[1m(non ordre croissant)\e[0m.\n";
        $CountFail++;
    }
    echo "__________________________________________________________\n\n";
}
$end_time = microtime(true);
$execution_time = ($end_time - $start_time);

$TauxSuccess = ($CountSuccess / $NbrOfTest) * 100;
$TauxFail = ($CountFail / $NbrOfTest) * 100;

echo "\e[31m\e[1mFin des tests\e[0m\n";
if (in_array('-NT', $argv)) {
    echo "__________________________________________________________\n\n";
    echo "Nombre total de tests : \e[1m$CountTest\e[0m\n";
}
if (in_array('-StoF', $argv)) {
    echo "__________________________________________________________\n\n";
    echo "Taux de réussite : \e[1m$TauxSuccess%\e[0m\n";
    echo "Taux d'échec : \e[1m$TauxFail%\e[0m\n";
}
if (in_array('-time', $argv)) {
    echo "__________________________________________________________\n\n";
    echo "Temps d'exécution : \e[1m$execution_time\e[0m secondes\n\n";
}