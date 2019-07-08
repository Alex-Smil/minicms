<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 26.06.2019
 * Time: 20:19
 */

abstract class ACore {
    protected $mysqlServerDesc ;// Дескриптор подключения к серверу MySQL

    /**
     * ACore constructor.
     * Во время создания какого-либо экземпляра потомка класса ACore
     * вместе с ним устаналиваем соединение с БД и помещаем дкскриптор соединения с БД
     * в его унаследованое св-во $mysqlServerDesc
     */
    public function __construct() {
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
        $query = "SELECT id_category, name_category FROM categories";
        $result = mysqli_query($this->mysqlServerDesc, $query);
        if(!$result) {
            exit(mysqli_error());
        }

        $row = [];
        echo '<div class="quick-bg">
                <div id="spacer">
                    <div id="rc-bg">Menu</div>
                </div>';

        for($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            printf("<div class='quick-links'> 
                        >> <a href='?option=category&id_cat=%s'>%s</a>
                    </div>", $row['id_category'],$row['name_category']);
        }
        echo '</div>';
    }

    /**
     * Метод выводи основное меню
     */
    protected function get_menu() {
        $row = $this->menu_array();
        echo '<div id="mainarea">
			    <div class="heading">';
        echo '<div class="toplinks" style=\"padding-left:30px;\">
                    <a href="?option=main">Главная</a></div>
			    <div class="sap2">::</div>';
        $i = 1;
        foreach($row as $item) {
            printf("<div class='toplinks'><a href='?option=menu&id_menu=%s'>%s</a></div>",
                $item['id_menu'], $item['name_menu']);
            // Убрать двоеточие :: после последнего поункта меню
            if($i != count($row)) {
                echo "<div class='sap2'>::</div>";
            }
            $i++;
        }
        echo '</div>';
    }

    /**
     * Вспомогательный метод menu_array() подготавливает для метода get_menu() 
     * массив ассоц.массивов $row[], данные из которого понадобится для дальнейшего рендеринга
     * страницы
     */
    protected function menu_array() {
        $query = "SELECT id_menu, name_menu FROM menu";
        $result = mysqli_query($this->mysqlServerDesc, $query);
        if(!$result) {
            exit(mysqli_error());
        }

        $row = [];
        $i = 1;
        for($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);

        }
        return $row;
    }

    /**
     * Метод выводит footer сайта
     */
    protected function get_footer() {
        $row = $this->menu_array();

        echo '<div id="bottom">';
        echo '<div class="toplinks" style="padding-left:127px;">
                    <a href="?option=main">Главная</a></div>
			    <div class="sap2">::</div>';
        $i = 1;
        foreach($row as $item) {
            printf("<div class='toplinks'><a href='?option=menu&id_menu=%s'>%s</a></div>",
                $item['id_menu'], $item['name_menu']);
            // Убрать двоеточие :: после последнего поункта меню
            if($i != count($row)) {
                echo "<div class='sap2'>::</div>";
            }
            $i++;
        }

        echo '</div>
		            <div class="copy"><span class="style1"> Copyright 2010 Название сайта </span>
                </div>
            </div>
        </div></body>,</html>';
    }



    /**
     * Основной метод для рендеринга страницы
     */
    public function get_body() {
        if($_POST) {
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
}