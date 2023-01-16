
<?php

require_once 'vendor/connect.php';

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
    <table class="col-5 m-5"  >
        <tr>
            <th>Order number</th>
            <th>Order content</th>
            <th>Price</th>
        </tr>

        <?php


            $products = mysqli_query($connect, "SELECT * FROM `orderlist`");


            $products = mysqli_fetch_all($products);


            foreach ($products as $product) {
                ?>
                    <tr id="elem<?= $product[0] ?>">
                        <td ><?= $product[0] ?></td>
                        <td ><?php
                        
                        $order_content = mysqli_query($connect, "SELECT * FROM `$product[0]`");
                        $order_content = mysqli_fetch_all($order_content);

                        foreach ($order_content as $content) {

                            print "<span >{$content['0']} x {$content['1']}</span> <br></br>";

                        }

                        ?>
                    
                    </td>
                        <td ><?= $product[1] ?>$</td>
                        <td><button data-id="<?= $product[0] ?>" id="btn"  class="btn btn-danger">Delete</button>
                        <input type="hidden" id="input<?= $product[0] ?>" name="id" value="<?php echo $product[0]; ?>"></td>
                    </tr>
                        <script>
                            
                                $(document).ready(function() {

                                        $("button").click(function(){
                                            var postid1 = $(this).data('id');// При нажатии на кнопку
                                            
                                            var id = $("#input" + postid1).val(); // Получаем имя автора комментария
                                            
                                            $.ajax ({
                                                type: "GET", // Тип отправки "POST"
                                                    url: "vendor/delete_order.php", // Куда отправляем(в какой файл)
                                                    dataType: 'html',
                                                    data: {"id": id}, // Что передаем и под каким значением
                                                    cache: false, // Убираем кеширование
                                                    success: function(){ // Если все прошло успешно
                                                        
                                                        let elems = document.querySelectorAll('#elem' + id);
                                                        for (let elem of elems) {
                                                            
                                                                elem.remove();

                                                        }

                                            }});
                                    })
                                    })

                        </script>

                <?php
            }

        ?>
    </table>
    <div clas="col-5">      
    <form action="admin.php">
    <input type="submit" name="wp-submit" class = "m-5  border btn btn-dark" type="button" value="Вернуться в меню администратора"  tabindex="100" />
    </form>
    </div>
</body>
</html>