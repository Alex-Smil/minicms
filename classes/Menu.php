<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 13:45
 */

class Menu extends ACore {
    // Implement get_content() method.
    public function get_content() {
        echo '<div id="main">';

        // Получаем данные из табл. statti
        if(!$_GET['id_menu']) {
            echo "Не правильные данные для вывода меню";
        } else {
            $id_menu = (int)$_GET['id_menu'];// Обязательно приводим к INT
            //если строка, то - false; любое число - true
            if(!$id_menu) {
                echo "Не правильные данные для вывода строки";
            } else {
                $query = "SELECT id_menu, name_menu, text_menu FROM menu WHERE id_menu='$id_menu'";
                $result = mysqli_query($this->mysqlServerDesc, $query);// Результат выборки
                if(!$result) {
                    exit(mysqli_error());
                }

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                printf("<h2>%s</h2>
                        <p>%s</p>
                    ", $row['name_menu'], $row['text_menu']);//Оформление шаблона строки;
            }
        }
        echo '</div>
		    </div>';
    }
}