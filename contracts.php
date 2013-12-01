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
    mysql_query("INSERT INTO `contract` (`name`,`department_id`) VALUES ('$name',$department_id)", $myConnect);
}
if (isset($_POST["save"])) {
    $name = $_POST["name"];
    $department_id = $_POST["department_id"];
    $id = $_POST["id"];
    $query = "update `contract` set `name` ='$name',`department_id`=$department_id where `service_id`=$id";
    mysql_query($query, $myConnect);
}
if (isset($_POST["delete"])) {
    $id = $_POST["service_id"];
    mysql_query("DELETE from `contract` where `service_id`=$id", $myConnect);
}


$mysql_query = mysql_query("select c.*,cl.name,cl.middlename,cl.surname from `contract` as c  join `client` as cl on c.client_passport = cl.passport", $myConnect);
if (!$mysql_query) {
    die(mysql_error());
}
$contracts = array();
while ($row = mysql_fetch_array($mysql_query)) {
    $contracts[] = $row;
}
mysql_free_result($mysql_query);


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
            <a href="services.php">Услуги</a>
            <a href="contracts.php">Дороворы</a>
        </td>
        <td>
            <form action="contracts.php" method="post">
                <div>
                    <label>Клиент:
                        <select name='department_id'>
                            <?php
                            foreach ($clients as $client) {
                                $surname = $client["surname"];
                                $name = $client["name"];
                                $middlename = $client["middlename"];
                                $passport = $client["passport"];
                                $birth_date = $client["birth_date"];
                                echo("<option value='$passport'>$surname $name $middlename ($passport)</option> ");
                            }
                            ?>
                        </select>
                    </label>
                </div>
                <div>
                    <label>Начало действия контракта:
                        <input type="text" name="start">
                    </label>
                </div>
                <div>
                    <label>Конец действия контракта:
                        <input type="text" name="end">
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
foreach ($contracts as $contract) {
    $client_passport = $contract["client_passport"];
    $contract_num = $contract["contract_num"];
    $end = $contract["end"];
    $start = $contract["start"];


    echo("<form action='contracts.php' method='post'>");
    echo("<input type='hidden' name='contract_num' value='$contract_num' ");
    echo("<label>Отдел: <select name='department_id'>");
    foreach ($clients as $client) {
        $surname = $client["surname"];
        $name = $client["name"];
        $middlename = $client["middlename"];
        $passport = $client["passport"];
        $birth_date = $client["birth_date"];

        if($passport ==$client_passport ){
            echo("<option selected value='$passport'>$surname $name $middlename ($passport)</option> ");
        }else{
        echo("<option value='$passport'>$surname $name $middlename ($passport)</option> ");
        }
    }
    echo("</select>");
    echo("<label>Начало:<input type='text' name='start' value='$start'></label>");
    echo("<label>Окончание:<input type='text' name='end' value='$end'></label>");


    echo("<input name='save' value='Сохранить' type='submit'/></form>");
}
?>
<form action="contracts.php" method="post">
    <select name='service_id'>
        <?php
        foreach ($contracts as $contract) {
            $client_passport = $contract["client_passport"];
            $contract_num = $contract["contract_num"];
            $end = $contract["end"];
            $start = $contract["start"];
            echo("<option value='$contract_num'>$contract_num(с $start по $end)</option> ");
        }
        ?>
    </select>
    <input name='delete' value='Удалить' type='submit'/>
</form>
</body>
</html>