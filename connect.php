<?php



define('username', 'root');
define('server', 'localhost');
define('password', '');
define('database', 'mendoza_prison');



 //database connection
 $conn = mysqli_connect(server,username,password,database);

 if($conn){echo "Connection Success";
}else{echo "Failed to establish a connection.".mysqli_conect_error();
}
?>