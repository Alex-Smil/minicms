<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 16:08
 */

class Update_statti extends ACore_Admin {
    protected function obr() {
        if(!empty($_FILES['img_src']['tmp_name'])) {
            if(!move_uploaded_file($_FILES['img_src']['tmp_name'], 'file/'.$_FILES['img_src']['name'])) {
                exit('Не удалось загрузить изображение');
            }
            // писать имя с префиксом (file/) не оч. хорошо
            // в БД должны хранится только имена файлов.
            // в реальной жизни так делать не надо!
            $img_src = 'file/'.$_FILES['img_src']['name'];
        }

        $id = $_POST['id'];
        $title = $_POST['title'];
        $date = date("Y-m-d", time());
        $description = $_POST['description'];
        $text = $_POST['text'];
        $cat = $_POST['cat'];

        if(empty($title) || empty($text) || empty($description)) {
            exit('Не заполненны обязательные поля');
        }

        $query = "UPDATE statti SET title='$title',img_src='$img_src',date='$date',text='$text',description='$description',cat='$cat'
                  WHERE id='$id'";

        if(!mysqli_query($this->mysqlServerDesc, $query)) {
            exit(mysqli_error($this->mysqlServerDesc));
        } else {
            $_SESSION['res'] = 'Изменения сохранены';// Запоминнаем данные в сессии
            header("Location: ?option=admin"); // Перенаправляем пользователя на другую страницу
            exit;
        }
    }


    public function get_content() {
        // Implement get_content() method.

        if($_GET['id_text']) {
            $id_text = (int)$_GET['id_text'];
        } else {
            exit('Не правильные данные для этой страницы');
        }

        $text = $this->get_text_statti($id_text);

//        print_r($text);
//        echo '<br>$text[\'cat\'] = '.$text['cat'].'<br>';

        echo "<div id='main'>";

        if($_SESSION['res']) {
            echo $_SESSION['res'].'<br>';
            unset($_SESSION['res']);// $_SESSION['res'] необходимо очистить,
            // чтобы сообщение вывелось только один раз
        }

        $cat = $this->get_categories();

        echo 'TEST 1';

        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Заголовок статьи:</br>
<input type='text' name='title' style='width:420px;' value='$text[title]'>
<input type="hidden" name="id" style="width:420px" value="$text[id]">
</p>
<p>Изображение:</br>
<input type='file' name='img_src'>
</p>
<p>Краткое описание</br>
<textarea name='description' cols='50' rows='7'>$text[description]</textarea>
</p>
<p>Текст</br>
<textarea name='text' cols='50' rows='7'>$text[text]</textarea>
</p>
<select name='cat'>
HEREDOC;



        foreach ($cat as $item) {
            if($text['cat'] === $item['id_category']) {
                echo "<option selected value='".$item['id_category']."'>".$item['name_category']."</option>";
            } else {
                echo "<option value='".$item['id_category']."'>".$item['name_category']."</option>";
            }


        }

        echo "</select>
                <p><input type='submit' name='button' value='Сохранить'>
                </p>
                </form>";

//        echo '$text[\'cat\'] = '.$text['cat'].'<br>';
//        print_r($cat);

        echo "</div>
            </div>";
    }
}