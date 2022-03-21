<?php
/*Identica los posibles errores a considerar:
   1.- El nombre está vacío
   2.- El teléfono no es numérico
   3.-
*/
function valida_datos($name,$tlf,$agenda ){
    $error = null;
    if ($name=="") {                                                //el nombre esta vacio
            $error = " el nombre no es valido ";
        }

        if (!is_numeric($tlf)and($tlf!=="") ) {                                    // el numero no es numerico
            $error = "el telefono no es un valor numérico o esta vacio";
                }else {
            if ( !array_key_exists($name, $agenda)) {
                $error = "el contacto no se puede eliminar de la agenda ya que no existe"; //el $name no existe en la array $agenda[nombre] nos dara un true
            }
        }
    return $error;
}

    // RF1  Si he apretado submit
if (isset($_POST['submit'])){
    // RF2 Leer valores del formulario (nombre, tel, agenda)
    $name= filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);   // nombre
    $tlf= filter_input(INPUT_POST,'tlf');                                  // telefono
    $agenda=$_POST['agenda']??[];                                                        // la agenda
    var_dump($name);
    var_dump($tlf);
}
//RF3 Vamos a establecer una variable de error
$error = null; // con esta variable tenemos que comparar los posibles errores
/*
RF 4, el kernel del ejercicio:
 Ahora ya tenemos los datos del usuario RF1 y posible error RF 2
 Actuamos en consecuencia:

//Si hay error, informamos de ello
//Si no  hay error realizamos la acción selecciona (add o borrar)
*/
$validar =valida_datos($name, $tlf, $agenda);                                                          // null o msj error segun el caso eh el que se encuentre
var_dump($validar);

if ($validar==$error){                                                                                 // verificar si validar es null que significa q no hay errores si no es asi nos da un mensaje en pantalla
    if (array_key_exists('nombre', $agenda) ){                                            // verificamos si el nombre existe en la array TRUE
                if ($tlf=="" ){
                    unset($agenda['nombre']);                                                          // borramos el contacto
                    $error="se ha borrado el $name de la agenda ";
                    echo ($error);
                }else {
                    $agenda[$name]=$tlf;
                    $telf_borrado= array_pop($agenda);
                    $error="se ha modificado el $telf_borrado del contacto $name por $tlf ";           // modificamos el contacto
                    echo ($error);
                }
    }else{
        $agenda[$name]=$tlf;                                                                          // añadimos el contacto
        $error="se ha añadido un nuevo contacto a al agenda";
        echo end ($agenda).$error;
    }

    echo "$validar";
}
var_dump($agenda );
     ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda</title>
</head>
<body>
<h1><?=$error?>   </h1>
<form action="index.php" method="POST">
    <fieldset>
    <legend>Datos de contacto</legend>
    <label for="">Nombre </label>
    <input type="text" name="name" id="" />
    <label for="">Telefono </label>
    <input type="text" name="tlf" id="" />
    <div class="form-buttons">
        <button type="submit" value="enviar" name="submit">Enviar</button>
        <button type="reset"  value="Borrar">Borrar</button>
        <?php
        foreach ($agenda as $nombre => $tel) {
            echo "<input type='hidden' name='agenda[$nombre]' value ='$tel'>\n";

        } ?>
    </div>
    </fieldset>
</form>
</body>
</html>
