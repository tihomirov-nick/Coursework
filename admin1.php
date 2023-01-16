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
      color: #8ab9bf;
    }

    textarea {
      background: #415457;
      color: #8ab9bf;
      resize: none;
    }

    th,
    td {
      padding: 10px;
    }

    th {
      background: #415453;
      color: #8ab9bf;
    }

    td {
      background: #50686b;
    }
  </style>
  <body>
    <div class="row g-5">
      <table class="col-5 m-5">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Price</th>
          <th>Image</th>
        </tr> <?php
            $products = mysqli_query($connect, "SELECT * FROM `menulist` ORDER BY `id` DESC");
            $products = mysqli_fetch_all($products);
            foreach ($products as $product) {
                ?> <tr data-id="
                            <?= $product[0] ?>" id="elem
                            <?= $product[0] ?>">
          <td> <?= $product[0] ?> </td>
          <td> <?= $product[1] ?> </td>
          <td> <?= $product[2] ?> </td>
          <td> <?= $product[3] ?>$ </td>
          <td>
            <img src="
                                    <?= $product[4] ?>" width="100">
          </td>
          <td>
            <a style="text-decoration: none; color: #3ec24b" href="update.php?id=
                                        <?= $product[0] ?>">Update </a>
          </td>
          <td>
            <button id="btn-delete" data-id="
                                        <?= $product[0] ?>" class="btn btn-danger" href="vendor/delete.php?id=
                                        <?= $product[0] ?>">Delete </button>
            <input type="hidden" id="input
                                        <?= $product[0] ?>" name="id" value="
                                        <?php echo $product[0]; ?>">
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
        </script> <?php
            }
        ?>
      </table>

      </form>
      <div class="col-md-1 col-lg-2">
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
  </body>
</html>
