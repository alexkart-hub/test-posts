<?php

$db = mysqli_connect('mysql', 'testuser', 'testpass');

print_r($db);

//if (!$db) {
//    echo '1' . PHP_EOL;
//    $conn = mysqli_connect('10.100.0.3', 'root');
//    if (!$conn) {
//        echo 'No' . PHP_EOL;
//    }
//    print_r($conn);
//    $res = createUser($conn);
//    print_r($res);
//    $conn->close();
//    $db = mysqli_connect($this->host, $this->user, $this->password);
//}
//print_r($db);
//
//
//function createUser($db)
//{
//    $sql = "CREATE USER `" . $this->user . "`@`" . $this->host . "` IDENTIFIED BY '" . $this->password . "';";
//    $sql .= " GRANT ALL PRIVILEGES ON *.* TO `" . $this->user . "`@`" . $this->host . "` WITH GRANT OPTION;";
//    echo $sql . PHP_EOL;
//    return $db->query($sql);
//}
