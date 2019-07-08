<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 22:20
 */

class Update_menu extends ACore_Admin {
    protected function obr() {

        $id = $_POST['id'];
        $title = $_POST['title'];
        $text = $_POST['text'];

        if(empty($title) || empty($text)) {
            exit('Не заполненны обязательные поля');
        }

        $query = "UPDATE menu SET name_menu='$title',text_menu='$text'
                  WHERE id_menu='$id'";

        if(!mysqli_query($this->mysqlServerDesc, $query)) {
            exit(mysqli_error($this->mysqlServerDesc));
        } else {
            $_SESSION['res'] = 'Изменения сохранены';// Запоминнаем данные в сессии
            header("Location: ?option=edit_menu"); // Перенаправляем пользователя на другую страницу
            exit;
        }
    }

    public function get_content() {
        // Implement get_content() method.

        if($_GET['id_text']) {
            $id_menu = (int)$_GET['id_text'];
        } else {
            exit('Не правильные данные для этой страницы');
        }

        $menu = $this->get_text_menu($id_menu);

//        print_r($text);
//        echo '<br>$text[\'cat\'] = '.$text['cat'].'<br>';

        echo "<div id='main'>";

        if($_SESSION['res']) {
            echo $_SESSION['res'].'<br>';
            unset($_SESSION['res']);// $_SESSION['res'] необходимо очистить,
            // чтобы сообщение вывелось только один раз
        }

        print <<<HEREDOC
<form action='' method='POST'>
<p>Заголовок меню:</br>
<input type='text' name='title' style='width:420px;' value='$menu[name_menu]'>
<input type="hidden" name="id" style="width:420px" value="$menu[id_menu]">
</p>
<p>Текст</br>
<textarea name='text' cols='50' rows='7'>$menu[text_menu]</textarea>
</p>
<p><input type='submit' name='button' value='Сохранить'></p></form></div></div>
HEREDOC;

    }
}