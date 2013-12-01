<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>
<h2>Услуги</h2>
<?php

$myConnect = mysql_connect('localhost:3306', 'root', '123456');
if (!$myConnect) {
    die (mysql_error());
}
mysql_select_db('social', $myConnect);
mysql_set_charset('utf8');

if (isset($_POST["add"])) {
    $name = $_POST["name"];
    $department_id = $_POST["department_id"];
    mysql_query("INSERT INTO `services` (`name`,`department_id`) VALUES ('$name',$department_id)", $myConnect);
}
if (isset($_POST["save"])) {
    $name = $_POST["name"];
    $department_id = $_POST["department_id"];
    $id = $_POST["id"];
    $query = "update `services` set `name` ='$name',`department_id`=$department_id where `service_id`=$id";
    mysql_query($query, $myConnect);
}
if (isset($_POST["delete"])) {
    $id = $_POST["service_id"];
    mysql_query("DELETE from `services` where `service_id`=$id", $myConnect);
}



$mysql_query = mysql_query("select * from `services`", $myConnect);
if (!$mysql_query) {
    die(mysql_error());
}
$services = array();
while ($row = mysql_fetch_array($mysql_query)) {
    $services[] = $row;
}
mysql_free_result($mysql_query);

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
            <form action="services.php" method="post">
                <div>
                    <label>Название услуги:
                        <input type="text" name="name">
                    </label>
                </div>
                <div>
                    <label>Название отдела:
                        <select name='department_id'>
                            <?php
                            foreach ($departments as $department) {
                                $dname = $department["name"];
                                $did = $department["department_id"];
                                echo("<option value='$did'>$dname</option> ");
                            }
                            ?>
                        </select>
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
foreach ($services as $service) {
    $name = $service["name"];
    $id = $service["service_id"];
    $department_id = $service["department_id"];

    echo("<form action='services.php' method='post'>");
    echo("<input type='hidden' name='id' value='$id' ");
    echo("<label>Название:<input type='text' name='name' value='$name'></label>");
    echo("<label>Отдел: <select name='department_id'>");
    foreach ($departments as $department) {
        $dname = $department["name"];
        $did = $department["department_id"];
        if($did ==$department_id ){
            echo("<option selected value='$did'>$dname</option> ");
        }else{
        echo("<option value='$did'>$dname</option> ");
        }
    }

    echo("</select>");
    echo("<input name='save' value='Сохранить' type='submit'/></form>");
}
?>
<form action="services.php" method="post">
    <select name='service_id'>
        <?php
        foreach ($services as $service) {
            $name = $service["name"];
            $id = $service["service_id"];
            echo("<option value='$id'>$name</option> ");
        }
        ?>
    </select>
    <input name='delete' value='Удалить' type='submit'/>
</form>
</body>
</html>