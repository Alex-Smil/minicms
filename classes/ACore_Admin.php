<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 17:15
 */

abstract class ACore_Admin {
    protected $mysqlServerDesc ;// Дескриптор подключения к серверу MySQL

    /**
     * ACore constructor.
     * Во время создания какого-либо экземпляра потомка класса ACore
     * вместе с ним устаналиваем соединение с БД и помещаем дкскриптор соединения с БД
     * в его унаследованое св-во $mysqlServerDesc
     */
    public function __construct() {
//        echo 'header("Location: ?option=login") = FALSE';
        if(!$_SESSION['user']) {
            header("Location: ?option=login");
        } else {
//            echo 'header("Location: ?option=login") = FALSE';
        }

        // Устанавливаем новое соединение с сервером MySQL
        $this->mysqlServerDesc = mysqli_connect(HOST, USER, PASS);//mysql_connect - устарело, начиная с версии PHP 5.5.0, и удалено в PHP 7.0.0
        // Используйте вместо него mysqli_connect
        if(!$this->mysqlServerDesc) {
            exit('Ошибка соединения с БД'.mysqli_error());
        }

        // Устанавливаем базу данных для выполняемых запросов
        if(!mysqli_select_db($this->mysqlServerDesc, DB)) {
            exit('Нет такой БД'.mysqli_error());
        }

        // Выполняем запрос к базе данных
        mysqli_query($this->mysqlServerDesc, "SET NAMES 'UTF8'");
        // echo('Соединение установленно - '.TEST.'<br>');
    }

    /**
     * Mетод выводит шапку сайта
     * так как данный кусок html содержит только статическую часть View(представления)
     * без каких-либо переменных, то разумнее применить include_once()
     */
    protected function get_header() {
        include_once "header.php";
    }


    /**
     * Метод выводи левую колонку с навигацией по категориям
     */
    protected function get_left_bar() {
        echo '<div class="quick-bg">
                <div id="spacer">
                    <div id="rc-bg">Разделы</div>
                </div>';

        echo("<div class='quick-links'> 
                        >> <a href='?option=admin'>Статьи</a>
                    </div>");

        echo("<div class='quick-links'> 
                        >> <a href='?option=edit_menu'>Меню</a>
                    </div>");

        echo("<div class='quick-links'> 
                        >> <a href='?option=edit_category'>Категории</a>
                    </div>");

        echo '</div>';
    }

    /**
     * Метод выводит основное меню, содержимое этого блока можно перенести в get_content(), а get_menu() удалить
     */
    protected function get_menu() {
        echo '<div id="mainarea">
			    <div class="heading"></div>';
    }


    /**
     * Метод выводит footer сайта
     */
    protected function get_footer() {
        echo '<div id="bottom">';
        echo '</div>
		            <div class="copy"><span class="style1"> Copyright 2010 Название сайта </span></div>
            </div>
        </div></body></html>';
    }



    /**
     * Основной метод для рендеринга страницы
     */


    public function get_body() {
        if($_POST || $_GET['del']) {
            $this->obr();
        }


        $this->get_header();
        $this->get_left_bar();
        $this->get_menu();
        $this->get_content();
        $this->get_footer();
    }

    /**
     * Каждая страница содержит различный контент, соответствующий
     * конкретному объекту класса. Поэтому данный метод должен быть реализован
     * в каждом классе, который должен выводить соответсвующий ему контент.
     */
    abstract function get_content();

    protected function get_categories() {
        $query = "SELECT id_category, name_category FROM categories";
        $result = mysqli_query($this->mysqlServerDesc, $query);
        if(!$result) {
            exit(mysqli_error());
        }

//        $row = [];
        for($i = 0;  $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }

        return $row;
    }

    protected function get_text_statti($id) {
        $query = "SELECT id, title, description, text, cat FROM statti WHERE id='$id'";
        $result = mysqli_query($this->mysqlServerDesc, $query);
        if(!$result) {
            exit(mysqli_error());
        }

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $row;
    }

    protected function get_text_menu($id) {
        $query = "SELECT id_menu, name_menu, text_menu FROM menu WHERE id_menu='$id'";
        $result = mysqli_query($this->mysqlServerDesc, $query);
        if(!$result) {
            exit(mysqli_error());
        }

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $row;
    }
}