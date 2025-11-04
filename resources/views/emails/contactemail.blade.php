<?php
// dd('hello');
$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/mailers/contactemail.html', 'r');

$file = str_replace('#name', $data['Name'], $file);
$file = str_replace('#email', $data['Email'], $file);
$file = str_replace('#mobile', $data['Mobile'], $file);
$file = str_replace('#message', $data['Message'], $file);
$file = str_replace('#business_type', $data['business_type'], $file);

echo $file;

?>
