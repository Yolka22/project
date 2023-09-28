<?php
require_once __DIR__ . "/helper.php";
require_once __DIR__ . "/Message.php";
require_once __DIR__ . "/OldInputs.php";

session_start();

//ini_set('post_max_size', '500M');
//ini_set('upload_max_filesize', '500M');
//ini_set('error_reporting', E_ALL); // включаємо вивід помилок php
//echo phpinfo();

$action = $_POST['action'] ?? null; 

if(!empty($action)){
  $action(); 
}


function sendEmail() {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $message = $_POST['message'] ?? '';

  if (empty($name) || empty($email) || empty($message)) {
    Message::set('All fields are required', 'danger') ;
    OldInputs::set($_POST);
  } else {
    mail('kudriashova.ag@gmail.com', 'Mail from site', "$name, $email, $message");
    Message::set('Thank!');
  }

  redirect('contacts');
}


function uploadImage(){
  extract($_FILES['file']);

  if ($error === 4) {
      Message::set('File is required', 'danger');
      redirect('uploads');
  }
  if ($error !== 0) {
      Message::set('File is not uploaded', 'danger');
      redirect('uploads');
  }

  $allowsTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];

  if (!in_array($type, $allowsTypes)) {
      Message::set('File is not an image', 'danger');
      redirect('uploads');
  }

  // Получаем имя папки из формы
  $folderName = isset($_POST['folder']) ? trim($_POST['folder']) : '';

  if (empty($folderName)) {
      Message::set('Folder name is required', 'danger');
      redirect('uploads');
  }

  // Создаем папку, если её нет
  if (!file_exists('./uploaded/' . $folderName)) {
      mkdir('./uploaded/' . $folderName, 0777, true);
  }

  $fName = uniqid() . '_' . session_id() . '.' . end(explode('.', $name));
  $uploadPath = './uploaded/' . $folderName . '/' . $fName;

  if (move_uploaded_file($tmp_name, $uploadPath)) {
      Message::set('File is uploaded');
      redirect('uploads');
  } else {
      Message::set('Failed to upload file', 'danger');
      redirect('uploads');
  }
}

/* 

*/

/* 
Array
(
    [name] => premium_photo-.16923871.64064-5678.jpg
    [full_path] => premium_photo-1692387164064-5678.jpg
    [type] => image/jpeg
    [tmp_name] => C:\OSPanel\userdata\temp\upload\phpB989.tmp
    [error] => 0
    [size] => 65813
)
*/