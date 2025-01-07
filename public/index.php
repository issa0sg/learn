<?php

var_dump($_REQUEST, $_SERVER);

echo '<h1>Hello world</h1>';

$filename = 'example.txt';
$content = "Привет, мир! Это пример записи в файл.\n";

// Открываем файл для записи ('w') или создания, если он не существует
$file = fopen($filename, 'w');

if ($file) {
    // Пишем содержимое в файл
    fwrite($file, $content);
    
    // Закрываем файл
    fclose($file);
    
    echo "Файл '$filename' успешно создан и данные записаны.";
} else {
    echo "Не удалось открыть файл '$filename' для записи.";
}