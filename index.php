<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
<h2>База данных для учёта обслуженных граждан в СПб ГБУ «Центр социальной помощи семьи и детям Кронштадтского  района»</h2>

<?php
$server = 'localhost:3306';
$login = 'root';
$password = '123456';
$mysql_connect = mysql_connect($server, $login, $password);
if (!$mysql_connect) {
    die (mysql_error());
}
mysql_select_db('social', $mysql_connect);
mysql_set_charset('utf8');

?>

</body>
</html>