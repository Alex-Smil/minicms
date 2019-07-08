<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 18:58
 */

class Edit_menu extends ACore_Admin {
    public function get_content() {
        // Implement get_content() method.
        $query = "SELECT id_menu, name_menu FROM menu";
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

        echo "<a style='color:red' href='?option=add_menu'>Добавить новый пункт меню</a>";
        //        $row = [];
        for($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);// Последовательно(на каждой итерации) выводим по одной строке из выборки
            printf("<p>
                        <a style='color:#585858' href='?option=update_menu&id_text=%s'>%s</a> |
                        <a style='color:red' href='?option=delete_menu&del=%s'>Удалить</a>
                    </p>", $row['id_menu'], $row['name_menu'], $row['id_menu']);//Оформление шаблона строки
        }
        echo '</div>
            </div>';
    }
}