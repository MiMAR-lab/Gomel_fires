<?php
$db_server = "localhost";
$db_user = "root";
$db_password = "aadv1986";
$db_name = "forest_fires";
$db_table = "place";
try {
    // Открываем соединение, указываем адрес сервера, имя бд, имя пользователя и пароль,
    // также сообщаем серверу в какой кодировке должны вводится данные в таблицу бд.
    $db = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_password,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    // Устанавливаем атрибут сообщений об ошибках (выбрасывать исключения)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Переносим данные из полей формы в переменные.
    $fire_coord_lat=$_POST['fire_coord_lat'];
    $fire_coord_lon=$_POST['fire_coord_lon'];
    $fire_regions = array();
    
    if(!empty($_POST['fire_region'])){
        foreach($_POST['fire_region'] as $region_selected){
            $fire_regions[] = $region_selected;
        }
    }
    $fire_frst_name=$_POST['fire_frst_name'];
    $fire_qrt_num=$_POST['fire_qrt_num'];
    $fire_frstr_name=$_POST['fire_frstr_name'];
    $fire_srf_act=$_POST['fire_srf_act'];
    $fire_obs_pnt_dist=$_POST['fire_obs_pnt_dist'];
    $fire_obs_pnt_dir=$_POST['fire_obs_pnt_dir'];
 
        
    // Используем Prepared statements (заранее скомпилированное SQL-выражение) для защиты от SQL-инъекций.
    // Создаем ассоциативный массив для подстановки данных в запрос.
    $data = array(
        'coord_lat' => "$fire_coord_lat",
        'coord_lon' => "$fire_coord_lon",
        'frst_name' => "$fire_frst_name",
        'qrt_num' => "$fire_qrt_num",
        'frstr_name' => "$fire_frstr_name",
        'srf_act' => "$fire_srf_act",
        'obs_pnt_dist' => "$fire_obs_pnt_dist",
        'obs_pnt_dir' => "$fire_obs_pnt_dir",
    );
 
    // Запрос на создание записи в таблице
    // Если есть хоть один отмеченный жанр в форме, то составляем запрос, внося все отмеченные жанры,
    // иначе название жанра не вносим в таблицу.
    if(sizeof($fire_regions) > 0){
        $sql = "INSERT INTO place (coord_lat, coord_lon, region, frst_name, qrt_num, frstr_name, srf_act, obs_pnt_dist, obs_pnt_dir)".
        " VALUES (:coord_lat, :coord_lon, '" . implode(',', $fire_regions) . "', :frst_name, :qrt_num, :frstr_name, :srf_act, :obs_pnt_dist, :obs_pnt_dir)";    
    } else {
        $sql = "INSERT INTO place (coord_lat, coord_lon, region, frst_name, qrt_num, frstr_name, srf_act, obs_pnt_dist, obs_pnt_dir)".
    " VALUES (:coord_lat, :coord_lon, :frst_name, :qrt_num, :frstr_name, :srf_act, :obs_pnt_dist, :obs_pnt_dir)";
    }
    // Перед тем как выполнять запрос предлагаю убедится, что он составлен без ошибок.
    //echo $sql;
    
    // Подготовка запроса (замена псевдо переменных :title, :author и т.п. на реальные данные)
    $statement = $db->prepare($sql);
    // Выполняем запрос
    $statement->execute($data);
    
    echo "Запись успешно создана!";
}
 
catch(PDOException $e) {
    echo "Ошибка при создании записи в базе данных: " . $e->getMessage();
}
 
// Закрываем соединение
$db = null;
?>