<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 22:09
 */

class Admin extends ACore_Admin {
    public function get_content() {
        // Implement get_content() method.
        $query = "SELECT id, title FROM statti";
        $result = mysqli_query($this->mysqlServerDesc, $query);
        if(!$result) {
            exit(mysqli_error());
        }

        echo "<div id='main'>";

        if($_SESSION['res']) {
            echo $_SESSION['res'].'<br>';
            unset($_SESSION['res']);// $_SESSION['res'] необходимо очистить,
            // чтобы сообщение вывелось только один раз
        }

        echo "<a style='color:red' href='?option=add_statti'>Добавить новую статью</a>";
        //        $row = [];
        for($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);// Последовательно(на каждой итерации) выводим по одной строке из выборки
            printf("<p>
                        <a style='color:#585858' href='?option=update_statti&id_text=%s'>%s</a> |
                        <a style='color:red' href='?option=delete_statti&del=%s'>Удалить</a>
                    </p>", $row['id'], $row['title'], $row['id']);//Оформление шаблона строки
        }
        echo '</div>
            </div>';
    }
}