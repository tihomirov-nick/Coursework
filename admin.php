<?php
require_once 'vendor/connect.php';
mysqli_query($connect, "DELETE FROM `orderlist` WHERE `orderprice` = '0'");
?>

<!doctype html>
<html lang="en">
  <head>
  	<meta charset="UTF-8">
  	<title>Products</title>
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  </head>

  <style>
  	* {
  		color: #000;
  	}

  </style>

  <body>
  	<div class="container py-4">
  		<header class="pb-3 mb-4 border-bottom">
  			<a href="/" class="d-flex align-items-center text-dark text-decoration-none">
  				<svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
  				<span class="fs-4">Пример джамботрона</span>
  			</a>
  		</header>
  		
  		<div class="row align-items-md-stretch">

  			<div class="col-md-6">
  				<div class="row g-5">
  					<table class="table">
  						<thead>
  							<tr>
  								<th scope="col">ID</th>
  								<th scope="col">Название</th>
  								<th scope="col">Описание</th>
  								<th scope="col">Цена</th>
  								<th scope="col">Фото</th>
  								<th scope="col">Управление</th>
  								<th scope="col">товаром</th>
  							</tr>
  						</thead>
  						<?php
  						$products = mysqli_query($connect, "SELECT * FROM `menulist` ORDER BY `id` DESC");
  						$products = mysqli_fetch_all($products);
  						foreach ($products as $product) {
  						?>
  						<tbody>
  							<tr data-id="<?= $product[0] ?>" id="elem <?= $product[0] ?>">
  								<td> <?= $product[0] ?> </td>
  								<td> <?= $product[1] ?> </td>
  								<td> <?= $product[2] ?> </td>
  								<td> <?= $product[3] ?> </td>
  								<td>
  									<img src="<?= $product[4] ?>" width="100">
  								</td>
  								<td>
  									<button id="btn-update" data-id="<?= $product[0] ?>" class="btn btn-outline-secondary" href="update.php?id= <?= $product[0] ?>">Обновить</button>
  								</td>
  								<td>
  									<button id="btn-delete" data-id="<?= $product[0] ?>" class="btn btn-primary blog-btn" href="vendor/delete.php?id=<?= $product[0] ?>">Удалить</button>
  									<input type="hidden" id="input<?= $product[0] ?>" name="id" value="<?php echo $product[0]; ?>">
  								</td>
  							</tr>
  							<script>
  								$(document).ready(function() {
  									$("button").click(function() {
  										var postid1 = $(this).data('id');
  										var id = $("#input" + postid1).val();
  										$.ajax({
  											type: "GET",
  											url: "vendor/delete.php",
  											dataType: 'html',
  											data: {
  												"id": id
  												},
  											cache: false,
  											success: function() {
  												let elems = document.querySelectorAll('#elem' + id);
  												for (let elem of elems) {
  													elem.remove();
  												}
  											}
  										});
  									})
  								})
  							</script>
  							<?php } ?>
  						</tbody>
  					</table>
  				</div>
  			</div>

  			<div class="col-md-6">
  				</form>
  					<div class="col-lg-2 col-lg-6">
  						<h4 class="mb-3">Добавление нового продукта</h4>
						<form action="vendor/create.php" method="post" enctype="multipart/form-data">
							<div class="row g-3">
								<div class="col-sm-6">
									<label for="firstName" class="form-label">Название</label>
									<input type="text" class="form-control" id="title" name="name">
								</div>
								<div class="col-sm-6">
									<label for="lastName" class="form-label">Цена</label>
									<input type="number" id="price" class="form-control" name="price">
								</div>
								<div class="col-12">
									<label for="address" class="form-label">Описание</label>
									<textarea name="description" id="description" class="form-control" id="description" placeholder="Описание товара"></textarea>
								</div>
								<div class="example-2">
									<div class="form-group">
									<input type="file" id="img" name="img">
								</div>
							</div>
						</div>
							<hr class="my-4">
							<input id="addnew" type="submit" type="button" value="Добавить новый продукт" class="w-100 btn btn-primary btn-lg"></input>
						</form>
						<form action="order_list.php">
							<hr class="my-4">
							<input type="submit" name="wp-submit" class="w-100 btn btn-primary btn-lg" type="button" value="Все заказы" tabindex="150">
						</form>
  					</div>
  				</form>
  			</div>
  		</div>

  	</div>
  </body>
