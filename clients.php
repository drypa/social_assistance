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
    $birth_date = $_POST["birth_date"];
    $birth_date = date("Y-m-d", strtotime($birth_date));
    $query = "update `client` set `name` ='$name',`surname`='$surname',`passport`='$passport',`middlename`='$middlename',
                `birth_date`='$birth_date'";
    mysql_query($query, $myConnect);
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
    echo("<label>Фамилия:<input type='text' name='surname' value='$surname'></label>");
    echo("<label>Имя:<input type='text' name='name' value='$name'></label>");
    echo("<label>Отчество:<input type='text' name='middlename' value='$middlename'></label>");
    echo("<label>Номер паспорта:<input type='text' name='passport' value='$passport'></label>");
    echo("<label>Дата рождения:<input type='text' name='birth_date' value='$birth_date'></label>");
    echo("<input name='save' value='Сохранить' type='submit'/></form>");
}
?>

</body>
</html>