<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 22:45
 */

class Delete_menu extends ACore_Admin {
    public function obr() {

        if($_GET['del']) {
            $id_menu = (int)$_GET['del'];

            $query = "DELETE FROM menu WHERE id_menu='$id_menu'";

            if(mysqli_query($this->mysqlServerDesc, $query)) {
                $_SESSION['res'] = "Удалено";
                header("Location: ?option=edit_menu");
                exit();
            } else {
                exit("Ошибка удаления");
            }
        } else {
            exit("Не верные данные для удаления");
        }
    }

    public function get_content()
    {
        // TODO: Implement get_content() method.
    }
}