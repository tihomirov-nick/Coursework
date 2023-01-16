




$(document).ready(function() {
    $("#btn").click(function(){
        var postid1 = $(this).data('id');// При нажатии на кнопку
        var id = $("#input" + postid1).val(); // Получаем имя автора комментария
        $.ajax ({
            type: "GET", // Тип отправки "POST"
                url: "vendor/delete_order.php", // Куда отправляем(в какой файл)
                data: {"id": id}, // Что передаем и под каким значением
                cache: false, // Убираем кеширование
                success: function(){ // Если все прошло успешно
                    
                    let elems = document.querySelectorAll('#' + id);
                    for (let elem of elems) {
                        
                            elem.remove();

                    }

        }});
})
})
    


<script>
                    $(document).ready(function() {

                    $("#addnew").click(function(e){
                        e.preventDefault();
                        /* var postid1 = $(this).data('id'); */
                        var id = $("tr").data('id');
                            id++;
                        var name = $("#title").val(); 
                        var description = $("#description").val();
                        var price = $("#price").val();
                        var img = $("#img").val();
                        $.ajax ({
                            type: "POST", 
                                url: "vendor/create.php", 
                                
                                data: {
                                    "id":
                                    "name": name,
                                    "description": description,
                                    "price": price,
                                    "img": img
                                        }, 
                                cache: false, 
                                success: function(){ 
                                    
                                    var html = "<tr id='elem+id'> <td>id</td><td>name</td><td>description</td><td>price + $</td><td><img src = 'admin/uploads/ + img' width="100"></td><td><a style='text-decoration: none; color: #3ec24b'  href='update.php?id= id' >Update</a></td> <td><button id='btn-delete' data-id='id' class='btn btn-danger' href='vendor/delete.php?id=id' >Delete</button><input type='hidden' id='inputid' name='id' value='id'></td></tr>";
                                    $("table").append(html);

                        }});
                    })
                    })

            </script>