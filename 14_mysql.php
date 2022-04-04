<?php
$ip = '127.0.0.1';  //localhost
$username = 'root';
$password = '';
$data = 'casino';

// jungiames prie duomenu bazes
$database = mysqli_connect($ip, $username, $password, $data);

// Tikrinam ar pavyko prisijungti prie duomenu bazes
if (!$database) {
    die("connection failed: " . mysqli_connect_error());
} else {
    echo 'Pavyko prisijungti';
}

echo '<pre>';

// select - gauti / paimti nuskaityti duomenis

// sql kodas skirtas pasiimti duomenis is mysql
//$sql = 'select * from users';

// leidziam mysql koda i duomenu baze
//$result = mysqli_query($database, $sql);

//pasiimam rezultata is duomenu bazes atsakymo
//$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
//
//foreach ($users as $user) {
//    var_dump($user['name']);
//    echo '<pre>';
//}



// update - atnaujinti duomenis
//$sql = 'update users set name = "karolis" where id = 6';
//$result = mysqli_query($database, $sql);
//var_dump($result);

// create - irasyti duomenis
//$sql = 'insert into users (name, age, sex, password, email) value ("petras", 30, "male", "123456", "opapa@email.com")';
//$result = mysqli_query($database, $sql);
//var_dump($result);


// delete - istrinti duomenis
//$sql = 'delete from users where id = 2';
//$result = mysqli_query($database, $sql);
//var_dump($result);

// // dalykai mysql

//TRUNCATE rezervacijos;


//SELECT * FROM news order by updated_at desc, created_at desc;
//
//select count(id) from news;
//
//select count(id) as blabla, user_id from news group by user_id;

# skaičiuoja visu zaidimu suma
//select count(result) as wins from game_history;
//# skaiuoja visu zaidimu kieki per user
//select count(result) as games, user_id from game_history group by user_id;
//# skaiuoja visu zaidimu kieki per tam tikra user
//select count(result) as games, user_id from game_history where user_id = 'bla@blabla.com';
//# gauti tik laimejimu kieki per user
//select count(case when result = 'win' then 1 end) as wins, user_id from game_history group by user_id order by wins desc;
//# gauti visus zaidimu kieki ir laimejimu kieki per user
//select count(result) as games, sum(case when result = 'win' then 1 else 0 end) as wins, user_id from game_history group by user_id order by wins desc limit 3;