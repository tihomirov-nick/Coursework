# Отчёт о курсовой работе
#### *По курсу "Основы Программирования"*
#### *Работу выполнил студент группы №3131 Беляев Д.Н.*


## Изучение предметной области

Необходимо реализовать пользовательский чат с авторизацией. Это должен быть сайт с простым и понятным интерефейсом, а также возможностью входа через социальную сеть ВКонтакте, для быстрой и удобной авторизации.


## Составление ТЗ

- Базовая система авторизации и выхода из аккаунта
- Добавление текстовых заметок в общуюю ленту
- Возможность реагировать на чужие заметки (лайки и дизлайки)
- Добавление изображений к заметкам
- Авторизация через ВКонтакте через **VK API**


## Выбор технологий

#### *Платформа:*
Бесплатный хостинг **free.sprinthost.ru**. 

#### *Среда разработки:*
PhpStorm.

#### *Языки программирования:*
PHP, HTML.

#### *Библиотеки:*
[dev.vk.com/api/getting-started](https://dev.vk.com/api/getting-started)

## Реализация

### Пользовательский интерфейс:
- *Форма авторизации:*                                                                                           
  ![](pictures/auth.png)

- *Форма добавления заметок*                                                                                                        
  ![](pictures/comment_section.png)

- *Лента заметок*                                                                                                                                                                                                                                                                                       
  ![](pictures/comments.png)

### Пользовательский сценарий:

Пользователь заходит на сайт, его перекидывает на форму входа/регистрации *(auth.php)*. Там пользователь входит в свою учётную запись через логин и пароль, при необходимости предварительно зарегистрировавшись, или проходит авторизацию через ВКонтакте. После входа он попадает на главную страницу *(index.php)*, где он может

- Выйти из учётной записи и попасть обратно на форму входа/регистрации
- Ввести текстовую заметку в поле для ввода или добавить картинку
- Читать заметки других пользователей, реагировать на них с помощью кнопок лайка и дизлайка


### API сервера:

При регистрации/авторизации пользователя используются **POST**-запросы c полями *login*, *password*, *name* и *confirm_password* 

При отправке заметки используются **POST**-запросы с полями *uid*, *date*, *likes*, *dislikes*, *message*, *img*

При работе с библиотекой [dev.vk.com/api/getting-started](https://dev.vk.com/api/getting-started) используются **GET**-запросы для выполнения обращения к приложению ВК.

### Хореография

**index.php**, при отсутствии переменной $_SESSION['user'], перенаправляет пользователя на страницу **auth.php**. Если переменная есть, то перенаправление не происходит. При нажатии на кнопку **Выйти** сервер отправляет запрос в **logout.php** *(в результате запроса перемения $_SESSION['user'])* будет уничтожена и направляет пользователя на **auth.php**.

Со страницы **auth.php**, при нажатии кнопки **"Регистрация"**, сервер отправляет запрос на **signup.php** *(тут данные будут проверены и, если всё ок, внесены в БД)*, передавая туда введённые в поля **"Логин"**, **Имя**, **Пароль** и **"Подтвердите пароль"** данные. **signup.php** после обработки данных возвращает  индикатор, в зависимости от значения которого будет выведено сообщение об ошибке или успешной регистрации.

При нажатии на странице **auth.php** кнопки **"Войти"**, сервер направит на **signin.php** запрос с введёнными данными. **signin.php** проверяет данные на корректность и возвращает индикатор, в зависимости от значения которого будет выведено сообщение об ошибке или пользователь получит переменную $_SESSION['user']) и будет перенаправлен на **index.php**.

Со страницы **auth.php**, при нажатии кнопки **"Войти через VK"**, перенаправляет пользователя на страницу **vk.php**. **vk.php** отправляет запрос на приложение VK и получает оттуда имя пользователя, а также создает переменную **$_SESSION['user'])**, и получает перенаправление на **index.php**.

При нажатии кнопки **"Отправить сообщение"** на странице **index.php** отправляется POST-запрос на создание новой заметки, результат которого будет выведен в ленту. 

### Структура базы данных

Браузерное приложение phpMyAdminДля используется для просмотра содержимого базы данных. Всего 2 таблицы:

Первая таблица для хранения данных о пользователях:
1. "id" типа int с автоинкрементом для выдачи уникальных id всем пользователям
2. "login" типа varchar для хранения логина пользователя
3. "name" типа varchar для хранения имени пользователя
4. "password" типа varchar для хранения пароля пользователя в виде хеша

Вторая таблица для хранения заметок:
1. "cid" типа int с автоинкрементом для выдачи уникальных id всем сообщениям
2. "uid" типа varchar для хранения никнеймов пользователей
3. "date" типа datetime для хранения даты и времени отправления сообщения
4. "message" типа text для хранения сообщений
5. "likes" типа int для хранения количества лайков
6. "dislikes" типа int для хранения количества дизлайков
7. "image_id" типа varchar для хранения картинок


### Алгоритмы
1. Алгоритм отправки сообщения                                                                                                                             
![](pictures/alg-setComment.png)

2. Алгоритм реагирования на заметку                                                                            
![](pictures/alg-likeSubmit.png)

3. Алгоритм входа на сайт                                                                    
![](pictures/alg_signin.png)

4. Алгоритм регистрации на сайте                                                       
![](pictures/alg_register.png)

5. Алгоритм аутентификации пользователя                                                      
![](pictures/alg-auth.png)

### Пример HTTP запросов/ответов
![](pictures/get_example1.png)
![](pictures/get_example2.png)

### Значимые фрагменты кода
**Получения данных из аккаунта ВКонтакте**:

    <a href="https://oauth.vk.com/authorize?client_id=<?=ID?>&display=page&redirect_uri=<?=URL?>&scope=photos&response_type=code&v=5.131" target="_blank">Авторизуйтесь через VK</a>
    if (!$_GET['code']){
        exit('error code');
    $token = json_decode(file_get_contents('http://oauth.vk.com/access_token?client_id='.ID.'&client_secret='.SECRET.'&redirect_uri='.URL.'&code='.$_GET['code']), true);
    $data = json_decode(file_get_contents('https://api.vk.com/method/users.get?access_token='.$token['access_token'].'&user_ids='.$token['user_id'].'&fields=first_name,last_name,photo_200_orig&name_case=nom&v=5.131'), true);
    

**Алгоритм регистрации на сайте**:

    if ( $password === $password_confirm){
        if (mysqli_num_rows($check_login) === 0){
            $password = md5($password);
            mysqli_query($connect, "INSERT INTO `users` (`id`, `login`,`name`, `password`) VALUES (NULL, '$login','$name', '$password')");
            $_SESSION['message'] = 'Регистрация прошла успешно!';
            header('Location: ../index.php' );
        }
       else{
            $_SESSION['message'] = 'Такой пользователь уже есть';
            header('Location: ../register.php' );
       }
    }
    else{
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../register.php' );
    }

**Функция вывода сообщений**:

    function getComments($conn){
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql);
    $max_page_posts = 100;
    $last_post = mysqli_num_rows($result);
    $i = 0;
    while(($row = $result->fetch_assoc())){
        if (($last_post - $i) > $max_page_posts ){
        }
        else{
            echo "<div class='comment-box'><p>";
            echo $row['uid']."<br>";
            echo $row['date']."<br>";
            echo $row['message']."<br>";
            $img_id = $row['image_id'];
            echo "<br>";
            if ($img_id) {
                echo "<td><img style = 'width:390px;' src = 'img/".$img_id."' alt = 'Тут могло быть изображение'/> </td>";
                }
            echo "<div>  <form method='POST' action='".likeSubmit($conn,$row)."'>  <button type='submit' name='".'like'.$row['cid']."' class='likeSubmit'>Like</button>  Likes: ".$row["likes"]."  </form></div>";
            echo "<br>";
            echo "<div>  <form method='POST' action='".dislikeSubmit($conn,$row)."'>  <button type='submit' name='".'dislike'.$row['cid']."' class='dislikeSubmit' style='  background-color: #ff0000; color: white; border: none; cursor: pointer; opacity: 0.9;'>Dislike</button>  Dislikes: ".$row["dislikes"]."  </form></div>";
            echo "<hr>";
            echo "<p></div>";
        }
        $i++;
    }


Функция реагирования на заметку:

    function likeSubmit($conn,$row){
    if(isset($_POST['like'.$row['cid']])) {
        $cid = $row['cid'];
        $likes = $row['likes']+1;
        $query = "UPDATE comments SET likes = '$likes' WHERE cid = '$cid'";
        $result = mysqli_query($conn, $query);
    }


## Тестирование

Регистрируемся:                                 
![](pictures/test1.png)                                

Авторизуемся через логин и пароль или через ВКонтакте:                   
![](pictures/test2.png)

Введём сообщение и выберем картинку:                                          
![](pictures/test3.png)

Видим наше сообщение в общей ленте:                                 
![](pictures/test4.png)

Всё работает!

## Поддержка
Не требуется. Логов нет, администрирование осуществляется через хостинг.
