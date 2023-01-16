<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
   $_SESSION['user_id'] = rand(1000000, 10000000);
}

require_once 'config/connect.php';
mysqli_query($connect, "DELETE FROM `orderlist` WHERE `orderprice` = '0'");
?>

  <!doctype html>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Order page</title>
  </head>

  <body>
    <div class="container py-4">
    <header class="pb-3 mb-4 border-bottom">
          <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
            <span class="fs-4">Меню ресторана Bible</span>
          </a>
        </header>
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="row align-items-md-stretch">
            <div class="col-md-12">
              <div class="h-100 p-5 text-white bg-dark rounded-3">
                <h2>Ваш заказ</h2>
                <br></br>
                <?php
                         $user_id = $_SESSION['user_id'];
                         $basket = mysqli_query($connect, "SELECT * FROM `basket` WHERE `user_id` = '$user_id'");
                         $basket = mysqli_fetch_all($basket);
                         $sum = 0;
                         foreach ($basket as $baske)
                         {
                              $prod_id = $baske[1];
                              $prod_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$prod_id'"));
                              $sum += $prod_data['price'] * $baske[2];
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
                      <br></br>
                      <form action='user_moves\order.php' method='POST'>
                        <input type="hidden" name="num" value="<?= $basket ?>">
                        <input type="hidden" name="name" value="<?= $prod_data ?>">
                        <button class="btn btn-outline-light" name="Оформить заказ" type='submit' value="<?= $user_id ?>" width='50'>Оформить заказ</button>
                      </form>
              </div>
            </div>

            <?php
               $products = mysqli_query($connect, "SELECT * FROM `menulist`");
               $products = mysqli_fetch_all($products);
               foreach ($products as $product) {
                  ?>

              <div class="col-md-6">
                <br></br>
                <div class="h-100 p-5 bg-white border rounded-3">

                  <h2><?= $product[1] ?> - <?= $product[3] ?>$</h2>

                  <p><img src="<?= $product[4] ?>" width="100"></p>
                  <p>
                    <?= $product[2] ?>
                  </p>
                  <form action='user_moves\add_to_order.php' method='POST'>
                    <div class="btn-group">
                      <?php
                                   $user_id = $_SESSION['user_id'];
                                   $prod_id = $product[0];
                                   $sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `basket` WHERE `user_id` = '$user_id' AND `dish_id` = '$prod_id'"));
                                   if($sql)
                                   {
                                        ?>
                        <button class="btn btn-outline-secondary" name="+" type='submit' value="<?= $product[0] ?>" width='50'>+</button>
                        <button class="btn btn-outline-secondary" name="-" type='submit' value="<?= $product[0] ?>" width='50'>-</button>
                        <?php
                                   }
                                   else
                                   {
                                      ?>
                          <button class="btn btn-outline-secondary" name="Добавить" type='submit' value="<?= $product[0] ?>" width='50'>Добавить</button>
                          <?php
                                 }
                                 ?>
                    </div>
                  </form>
                </div>
              </div>

              <?php
        }
        ?>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>