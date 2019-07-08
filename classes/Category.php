<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 2:09
 */

class Category extends ACore {
    public function get_content() {
        echo '<div id="main">';
        // Implement get_content() method.
        // Получаем данные из табл. statti

        if(!$_GET['id_cat']) {
            echo "Не правильные данные для вывода строки +++++";
        } else {
            $id_cat = (int)$_GET['id_cat'];
            if(!$id_cat) {
                echo "Не правильные данные для вывода строки";
            } else {
                $query = "SELECT id, title, description, date, img_src 
                          FROM statti 
                          WHERE cat='$id_cat' 
                          ORDER BY date DESC";
                $result = mysqli_query($this->mysqlServerDesc, $query);// Результат выборки
                if(!$result) {
                    exit(mysqli_error());
                }

                if(mysqli_num_rows($result) > 0) {
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
                } else {
                    echo 'В данной категории пока еще не статей';
                }

            }
        }
        echo '</div>
		        </div>';
    }
}