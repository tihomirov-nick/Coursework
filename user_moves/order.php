<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
   $_SESSION['user_id'] = rand(1000000, 10000000);
}

require_once '../config/connect.php';
?>

<!doctype html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Order page</title>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="stylesheet" href="style.css">
   <script src="https://api-maps.yandex.ru/2.1/?apikey=a2d546a2-e46b-443c-a1ff-f9a793166c5b&lang=ru_RU"></script>
</head>
<body>
   <div class="container py-4">
      <header class="pb-3 mb-4 border-bottom">
         <a class="d-flex align-items-center text-dark text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
          <span class="fs-4">Форма заказа ресторана Bible</span>
       </a>
    </header>
    <div class="row">
      <div class="col">
         <div class="row align-items-md-stretch">
            <div class="col-md-12">
               <div class="h-100 p-5 text-white bg-dark rounded-3">
                  <h2>Ваш заказ успешно создан!</h2>
                  <br></br>
                  <?php
                  $user_id = $_SESSION['user_id'];
                  $basket = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `basket` WHERE `user_id` = '$user_id'"));
                  $sum = 0;
                  foreach ($basket as $baske)
                  {
                     $prod_id = $baske[1];
                     $prod_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$prod_id'"));;
                     $sum += $prod_data['price'] * $baske[2];
                  }

                  mysqli_query($connect, "INSERT INTO orderlist (id_order, orderprice) VALUES (NULL,'$sum')");
                  $order_id = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id_order` FROM `orderlist` ORDER BY `id_order` DESC LIMIT 1"));
                  $order_id = $order_id['id_order'];
                  $table_name = "`cw`.`$order_id`";
                  mysqli_query($connect, "CREATE TABLE $table_name (`product_name` VARCHAR(255) NULL , `product_amount` INT(11) NULL ) ENGINE = InnoDB;");
                  
                  foreach ($basket as $baske)
                  {
                     $prod_id = $baske[1];
                     $prod_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$prod_id'"));
                     $name = $prod_data['name'];
                     mysqli_query($connect, "INSERT INTO $table_name (`product_name`, `product_amount`) VALUES ('$name', '$baske[2]')");

                     ?>
                     <div>
                       <?= $prod_data['name'] ?> - <?= $baske[2] ?> шт.
                    </div>
                    <?php
                 }
                 ?>
                 <?php
                 $user_id = $_SESSION['user_id'];
                 ?>
                 <br></br>
                 <div>
                  <h5>Общая стоимость заказа - <?= $sum ?>$</h5>
               </div>
               <div>
                  <h5>Номер вашего заказа - <?= $order_id ?></h5>
               </div>
               <br></br>
               <form action='../user.php' method='POST'>
                  <button class="btn btn-outline-light" name="Главное меню" type='submit' width='50'>Главное меню</button>
                  <?php mysqli_query($connect, "DELETE FROM `basket` WHERE `user_id` = '$user_id'");
                  $order_id += 1;
                  $table_name = "`cw`.`$order_id`";
                  mysqli_query($connect, "DROP TABLE $table_name");
                  ?>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<header class="pb-3 mb-4 border-bottom">
   <a class="d-flex align-items-center text-dark text-decoration-none">
   </a>
</header>
<header class="pb-3 mb-4 border-bottom">
   <a class="d-flex align-items-center text-dark text-decoration-none">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
      <span class="fs-4">Ближайшие рестораны</span>
   </a>
</header>
<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A817ba4ad4c87cb9d0d589faa01c9c9e48b19a9857a7b49dcf9f8fec1b15492b0&amp;width=1280&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
</body>