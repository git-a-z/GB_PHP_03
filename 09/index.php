<?php
echo '<h4>Урок 9. Сортировка и поиск</h4>';
echo '<hr>';
echo '1. Создать массив на миллион элементов и отсортировать его различными способами. Сравнить скорости. <br><br>
2. Реализовать удаление элемента массива по его значению. Обратите внимание на возможные дубликаты! <br><br>
3. Подсчитать практически количество шагов при поиске описанными в методичке алгоритмами. <br>';
echo '<hr>';

// 1)
function getRandomArray($count) {
    $array = [];
    $max = $count * 1000;

    for ($i = 0; $i < $count; $i++) {
        $array[] = random_int(0, $max);  
    }
    // $array = array_unique($array); // ломает сортировку

    return $array;
}

function timeFunction($func, $arr) {
    $startTime = microtime(true);
    $arr = $func($arr);
    $endTime = microtime(true);
    echo "Time: " . number_format($endTime - $startTime, 6) . " ($func);<br>";
    
    return $arr;
}

function bubbleSort($array) {
    $count = count($array);

    for ($i=0; $i < $count; $i++) {
        for ($j=$i+1; $j < $count; $j++) {
            if ($array[$i] > $array[$j]) {
                $temp = $array[$j];
                $array[$j] = $array[$i];
                $array[$i] = $temp;
            }
        }
    }

    return $array;
}

function shakerSort($array) {
    $n = count($array);
    $left = 0;
    $right = $n - 1;

    do {
        for ($i = $left; $i < $right; $i++) {
            if ($array[$i] > $array[$i + 1]) {
                list($array[$i], $array[$i + 1]) = array($array[$i + 1], $array[$i]);
            }
        }
        $right -= 1;
        for ($i = $right; $i > $left; $i--) {
            if ($array[$i] < $array[$i - 1]) {
                list($array[$i], $array[$i - 1]) = array($array[$i - 1], $array[$i]);
            }
        }
        $left += 1;
    } while ($left <= $right);

    return $array;
}

function quickSort(&$arr, $low = null, $high = null) {
    if ($low !== null & $high !== null) {
        $i = $low;
        $j = $high;
    }
    else {
        $i = $low = 0;
        $j = $high = count($arr) - 1;
    }

    $middle = $arr[ ( $low + $high ) / 2 ]; // middle – опорный элемент; в
    // нашей реализации он находится посередине между low и high
    do {
        while ($arr[$i] < $middle) ++$i; // Ищем элементы для правой части
        while ($arr[$j] > $middle) --$j; // Ищем элементы для левой части
        if ($i <= $j) {
            // Перебрасываем элементы
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;
            // Следующая итерация
            $i++; $j--;
        }
    }
    while ($i < $j);
    if ($low < $j) {
        // Рекурсивно вызываем сортировку для левой части
        quickSort($arr, $low, $j);
    }
    if ($i < $high) {
        // Рекурсивно вызываем сортировку для правой части
        quickSort($arr, $i, $high);
    }

    return $arr;
}

$count = 1000;
echo "1) <br>Размер массива: $count<br>";
$arr = timeFunction('bubbleSort', getRandomArray($count));
$arr = timeFunction('shakerSort', getRandomArray($count));
$arr = timeFunction('quickSort', getRandomArray($count));
echo "<br>";

// echo '<pre>'; 
// var_dump($arr); 
// echo '</pre>';

/////////////////////////////////////////////////

//2) + 3)
function getSortedArray($count) {
    return timeFunction('quickSort', getRandomArray($count));
}

function linearSearch($array, $num, &$steps) {
    $count = count($array);

    for ($i=0; $i < $count; $i++) {
        $steps++;
        if ($array[$i] == $num) return $i;
        elseif ($array[$i] > $num) return null;
    }

    return null;
}

function binarySearch($array, $num, &$steps) {
    //определяем границы массива
    $left = 0;
    $right = count($array) - 1;

    while ($left <= $right) {
        $steps++;
        //находим центральный элемент с округлением индекса в меньшую сторону
        $middle = floor(($right + $left)/2);
        //если центральный элемент и есть искомый
        if ($array[$middle] == $num) {
            return $middle;
        }
        elseif ($array[$middle] > $num) {
            //сдвигаем границы массива до диапазона от left до middle-1
            $right = $middle - 1;
        }
        elseif ($array[$middle] < $num) {
            $left = $middle + 1;
        }
    }

    return null;
}

function interpolationSearch($array, $num, &$steps) {
    $start = 0;
    $last = count($array) - 1;

    while (($start <= $last) && ($num >= $array[$start]) && ($num <= $array[$last])) {
        $steps++;
        $pos = floor($start + ((($last - $start) / ($array[$last] - $array[$start])) * ($num - $array[$start])));

        if ($array[$pos] == $num) {
            return $pos;
        }
        elseif ($array[$pos] < $num) {
            $start = $pos + 1;

            if ($array[$start] == $num) {
                return $start;
            }
        }
        else {
            $last = $pos - 1;

            if ($array[$last] == $num) {
                return $last;
            }
        }
    }

    return null;
}

function searchAndDestroy($count, $func, $searchName) {
    $arr = getSortedArray($count);
    echo "Размер массива: " . count($arr) . "<br>";
    $steps = 0;
    $randomKey = random_int(0, count($arr)-1);
    // $randomKey = count($arr)-1;
    $value = $arr[$randomKey];
    $foundKey = $func($arr, $value, $steps);
    unset($arr[$foundKey]);
    echo "Количество шагов при $searchName поиске случайного элемента массива: $steps<br><br>";
}

echo "2) + 3) <br>";
$count = 1000;

// unset($arr[array_search(count($arr)-1, $arr)]);

searchAndDestroy($count, 'linearSearch', 'линейном');
searchAndDestroy($count, 'binarySearch', 'бинарном');
searchAndDestroy($count, 'interpolationSearch', 'интерполяционном');