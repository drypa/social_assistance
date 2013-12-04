<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>
<h2>База данных для учёта обслуженных граждан в СПб ГБУ «Центр социальной помощи семьи и детям Кронштадтского
    района»</h2>

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

if (isset($_POST["add"])) {
    $contract_num = $_POST["contract_num"];
    $service_id = $_POST["service_id"];
    $date = $_POST["date"];
    $query = "insert into `service_log` (`contract_num`,`service_id`,`date`)
              values ($contract_num,$service_id,'$date')";
    mysql_query($query, $myConnect);
}


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




$mysql_query = mysql_query("select * from `services`", $myConnect);
if (!$mysql_query) {
    die(mysql_error());
}
$services = array();
while ($row = mysql_fetch_array($mysql_query)) {
    $services[] = $row;
}
mysql_free_result($mysql_query);


$mysql_query = mysql_query(
"SELECT log.*,s.name as service_name,cl.passport, d.name as department,
cl.name as client_name,cl.middlename, cl.surname,cl.birth_date FROM `service_log` as log
inner join `services` as s on s.service_id = log.service_id
inner join `departments` as d on d.department_id = s.department_id
inner join `contract` as c on c.contract_num = log.contract_num
inner join `client` as cl  on cl.passport = c.client_passport", $myConnect);
if (!$mysql_query) {
    die(mysql_error());
}
$logs = array();
while ($row = mysql_fetch_array($mysql_query)) {
    $logs[] = $row;
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
                В рамках договора:<select name='contract_num'>
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
                Оказана услуга:
                <select name='service_id'>
                    <?php
                    foreach ($services as $service) {
                        $name = $service["name"];
                        $id = $service["service_id"];
                        echo("<option value='$id'>$name</option> ");
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
<table>
    <tr>
        <th>Номер договора</th>
        <th>Название услуги</th>
        <th>Отдел</th>
        <th>Дата оказания услуги</th>
        <th>ФИО клиента</th>
        <th>Дата рождения клиента</th>
    </tr>
    <?php
    foreach($logs as $l){
        $id= $l['id'];
        $contract_num= $l['contract_num'];
        $service_id= $l['service_id'];
        $date= $l['date'];
        $service_name= $l['service_name'];
        $passport = $l['passport'];
        $department= $l['department'];
        $client_name= $l['client_name'];
        $middlename= $l['middlename'];
        $birth_date= $l['birth_date'];
        $surname= $l['surname'];
        echo("<tr>");
        echo("<td>$contract_num</td>");
        echo("<td>$service_name</td>");
        echo("<td>$department</td>");
        echo("<td>$date</td>");
        echo("<td>$surname $client_name $middlename</td>");
        echo("<td>$birth_date</td>");
        echo("</tr>");
    }
    ?>

</table>
</body>
</html>