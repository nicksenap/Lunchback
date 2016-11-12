<?php
// define vars
$host = 'localhost';
$user = 'root';
$pass = 'root';
$dbname = 'Lunchback';


// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
//$request = explode('/', trim($_SERVER['PATH_INFO'];,'/'));
$request = $_SERVER['PATH_INFO'];
$input = json_decode(file_get_contents('php://input'),true);

// connect to the mysql database
$link = mysqli_connect($host, $user, $pass, $dbname);
mysqli_set_charset($link,'utf8');

// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
// $key = array_shift($request)+0;
$key = 1;

// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($link) {
    if ($value===null) return null;
    return mysqli_real_escape_string($link,(string)$value);
},array_values($input));

// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
    $set.=($i>0?',':'').'`'.$columns[$i].'`=';
    $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}

// create SQL based on HTTP method
switch ($method) {
    case 'GET':
        $sql = "SELECT masterId FROM (
        SELECT masterId,candidateId FROM (
        SELECT DISTINCT t1.user_id as masterId,
                concat(p1.first_name,' ',p1.last_name) as masterName,
                p1.headline,p2.id as candidateId

        FROM lunchback_user_tags t1 JOIN lunchback_user_tags t2,
             lunchback_user_profiles p1 JOIN lunchback_user_profiles p2
        WHERE t2.user_id = ".$key."
            AND t1.user_id != t2.user_id
            AND t1.tag_type = 'offering'
            AND t2.tag_type = 'searching'
            AND t1.tag = t2.tag
            AND p1.id = t1.user_id
            AND p2.id = t2.user_id
            AND t2.tag = t1.tag
            AND p1.base_city = p2.base_city
            AND p1.removed = 0
            AND p2.removed = 0
            AND t1.removed = 0
            AND t2.removed = 0
        UNION
        SELECt DISTINCT h1.target_id as masterId ,
                        concat(p.first_name,' ',p.last_name) as masterName,
                        p.headline,h1.user_id as candidateId
        FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p
        WHERE h1.user_id = ".$key."
            AND h2.user_id = h1.target_id
            AND h2.target_id = h1.user_id
            AND p.id = h1.target_id) AS FOO
                      )AS FAK INNER JOIN
                          lunchback_user_interested_user ON masterId = lunchback_user_interested_user.user_id,lunchback_user_profiles
        WHERE candidateId = target_id
            AND masterId = lunchback_user_profiles.id
        UNION
        SELECt DISTINCT h1.target_id as masterId ,
                        concat(p.first_name,' ',p.last_name) as masterName,
                        p.headline, p.base_city as masterLocation 
        FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p
        WHERE h1.user_id = ".$key."
            AND h2.user_id = h1.target_id
            AND h2.target_id = h1.user_id
            AND p.id = h1.target_id
            AND h1.user_id != h1.target_id";break;

    // $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
    case 'PUT':
        // $sql = "update `$table` set $set where id=$key"; break;
    case 'POST':
        // $sql = "insert into `$table` set $set"; break;
    case 'DELETE':
        // $sql = "delete `$table` where id=$key"; break;
}

// excecute SQL statement
$result = mysqli_query($link,$sql);

// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error());
}

// print results, insert id or affected row count
if ($method == 'GET') {
    if (!$key) echo '[';
    for ($i=0;$i<mysqli_num_rows($result);$i++) {
        echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$key) echo ']';
} elseif ($method == 'POST') {
    echo mysqli_insert_id($link);
} else {
    echo mysqli_affected_rows($link);
}

// close mysql connection
mysqli_close($link);
