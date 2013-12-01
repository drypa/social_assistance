<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>
<h2>Отделы</h2>
<?php

$myConnect = mysql_connect('localhost:3306', 'root', '123456');
if (!$myConnect) {
    die (mysql_error());
}
mysql_select_db('social', $myConnect);
mysql_set_charset('utf8');

if (isset($_POST["add"])) {
    $name = $_POST["name"];
    mysql_query("INSERT INTO `departments` (`name`) VALUES ('$name')", $myConnect);
}
if (isset($_POST["save"])) {
    $name = $_POST["name"];
    $id = $_POST["id"];
    $query = "update `departments` set `name` ='$name' where `department_id`='$id'";
    mysql_query($query, $myConnect);
}
    if (isset($_POST["delete"])) {
        $id = $_POST["department"];
        mysql_query("DELETE from `departments` where `department_id`='$id'", $myConnect);
    }



$mysql_query = mysql_query("select * from `departments`", $myConnect);
if (!$mysql_query) {
    die(mysql_error());
}
$departments = array();
while ($row = mysql_fetch_array($mysql_query)) {
    $departments[] = $row;
}
mysql_free_result($mysql_query);

?>


<table>
    <tr>
        <td class='menu'>
            <a href="index.php">Главная</a>
            <a href="clients.php">Клиенты</a>
            <a href="departments.php">Отделы</a>
            <a href="services.php">Услуги</a>
        </td>
        <td>
            <form action="departments.php" method="post">
                <div>
                    <label>Название отдела:
                        <input type="text" name="name">
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
foreach ($departments as $department) {
    $name = $department["name"];
    $id = $department["department_id"];

    echo("<form action='departments.php' method='post'>");
    echo("<input type='hidden' name='id' value='$id' ");
    echo("<label>Название:<input type='text' name='name' value='$name'></label>");
    echo("<input name='save' value='Сохранить' type='submit'/></form>");
}
?>
<form action="departments.php" method="post">
    <select name='department'>
        <?php
        foreach ($departments as $department) {
            $name = $department["name"];
            $id = $department["department_id"];
            echo("<option value='$id'>$name</option> ");
        }
        ?>
    </select>
    <input name='delete' value='Удалить' type='submit'/>
</form>
</body>
</html>