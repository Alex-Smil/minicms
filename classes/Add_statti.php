<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 23:14
 *
 * так как атрибут action в форме не задан, это значит, что
 * параметры от формы будет принимать и обрабатывать та же страничка
 *
 */


class Add_statti extends ACore_Admin {

    protected function obr() {
        if(!empty($_FILES['img_src']['tmp_name'])) {
            if(!move_uploaded_file($_FILES['img_src']['tmp_name'], 'file/'.$_FILES['img_src']['name'])) {
                exit('Не удалось загрузить изображение');
            }
            // писать имя с префиксом (file/) не оч. хорошо
            // в БД должны хранится только имена файлов.
            // в реальной жизни так делать не надо!
            $img_src = 'file/'.$_FILES['img_src']['name'];
        } else {
            exit('Необходимо загрузить изображение');
        }

        $title = $_POST['title'];
        $date = date("Y-m-d", time());
        $description = $_POST['description'];
        $text = $_POST['text'];
        $cat = $_POST['cat'];

        if(empty($title) || empty($text) || empty($description)) {
            exit('Не заполненны обязательные поля');
        }

        $query = "INSERT INTO statti 
                    (title, img_src, date, text, description, cat)
                  VALUES
                    ('$title', '$img_src', '$date', '$text', '$description', '$cat')";

        if(!mysqli_query($this->mysqlServerDesc, $query)) {
            exit(mysqli_error($this->mysqlServerDesc));
        } else {
            $_SESSION['res'] = 'Изменения сохранены';// Запоминнаем данные в сессии
            header("Location: ?option=add_statti"); // Перенаправляем пользователя на другую страницу
            exit;
        }
    }


    public function get_content() {
        // Implement get_content() method.
        echo "<div id='main'>";

        if($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);// $_SESSION['res'] необходимо очистить,
            // чтобы сообщение вывелось только один раз
        }

        $cat = $this->get_categories();
        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Заголовок статьи:</br>
<input type='text' name='title' style='width: 420px'>
</p>
<p>Изображение:</br>
<input type='file' name='img_src'>
</p>
<p>Краткое описание</br>
<textarea name='description' cols='50' rows='7'></textarea>
</p>
<p>Текст</br>
<textarea name='text' cols='50' rows='7'></textarea>
</p>
<select name='cat'>
HEREDOC;

        foreach ($cat as $item) {
            echo "<option value='".$item['id_category']."'>".$item['name_category']."</option>";
        }

        echo "</select>
                <p><input type='submit' name='button' value='Сохранить'>
                </p>
                </form>
                </div>
            </div>";
    }


}