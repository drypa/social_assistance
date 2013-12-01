<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>
<h2>Регистрация граждан</h2>
<?php

$myConnect = mysql_connect('localhost:3306', 'root', '123456');
if (!$myConnect) {
    die (mysql_error());
}
mysql_select_db('social', $myConnect);
mysql_set_charset('utf8');

if (isset($_POST["add"])) {
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $middlename = $_POST["middlename"];
    $passport = $_POST["passport"];
    $birth_date = $_POST["birth_date"];
    $birth_date = date("Y-m-d", strtotime($birth_date));
    mysql_query("INSERT INTO `client` (`name`,`surname`,`passport`,`middlename`,`birth_date`)
                 VALUES ('$name','$surname','$passport','$middlename','$birth_date')", $myConnect);
}
if (isset($_POST["save"])) {
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $middlename = $_POST["middlename"];
    $passport = $_POST["passport"];
    $id = $_POST["id"];
    $birth_date = $_POST["birth_date"];
    $birth_date = date("Y-m-d", strtotime($birth_date));
    $query = "update `client` set `name` ='$name',`surname`='$surname',`passport`='$passport',`middlename`='$middlename',
                `birth_date`='$birth_date'
                where `passport`='$id'";
    mysql_query($query, $myConnect);
}
    if (isset($_POST["delete"])) {
        $passport = $_POST["client"];
        mysql_query("DELETE from `client` where `passport`='$passport'", $myConnect);
    }



$mysql_query = mysql_query("select * from `client`", $myConnect);
if (!$mysql_query) {
    die(mysql_error());
}
$clients = array();
while ($row = mysql_fetch_array($mysql_query)) {
    $clients[] = $row;
}
mysql_free_result($mysql_query);

?>


<table>
    <tr>
        <td class='menu'>
            <a href="index.php">Главная</a>
            <a href="clients.php">Клиенты</a>
            <a href="departments.php">Отделы</a>
        </td>
        <td>
            <form action="clients.php" method="post">
                <div>
                    <label>Фамилия:
                        <input type="text" name="surname">
                    </label>
                </div>
                <div>
                    <label>Имя:
                        <input type="text" name="name">
                    </label>
                </div>
                <div>
                    <label>Отчество:
                        <input type="text" name="middlename">
                    </label>
                </div>
                <div>
                    <label>Номер паспорта:
                        <input type="text" name="passport">
                    </label>
                </div>
                <div>
                    <label>Дата рождения:
                        <input type="text" name="birth_date">
                    </label>
                </div>
                <div>
                    <input name="add" value="Добавить" type="submit"/>
                </div>
            </form>
        </td>
    </tr>
</table>
<?php
foreach ($clients as $cleint) {
    $surname = $cleint["surname"];
    $name = $cleint["name"];
    $middlename = $cleint["middlename"];
    $passport = $cleint["passport"];
    $birth_date = $cleint["birth_date"];
    echo("<form action='clients.php' method='post'>");
    echo("<input type='hidden' name='id' value='$passport' ");
    echo("<label>Фамилия:<input type='text' name='surname' value='$surname'></label>");
    echo("<label>Имя:<input type='text' name='name' value='$name'></label>");
    echo("<label>Отчество:<input type='text' name='middlename' value='$middlename'></label>");
    echo("<label>Номер паспорта:<input type='text' name='passport' value='$passport'></label>");
    echo("<label>Дата рождения:<input type='text' name='birth_date' value='$birth_date'></label>");
    echo("<input name='save' value='Сохранить' type='submit'/></form>");
}
?>
<form action="clients.php" method="post">
    <select name='client'>
        <?php
        foreach ($clients as $cleint) {
            $surname = $cleint["surname"];
            $name = $cleint["name"];
            $middlename = $cleint["middlename"];
            $passport = $cleint["passport"];
            echo("<option value='$passport'>$surname $name $middlename ($passport)</option> ");
        }
        ?>
    </select>
    <input name='delete' value='Удалить' type='submit'/>
</form>
</body>
</html>