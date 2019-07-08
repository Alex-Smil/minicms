<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 01.07.2019
 * Time: 23:28
 */
echo "
    <form enctype='multipart/form-data' action='' method='POST'>
        <p>
            Заголовок статьи:</br>
            <input type='text' name='title' style='width: 420px'>
        </p>
        <p>
            Изображение:</br>
            <input type='file' name='img_src'>
        </p>
        <p>
            Краткое описание</br>
            <textarea name='text' cols='50' rows='7'></textarea>
        </p>
        <select name='cat'>
            <option value=''></option>
        </select>
        <p>
            <input type='submit' name='button' value='Сохранить'>
        </p>
    </form>
";