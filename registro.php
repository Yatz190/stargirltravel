<?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono =$_POST['telefono'];
$fecha = $_POST['fecha'];
$salida = $_POST['salida'];
$destino = $_POST['destino'];


if(!empty($nombre) || !empty($email) || !empty($telefono) || !empty($fecha) || !empty($salida) || !empty($destino)){
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "agencia";

    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
    if(mysqli_connect_error()){
        die('connect error('.mysqli_connect_error().')'.mysqli_connect_error());
    }
    else{
        $SELECT = "SELECT email from datos where email = ? limit 1";
        $INSERT = "INSERT INTO datos (nombre,email,telefono,fecha,salida,destino)values(?,?,?,?,?,?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt ->bind_param("s", $email);
        $stmt ->execute();
        $stmt ->bind_result($email);
        $stmt ->store_result();
        $rnum =$stmt->num_rows;
        if($rnum == 0){
            $stmt ->close();
            $stmt = $conn->prepare($INSERT);
            $stmt ->bind_param("ssisss", $nombre,$email,$telefono,$fecha,$salida,$destino);
            $stmt ->execute();
            echo "REGISTRO COMPLETADO EXITOSAMENTE.";
        }
        else{
            echo "El Correo ya esta registrado en otra cuenta.";
        }
        $stmt->close();
        $conn->close();
    }
}

else{
    echo "Todos los datos son obligatorios";
    die();
}
?>