<?php

include 'application/database/database.php';

$errorMessage = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $admin =    0;
    $login =    trim($_POST['login']);
    $email =    trim($_POST['email']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if($login === '' || $email === '' || $passF === ''){
        $errorMessage = 'Не все поля заполнены!';
    }elseif(mb_strlen($login, "UTF-8") < 2){
        $errorMessage = 'Поле login должно содержать не менее 2 символов!';
    }elseif($passF !== $passS){
        $errorMessage = 'Пароли не совпадают!';
    }else{
        $existence = selectOne('users',['email' => $email]);
        if($existence['email'] === $email){
            $errorMessage = 'Пользователь с такой почтой уже существует!';
        }else{
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            $post = [
                'is_admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass
            ];
            $id = insert('users', $post);
            $success = "Пользователь " . "<strong>" . $login ."</strong>" . " успешно зарегистрирован!";
        }
    }
}else{
    $login = '';
    $email = '';
}