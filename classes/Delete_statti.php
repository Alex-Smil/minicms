<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 18:17
 */

class Delete_statti extends ACore_Admin {
    public function obr() {

        if($_GET['del']) {
            $id_text = (int)$_GET['del'];

            $query = "DELETE FROM statti WHERE id='$id_text'";

            if(mysqli_query($this->mysqlServerDesc, $query)) {
                $_SESSION['res'] = "Удалено";
                header("Location: ?option=admin");
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