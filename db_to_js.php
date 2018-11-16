var array_users = [
    <?php
        $query = mysql_query("SELECT * FROM utilizador");
        while ($user = mysql_fetch_assoc($query)) {
            $user_name = $user["nome"];
            echo "'$user_name',";
        }
    ?>
];

var array_musics = [
    <?php
        $query = mysql_query("SELECT * FROM musica");
        while ($car = mysql_fetch_assoc($query)) {
            $car_name = $car["name"];
            echo "'$car_name',";
        }
    ?>
];
