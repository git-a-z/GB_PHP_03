<?php
echo '<h4>Урок 8. Массивы и структуры данных. Оценка сложности алгоритма</h4>';
echo '<hr>';
echo '1. Написать аналог «Проводника» в Windows для директорий на сервере при помощи итераторов. <br><br>
2. Определить сложность следующих алгоритмов: <br>
— поиск элемента массива с известным индексом, <br>
— дублирование массива через foreach, <br>
— рекурсивная функция нахождения факториала числа. <br><br>
3. Определить сложность следующих алгоритмов. Сколько произойдет итераций? <br> 
1) <br>
$n = 100; <br> 
$array[]= []; <br>

for ($i = 0; $i < $n; $i++) { <br>
    for ($j = 1; $j < $n; $j *= 2) { <br>
        $array[$i][$j]= true; <br>
    } <br> 
} <br><br>

2) <br>
$n = 100; <br>
$array[] = []; <br>

for ($i = 0; $i < $n; $i += 2) { <br>
    for ($j = $i; $j < $n; $j++) { <br>
        $array[$i][$j]= true; <br>
    } <br> 
} 
<br>';
echo '<hr>';

/////////////////////////////////////////////////

function showDir($path, $tab = '')
{
    // $arr = scandir($path);
    // $tab .= '   ';
    // foreach ($arr as $value) {
    //     echo $tab . "$value <br>";
    //     $dir = $path . '\\' . $value;

    //     if (is_dir($dir) && $value !== '.' && $value !== '..') {
    //         showDir($dir, $tab);
    //     }
    // }

    /////////////////////////////////////////////

    $tab .= '   ';
    // Создаем новый объект DirectoryIterator
    $dir = new DirectoryIterator($path);
    // Цикл по содержанию директории
    foreach ($dir as $value) {
        echo $tab . "$value <br>";

        if ($value->isDir() && !$value->isDot()) {
            showDir($value->getPathname(), $tab);
        }      
    }
}

echo '1) <br>';
$path =  __DIR__;
echo "Путь до текущей папки: $path <br>";
$arr = explode("\\", $path);
array_pop($arr); // на 1 уровень вверх
echo "Каталог на 1 уровень вверх: <br>";
$path = implode('\\', $arr);

echo '<pre>';
showDir($path);
echo '</pre>';

/////////////////////////////////////////////////

echo '2) <br>';
echo 'Поиск элемента массива с известным индексом — O(1) <br>';
echo 'Дублирование массива через foreach — O(N) <br>';
echo 'Рекурсивная функция нахождения факториала числа — O(N) <br><br>';

/////////////////////////////////////////////////

echo '3.1) <br>';

$n = 100; 
$array[]= [];
$k = 0;

for ($i = 0; $i < $n; $i++) {
    for ($j = 1; $j < $n; $j *= 2) {
        $array[$i][$j]= true;
        $k++;
    } 
}

echo 'O(N * log(N)) <br>';
echo "Итераций: $k <br><br>";

//

echo '3.2) <br>';

$n = 100;
$array[] = [];
$k = 0;

for ($i = 0; $i < $n; $i += 2) {
    for ($j = $i; $j < $n; $j++) {
        $array[$i][$j]= true;
        $k++;
    } 
}

echo 'O(N²) <br>';
echo "Итераций: $k <br>";
