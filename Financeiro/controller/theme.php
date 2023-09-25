<?php
        //o que fiz para funcionar o tema nas paginas html:
        //adicionei ID "body" na tag body.
        //criei a função verifyTheme()
        //na função connection, adicionei um novo output, e as verificações.
session_start();
if(isset($_POST['verify'])){
    //aqui cabe uma verificação no banco de dados, para ver qual a ultima configuração setada pelo user
    if(!isset($_SESSION['tema'])){
        $_SESSION['tema'] = 'dark';
    }
    echo $_SESSION['tema'];
}else
if(isset($_POST['tema'])){
    // echo "tema alterado de: ".$_SESSION['tema']." para: ".$_POST['tema']."<br>";
    $_SESSION['tema'] = $_POST['tema'];   
    echo $_SESSION['tema'];
}
if(isset($_POST['verificando'])){
    var_dump($_SESSION['tema']);
}

?>