<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 26.06.2019
 * Time: 22:06
 */

class Main extends ACore {
    public function get_content() {
        // Implement get_content() method.
        // Получаем данные из табл. statti
        $query = "SELECT id, title, description, date, img_src FROM statti ORDER BY date DESC";
        $result = mysqli_query($this->mysqlServerDesc, $query);// Результат выборки
        if(!$result) {
            exit(mysqli_error());
        }

        echo '<div id="main">';

        $row = [];
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);// Последовательно(на каждой итерации) выводим по одной строке из выборки
            printf("<div style='margin:10px;border-bottom:2px solid #c2c2c2'>
                        <h2>%s</h2>
                        <p>%s</p>
                        <p><img style='margin-right:5px' width='150px' align='left' src='%s' >%s</p>
                        <p style='color:#9E1C1C'><a href='?option=view&id_text=%s'>Читать далее ...</a>></p>
                     </div>
                    ", $row['title'], $row['date'], $row['img_src'], $row['description'], $row['id']);//Оформление шаблона строки
        }
        echo '</div>
		    </div>';
    }
}