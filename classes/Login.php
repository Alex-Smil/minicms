<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 02.07.2019
 * Time: 23:05
 */

class Login extends ACore {

    protected function obr() {
        // mysqli_real_escape_string() - обезопасит от mysql инъекций
        $login = strip_tags(mysqli_real_escape_string($this->mysqlServerDesc, $_POST['login']));
        $password = strip_tags(mysqli_real_escape_string($this->mysqlServerDesc, $_POST['password']));

        if(!empty($login) AND !empty($password)) {
            $password = md5($password);

            $query = "SELECT id FROM users WHERE login='$login' AND password='$password'";

            $result = mysqli_query($this->mysqlServerDesc, $query);

            if(!$result) {
                exit(mysqli_error());
            }

            if(mysqli_num_rows($result) === 1) {
                $_SESSION['user'] = TRUE;
                header("Location: ?option=admin");
                exit();
            } else {
                exit("Такого пользователя нет");
            }

        } else {
            exit("Заполните обязательные поля");
        }
    }

    public function get_content() {

        echo '<div id="main">';
        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Логин:</br>
<input type='text' name='login'>
</p>
<p>Пароль:</br>
<input type='password' name='password'>
</p>
<p><input type='submit' name='button' value='Сохранить'></p></form>
HEREDOC;

        echo '</div>
		    </div>';
    }
}