<?php


$arguments = array_slice($argv, 1);

foreach ($arguments as $arg) {
    $la[] = intval($arg);
}

$lb = array();
$operation = array();

function sa()
{
    global $operation, $la;
    if (count($la) >= 2) {
        $temp = $la[0];
        $la[0] = $la[1];
        $la[1] = $temp;
        $operation[] = "sa";
    }

}

function sb()
{
    global $operation, $lb;
    if (count($lb) >= 2) {
        $temp = $lb[0];
        $lb[0] = $lb[1];
        $lb[1] = $temp;
        $operation[] = "sb";
    }
}

function sc()
{
    global $operation;
    sa();
    sb();
    $operation[] = "sc";
}

function pa()
{
    global $operation, $la, $lb;
    if (!empty($lb)) {
        array_unshift($la, array_shift($lb));
        $operation[] = "pa";
    }
}

function pb()
{
    global $operation, $la, $lb;
    if (!empty($la)) {
        array_unshift($lb, array_shift($la));
        $operation[] = "pb";
    }
}

function ra()
{
    global $operation, $la;
    if (count($la) >= 2) {
        $first = array_shift($la);
        array_push($la, $first);
        $operation[] = "ra";
    }
}

function rb()
{
    global $operation, $lb;
    if (count($lb) >= 2) {
        $first = array_shift($lb);
        array_push($lb, $first);
        $operation[] = "rb";
    }
}

function rr()
{
    global $operation;
    ra();
    rb();
    $operation[] = "rr";
}

function rra()
{
    global $operation, $la;
    if (count($la) >= 2) {
        $last = array_pop($la);
        array_unshift($la, $last);
        $operation[] = "rra";
    }
}

function rrb()
{
    global $operation, $lb;
    if (count($lb) >= 2) {
        $last = array_pop($lb);
        array_unshift($lb, $last);
        $operation[] = "rrb";
    }
}

function rrr()
{
    global $operation;
    rra();
    rrb();
    $operation[] = "rrr";
}

function isSorted($array)
{
    $prev = $array[0];
    $count = count($array);
    for ($i = 1; $i < $count; $i++) {
        if ($prev > $array[$i]) {
            return false;
        }
        $prev = $array[$i];
    }
    return true;
}


function sortList()
{
    global $la, $lb, $operation;
    // echo "niveau 0 de \$la type 1 : " . implode(' ', $la) . "\n";
    // echo "niveau 0 de \$lb type 1 : " . implode(' ', $lb) . "\n";
    // echo "\n";
    while (count($la) > 3) {
        $minIndex = array_search(min($la), $la);
        if ($minIndex == 0) {
            pb();
            // echo "niveau 1 de \$la type 1 : " . implode(' ', $la) . "\n";
            // echo "niveau 1 de \$lb type 1 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($minIndex == 1) {
            sa();
            pb();
            // echo "niveau 1 de \$la type 2 : " . implode(' ', $la) . "\n";
            // echo "niveau 1 de \$lb type 2 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($minIndex == count($la) - 1) {
            rra();
            pb();
            sa();
            // echo "niveau 1 de \$la type 3 : " . implode(' ', $la) . "\n";
            // echo "niveau 1 de \$lb type 3 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else {
            $count = count($la);
            if ($minIndex < $count - $minIndex) {
                for ($i = 0; $i < $minIndex; $i++) {
                    ra();
                }
                // echo "niveau 1 de \$la type 4 : " . implode(' ', $la) . "\n";
                // echo "niveau 1 de \$lb type 4 : " . implode(' ', $lb) . "\n";
                // echo "\n";
            } else {
                for ($i = 0; $i < $count - $minIndex; $i++) {
                    rra();
                }
                // echo "niveau 1 de \$la type 5 : " . implode(' ', $la) . "\n";
                // echo "niveau 1 de \$lb type 5 : " . implode(' ', $lb) . "\n";
                // echo "\n";
            }
            pb();
            // echo "niveau 1 de \$la type 6 : " . implode(' ', $la) . "\n";
            // echo "niveau 1 de \$lb type 6 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        }
    }
    // echo "niveau 2 de \$la type 1 : " . implode(' ', $la) . "\n";
    // echo "niveau 2 de \$lb type 1 : " . implode(' ', $lb) . "\n";
    // echo "\n";

    if (count($la) == 2) {
        if ($la[0] > $la[1]) {
            sa();
        }
        // echo "niveau 2 de \$la type 2 : " . implode(' ', $la) . "\n";
        // echo "niveau 2 de \$lb type 2 : " . implode(' ', $lb) . "\n";
        // echo "\n";
    }

    if (count($la) == 3) {
        if ($la[0] > $la[1] && $la[0] < $la[2]) {
            sa();
            // echo "niveau 3 de \$la type 1 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 1 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] > $la[1] && $la[1] > $la[2]) {
            sa();
            rra();
            // echo "niveau 3 de \$la type 2 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 2 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] < $la[1] && $la[0] < $la[2] && $la[1] > $la[2]) {
            rra();
            sa();
            // echo "niveau 3 de \$la type 3 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 3 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] > $la[1] && $la[0] > $la[2] && $la[1] < $la[2]) {
            rra();
            sa();
            ra();
            sa();
            // echo "niveau 3 de \$la type 4 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 4 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] < $la[1] && $la[0] > $la[2]) {
            rra();
            // echo "niveau 3 de \$la type 5 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 5 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] === $la[1] && $la[0] > $la[2]) {
            rra();
            // echo "niveau 3 de \$la type 6 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 6 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[1] === $la[2] && $la[0] > $la[1]) {
            ra();
            // echo "niveau 3 de \$la type 7 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 7 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] === $la[2] && $la[0] > $la[1]) {
            rra();
            rra();
            // echo "niveau 3 de \$la type 8 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 8 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] === $la[2] && $la[0] < $la[1]) {
            rra();
            // echo "niveau 3 de \$la type 9 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 9 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        } else if ($la[0] < $la[1] && $la[1] > $la[2]) {
            rra();
            // echo "niveau 3 de \$la type 10 : " . implode(' ', $la) . "\n";
            // echo "niveau 3 de \$lb type 10 : " . implode(' ', $lb) . "\n";
            // echo "\n";
        }
        // echo "niveau 3 de \$la type 11 : " . implode(' ', $la) . "\n";
        // echo "niveau 3 de \$lb type 11 : " . implode(' ', $lb) . "\n";
        // echo "\n";
    }

    while (!empty($lb)) {
        pa();
    }
    // echo "niveau 4 de \$la type 1 : " . implode(' ', $la) . "\n";
    // echo "niveau 4 de \$lb type 1 : " . implode(' ', $lb) . "\n";
    // echo "\n";

    return $operation;
}

if (isSorted($la)) {
    echo "\n";
} else {
    $operation = sortList();
    echo implode(" ", $operation) . "\n";
    // echo implode(" ", $la) . "\n";
}