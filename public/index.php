<?php

var_dump($_REQUEST, $_SERVER);

echo '<h1>Hello world</h1>';

$filename = 'example.txt';
$filename2 = 'file.txt';
$content = "Привет, мир! Это пример записи в файл.\n";


echo "Current user: " . exec('whoami');
echo "\n";
echo "Current group: " . exec('groups');

// Открываем файл для записи ('w') или создания, если он не существует
$file = fopen($filename, 'aw');
$file2 = fopen($filename2, 'aw');

if ($file) {
    // Пишем содержимое в файл
    fwrite($file, $content);

    // Закрываем файл
    fclose($file);

    echo "Файл '$filename' успешно создан и данные записаны.";
} else {
    echo "Не удалось открыть файл '$filename' для записи.";
}

    if ($file2) {
        // Пишем содержимое в файл
        fwrite($file2, $content);

        // Закрываем файл
        fclose($file2);

        echo "Файл '$filename2' успешно создан и данные записаны.";
    } else {
        echo "Не удалось открыть файл '$filename2' для записи.";
    }