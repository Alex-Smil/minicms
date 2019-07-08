<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 19:06
 */

class Add_menu extends ACore_Admin {
    protected function obr() {

        $title = $_POST['title'];
        $text = $_POST['text'];

        if(empty($title) || empty($text)) {
            exit('Не заполненны обязательные поля');
        }

        $query = "INSERT INTO menu 
                    (name_menu, text_menu)
                  VALUES
                    ('$title', '$text')";

        if(!mysqli_query($this->mysqlServerDesc, $query)) {
            exit(mysqli_error($this->mysqlServerDesc));
        } else {
            $_SESSION['res'] = 'Изменения сохранены';// Запоминнаем данные в сессии
            header("Location: ?option=add_menu"); // Перенаправляем пользователя на другую страницу
            exit;
        }
    }


    public function get_content() {
        // Implement get_content() method.
        echo "<div id='main'>";

        // Вывод сессионной переменной
        if($_SESSION['res']) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);// $_SESSION['res'] необходимо очистить,
            // чтобы сообщение вывелось только один раз
        }

        print <<<HEREDOC
<form action='' method='POST'>
<p>Заголовок Меню:</br>
<input type='text' name='title' style='width: 420px'>
</p>
<p>Текст</br>
<textarea name='text' cols='50' rows='7'></textarea>
</p>
<p><input type='submit' name='button' value='Сохранить'>
</p></form></div></div>";
HEREDOC;


    }
}