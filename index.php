<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>
<h2>База данных для учёта обслуженных граждан в СПб ГБУ «Центр социальной помощи семьи и детям Кронштадтского  района»</h2>

<?php
$server = 'localhost:3306';
$login = 'root';
$password = '123456';
$myConnect = mysql_connect($server, $login, $password);
if (!$myConnect) {
    die (mysql_error());
}
mysql_select_db('social', $myConnect);
mysql_set_charset('utf8');

//запрос контрактов
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
<table class="content">
    <tr>
        <td class='menu'>
            <a href="index.php">Главная</a>
            <a href="clients.php">Клиенты</a>
            <a href="departments.php">Отделы</a>
            <a href="services.php">Услуги</a>
            <a href="contracts.php">Дороворы</a>
        </td>
        <td>
            <form action="index.php" method="post">
            <h3 class="center">Журнал учета услуг</h3>
            Услуга:<select name='contract_num'>
                <?php
                foreach ($contracts as $contract) {
                    $client_passport = $contract["client_passport"];
                    $contract_num = $contract["contract_num"];
                    $end = $contract["end"];
                    $start = $contract["start"];
                    $surname = $contract["surname"];
                    $name = $contract["name"];
                    $middlename = $contract["middlename"];
                    echo("<option value='$contract_num'>$contract_num(с $start по $end) клиент: $surname $name $middlename</option> ");
                }
                ?>
            </select>
            <br>
            Оказана пользователю:
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
            <br>
            Дата:
            <input type="text" name='date'/>
            <br>
            <input type="submit" name='add' value="Сохранить">
            </form>
        </td>
    </tr>
</table>
</body>
</html>