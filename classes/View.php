<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 1:25
 */

class View extends ACore {
    // Implement get_content() method.
    public function get_content() {
        echo '<div id="main">';

        // Получаем данные из табл. statti
        if(!$_GET['id_text']) {
            echo "Не правильные данные для вывода строки +++++";
        } else {
            $id_text = (int)$_GET['id_text'];// Обязательно приводим к INT
            //если строка, то - false; любое число - true
            if(!$id_text) {
                echo "Не правильные данные для вывода строки";
            } else {
                $query = "SELECT title, text, date, id, img_src FROM statti WHERE id='$id_text'";
                $result = mysqli_query($this->mysqlServerDesc, $query);// Результат выборки
                if(!$result) {
                    exit(mysqli_error());
                }

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                printf("<h2>%s</h2>
                        <p>%s</p>
                        <p><img style='margin-right:5px' width='150px' align='left' src='%s' >%s</p>
                    ", $row['title'], $row['date'], $row['img_src'], $row['text']);//Оформление шаблона строки;
            }
        }
        echo '</div>
		    </div>';
    }
}