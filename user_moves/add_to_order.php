<?php
session_start();

if ($_SESSION['user_id']) {
    header('Location: profile.php');
}

require_once '../config/connect.php';

if(isset($_POST['Добавить']))
{
    $id_dish = $_POST['Добавить'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($connect, "INSERT INTO `basket` (`user_id`, `dish_id`, `count`) VALUES ('$user_id', '$id_dish', '1')");
}

if(isset($_POST['+']))
{
    $id_dish = $_POST['+'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($connect, "UPDATE `basket` SET `count` = `count` + 1 WHERE `user_id` = '$user_id' AND `dish_id` = '$id_dish'");
}

if(isset($_POST['-']))
{
    $id_dish = $_POST['-'];
    $user_id = $_SESSION['user_id'];
    mysqli_query($connect, "UPDATE `basket` SET `count` = `count` - 1 WHERE `user_id` = '$user_id' AND `dish_id` = '$id_dish'");
}

mysqli_query($connect, 'DELETE FROM `basket` WHERE `basket`.`count` = 0');
header('Location: ../user.php');
exit();
?>