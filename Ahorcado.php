<?php
/******************************************
LUCAS VILLARRUEL FAI-1707
******************************************/
/**
MENU DE JUEGO
*@return int
*/
function seleccionarOpcion(){
/**
*@var bool $continuar
*@var int $opcion
*/
  echo "------------------------------------------------------------\n";
  echo   " ( 1 ) Jugar con una palabra aleatoria";
  echo "\n ( 2 ) Jugar con una palabra elegida";
  echo "\n ( 3 ) Agregar palabra al listado";
  echo "\n ( 4 ) Mostrar la informacion completa de un numero de juego";
  echo "\n ( 5 ) Mostrar la informacion del primer juego con mas puntaje";
  echo "\n ( 6 ) Mostrar el primer puntaje que supere un resultado escrito por el usuario";
  echo "\n ( 7 ) Mostrar lista de palabras ordenadas por puntaje";
  echo "\n ( 8 ) Restar un numero a mayor puntaje(Solo se puede usar despues de usar anteriormente la opcion 5)";
  echo "\n ( 9 ) Salir";
  echo "\n------------------------------------------------------------\n";
    $opcion = trim(fgets(STDIN));
    do {
        if (is_numeric($opcion) && filter_var($opcion, FILTER_VALIDATE_INT) && ($opcion > 0) && ($opcion <= 9)) {//is_integer($opcion); No me acepta los enteros correctamente
          $continuar = true;
        }else{
          $continuar = false;
          echo "------------------------------------------------------------\n";
          echo "\nIngrese opcion valida, pruebe nuevamente \n";
          $opcion = trim(fgets(STDIN));
        }
      }while ($continuar == false);
return $opcion;
}



/**
COLECCION DE PALABRAS PARA JUGAR
*@return array
*/
function cargarPalabras(){
  /**
  *@var array $coleccionPalabras
  */
      $coleccionPalabras = array();
      $coleccionPalabras[0]= array("palabra"=> "papa" , "pista" => "se cultiva bajo tierra", "puntosPalabra"=>7);
      $coleccionPalabras[1]= array("palabra"=> "hepatitis" , "pista" => "enfermedad que inflama el higado", "puntosPalabra"=> 7);
      $coleccionPalabras[2]= array("palabra"=> "volkswagen" , "pista" => "marca de vehiculo", "puntosPalabra"=> 10);
      $coleccionPalabras[3]= array("palabra"=> "precambrica" , "pista" => "es una división informal de la escala temporal geológica, es la primera y más larga etapa de la historia de la Tierra ", "puntosPalabra"=> 100);
      $coleccionPalabras[4]= array("palabra"=> "dignidad" , "pista" => "cualidad de digno", "puntosPalabra"=> 10);
      $coleccionPalabras[5]= array("palabra"=> "mineral" , "pista" => "solido de estructura cristalina", "puntosPalabra"=> 10);
      $coleccionPalabras[6]= array("palabra"=> "hipopotomonstrosesquipedaliofobia" , "pista" => "miedo irracional a la pronunciación de las palabras largas ", "puntosPalabra"=> 100);

return $coleccionPalabras;
}



/**
JUGAR CON PALABRA ALEATORIA (Obtener indice aleatorio)
*@param int $min
*@param int $max
*@return int
*/
function indiceAleatorioEntre($min,$max){
    $aleatorio = rand($min,$max); // rand devuelve un valor aleatorio entre dos parametros, incluyendo los mismos
    return $aleatorio;
}
/**
SOLICITAR UN VALOR ENTRE $min y $max para elegir una palabra
* @param int $min
* @param int $max
* @return int
*/
function solicitarIndiceEntre($min,$max){
  /**
  *@var int $seleccion
  *@var bool $continuar
  */
    do{
        echo "------------------------------------------------------------";
        echo "\nSeleccione un valor entre: ". $min." y ". $max ."\n";
        $seleccion = trim(fgets(STDIN));
         if (is_numeric($seleccion) && (filter_var($seleccion, FILTER_VALIDATE_INT)|| $seleccion == 0) && ($seleccion>=$min) && ($seleccion<=$max)) {
           $continuar = true;                                                       //Agrego el (||$seleccion == 0) porque el filtro no valida el 0 como entero
         }else {
           $continuar = false;
           echo "------------------------------------------------------------";
           echo "\nSeleccione un valor entre: ". $min." y ". $max ."\n";
           $seleccion = trim(fgets(STDIN));
         }
    }while($continuar == false);
    //(!($seleccion>=$min && $seleccion<=$max)) && (is_numeric($seleccion) == false) && (filter_var($seleccion, FILTER_VALIDATE_INT) == false)
    return $seleccion;
}



/**
INICIO DEL JUEGO
* Desarrolla el juego y retorna el puntaje obtenido
* Si descubre la palabra se suma el puntaje de la palabra más la cantidad de intentos que quedaron
* Si no descubre la palabra el puntaje es 0.
* @param array $coleccionPalabras
* @param int $indicePalabra
* @param int $cantIntentos
* @return int
*/
function jugar($coleccionPalabras,$indicePalabra, $cantIntentos){
  /**
  *@var string $pal, $pista, $palabra, $acumLetras, $letraSeleccionada
  *@var int $puntaje
  *@var bool $palabraFueDescubierta, $fueUsada, $letraExistente
  *@var array $coleccLetras
  */
    $pal = $coleccionPalabras[$indicePalabra]["palabra"];
    $pista = $coleccionPalabras[$indicePalabra]["pista"];
    $coleccLetras = dividirPalabraEnLetras($pal);
    $puntaje = 0;
    $palabraFueDescubierta = false;
    $palabra = stringLetrasDescubiertas($coleccLetras);
    $acumLetras = "";//Este acumula las letras que ya probo el jugador para darle una guia rapida
    echo "------------------------------------------------------------";
    echo "\n".$pista."\n";
    echo $palabra."\n";
    do {
      $letraSeleccionada = solicitarLetra();
      $fueUsada = usada($letraSeleccionada, $acumLetras);
        if ($fueUsada) {
          echo "------------------------------------------------------------";
          echo "\nPruebe una letra que no haya usado \n";
        }else{
                $letraExistente = existeLetra($coleccLetras,$letraSeleccionada);
              if ($letraExistente == true){
                $coleccLetras = destaparLetra($coleccLetras, $letraSeleccionada);
                $palabra = stringLetrasDescubiertas ($coleccLetras);
                $acumLetras = $acumLetras.strtoupper($letraSeleccionada);
              }else {
                $cantIntentos--;
                $acumLetras = $acumLetras.strtolower($letraSeleccionada);
                echo "\nLetra erronea... "."$letraSeleccionada"." no pertenece a la palabra."."\n";
                }
                echo "------------------------------------------------------------";
                echo "\n"."\n".strtoupper($palabra)."\n"."\n";
                echo $pista."\n";
                echo "Ya probaste con: ".$acumLetras."\n"."(Mayusculas acertadas, minusculas desacertadas)\n";
              if ($cantIntentos > 0) {
                  echo "Quedan ".$cantIntentos." intentos\n";
               }
             }
        $palabraFueDescubierta = palabraDescubierta($coleccLetras);
      if ($palabraFueDescubierta){
          $puntaje = ($coleccionPalabras[$indicePalabra]["puntosPalabra"]) + $cantIntentos;//$cantIntentos al no estar asignada a otra variable dentro de la funcion
          echo "------------------------------------------------------------\n";          //lo que va a hacer es modificarme el parametro formal, que a su vez, modifica
          echo strtoupper($palabra);                                                      //el valor de la variable del programa principal, el cual fue el parametro actual
          echo "\n¡¡¡¡¡¡GANASTE ".$puntaje." puntos!!!!!!\n";
        }
      if($cantIntentos == 0) {
              echo "------------------------------------------------------------\n";
              echo "No quedan intentos...";
              echo "\n¡¡¡¡¡¡AHORCADO!!!!!!\n";
        }
    }while ($cantIntentos > 0 && !$palabraFueDescubierta);//$palabraFueDescubierta != true);
return $puntaje;
}



/**
DIVIDE PALABRA EN LETRAS DENTRO DE UN ARREGLO
* @param string $palabra
* @return array
*/
function dividirPalabraEnLetras($palabra){
  /**
  *@var int $n
  *@var array $arregloLetras, $coleccionLetras
  */
  $n = strlen($palabra);//Cuenta las letras del string (tambien puedo contar los elementos ya siendo arreglo con Count)
  $arregloLetras = str_split($palabra);//Convierte un string en array indexado

  for ($i=0; $i < $n; $i++) {
    $coleccionLetras[$i] = ["letra" => "$arregloLetras[$i]", "descubierta" => false];  //$coleccionLetras = []; No hizo falta inicializarlo
    }
    return $coleccionLetras;
}



/**
SOLICITA LETRA Y HACE LA VERIFICACION
* @return string
*/
function solicitarLetra(){
  /**
  *@var string $letra
  *@var bool $letraCorrecta
  */
    $letraCorrecta = false;
    do{
        echo "\nIngrese una letra: ";
        $letra = strtolower(trim(fgets(STDIN)));
            if(strlen($letra)!=1 || !(ctype_alpha($letra))){ //ctype_alpha/upper/lower($string) comprueba que el dato ingresado sea alfabetico de Aa-Zz
                  echo "------------------------------------------------------------\n";
                  echo "\nDebe ingresar solo 1 letra de A-Z!\n";//in_array($letra, $rango) comprueba si un elemento existe en un arreglo, eso se usaria junto a
            }else{                                         //$rango = range(a,z) crea un arreglo con un rango seleccionado, para dar el mismo resultado
                  $letraCorrecta = true;
                 }
    }while(!$letraCorrecta);//!$letraCorrecta hace que continue el ciclo mientras $letraCorrecta sea falso, (porque cuando sea correcto se va a negar y es false)
    return $letra;
}



/**
COMPRUEBA SI LA LETRA YA SE USO
*@param string $letra
*@param string $acumuladorStr
*/
function usada($letra, $acumuladorStr){
  /**
  *@var string $str
  *@var bool $fueUsada
  *@var array $arregloAcumulador
  */
  $str = strtolower($acumuladorStr);
  $arregloAcumulador = str_split($str);//convierto $acumLetras en arreglo para comprobar con in_array(), si las letras ya fueron usadas
  $fueUsada = in_array($letra, $arregloAcumulador);
return $fueUsada;
}



/**
DETERMINA SI LA LETRA EXISTE EN EL ARREGLO
* @param array $coleccionLetras
* @param string $letra
* @return boolean
*/
function existeLetra($coleccionLetras,$letra){
/**
*@var int $cantLetras, $i
*@var bool $letraExistente
*/
    $cantLetras = Count($coleccionLetras);
    $i=0;
    do {
    if ($coleccionLetras[$i]["letra"] != $letra){//Mientras sea distinto de $letra se va a sumar un contador, para probar cada elemento del arreglo
      $letraExistente = false;
      $i++;
    }else{
        $letraExistente = true;
    }
    } while ($i < $cantLetras && !$letraExistente);//Al terminar de recorrer el arreglo o encontrar un true termina
return $letraExistente;
}



/**
ASTERISCOS
* obtiene la palabra con las letras descubiertas y * en las letras no descubiertas. Ejemplo: he**t*t*s
* @param array $coleccionLetras
* @return string
*/
function stringLetrasDescubiertas($coleccionLetras){
  /**
  *@var string $pal
  *@var int $i, $cantLetras
  */
      $cantLetras = Count($coleccionLetras);
      $i = 0;
      $pal = "";

      for ($i=0; $i < $cantLetras ; $i++) {
          if ($coleccionLetras[$i]["descubierta"]) {//Si es true automaticamente hace lo primero, no hace falta hacer ==true;
            $pal = $pal . $coleccionLetras[$i]["letra"];
          }else {
            $pal = $pal . "#";
          }
      }
return $pal;
}



/**
DESCUBRE LETRAS ACERTADAS
* Descubre todas las letras de la colección de letras iguales a la letra ingresada.
* Devuelve la coleccionLetras modificada, con las letras descubiertas
* @param array $coleccionLetras
* @param string $letra
* @return array
*/
function destaparLetra($coleccionLetras, $letra){
  /**
  *@var int $cantidadLetras
  */
      $cantidadLetras = Count($coleccionLetras);
      for ($i=0; $i < $cantidadLetras; $i++) {
        if ($coleccionLetras[$i]["letra"] == $letra ) {//podria usar tranquilamente un in_array($letra, $coleccionLetras[$i]["letra"]) junta a un range() para $i
          $coleccionLetras[$i]["descubierta"] = true;
          }//Tambien podría usar un foreach para destapar letra si $coleccionLetras[$i]["letra"] as $valor == $letra, ahi escribiria true en descubierto
        }
  return $coleccionLetras;
}



/**
DETERMINA SI LA PALABRA FUE DESCUBIERTA
* Determinar si la palabra fue descubierta, es decir, todas las letras fueron descubiertas
*Que lo recorra siempre mientras que sea verdadero, hasta que $i sea igual a $cantLetras, en cuyo caso retorna verdadero
*y si recorre todo el arreglo y se topa con alguna falsa que corte y devuelva falso
* @param array $coleccionLetras
* @return boolean
*/
function palabraDescubierta($coleccionLetras){
  /**
  *@var int $cantLetras, $i, $descubierta
  *@var bool $descubierta
  */
    $cantLetras = Count($coleccionLetras);
    $i = 0;
    $descubierta = 0;
    do {
      $descubierta = $coleccionLetras[$i]["descubierta"];
      $i++;
    } while ($descubierta && $i < $cantLetras); // != o <> son validos (Se una un && porque es necesario que ambos se complan para hacer la repeticion
return $descubierta;                                                 // si uso un || con que una de las dos sea verdadera va a crear un bucle infinito )
}                                                                   // no hace falta agregar el == true, porque ya es true el valor de la variable

/**
///////////////////////////////////////////↑FUNCIONES PARA JUGAR////////SEPARACION DE BLOQUES////////OPCIONES DE MENU↓///////////////////////////////////////////////////
*/



/**
AGREGAR PALABRA A LA COLECCION
*@return array
*/
function agregarPalabras(){
  /**
  *@var string $palabra, $conformePalabra, $pista, $conformePista
  *@var int $cantPalabras, $avanzar, $i, $puntaje
  *@var bool $yaExiste, $avanzar
  *@var array $listadoDePalabras, $palabraAgregada
  */
  $listadoDePalabras = cargarPalabras();// decia false
  $cantPalabras = Count($listadoDePalabras);
  $avanzar = 0;
  echo "\n------------------------------------------------------------\n";
  do{
    do {
      echo "Ingrese palabra que desee sumar al listado...\n";
      $palabra = strtolower(trim(fgets(STDIN)));
      echo "Esta conforme con ".$palabra." 'N' para reingresar palabra, cualquier otra tecla para continuar\n";
      $conformePalabra = strtolower(trim(fgets(STDIN)));
    }while ($conformePalabra == 'n');
    $i = 0;
    $yaExiste = false;
    while ($i <$cantPalabras && !$yaExiste){
      $yaExiste = in_array($palabra, $listadoDePalabras[$i]);
      $i++;
    }
    if ($yaExiste) {
          echo "Ya existe esa palabra en la coleccion...\n";
          echo "Ingrese otra palabra \n";
          echo "\n------------------------------------------------------------\n";
          $avanzar = false;
    }
    if(!$yaExiste){
      do {
          echo "Ingrese pista para descubrir la palabra...\n";
          $pista = strtolower(trim(fgets(STDIN)));
          echo "Esta conforme con ".$pista." " . "'N' para reingresar pista, cualquier otra tecla para continuar\n";
          $conformePista = strtolower(trim(fgets(STDIN)));
      }while ($conformePista == 'n');
      do {
        echo "Agregando el puntaje de la palabra, solo numeros \n";
        $puntaje = trim(fgets(STDIN));
      }while (filter_var($puntaje, FILTER_VALIDATE_INT) == false);
      $avanzar = true;
    }
  }while ($avanzar == false);
    $palabraAgregada = ["palabra"=> "$palabra" , "pista" => "$pista", "puntosPalabra"=>$puntaje];
return $palabraAgregada;
}




/**
TABLA DE PUNTAJE
*@return array
*/
function cargarJuegos(){ //Carga la tabla de puntaje
  /**
  *@var array $coleccionJuegos
  */
	$coleccionJuegos = array();
	$coleccionJuegos[0] = array("puntos"=> 105, "indicePalabra" => 3);
	$coleccionJuegos[1] = array("puntos"=> 10, "indicePalabra" => 0);
  $coleccionJuegos[2] = array("puntos"=> 8, "indicePalabra" => 1);
  $coleccionJuegos[3] = array("puntos"=> 106, "indicePalabra" => 6);
  $coleccionJuegos[4] = array("puntos"=> 12, "indicePalabra" => 2);
  $coleccionJuegos[5] = array("puntos"=> 11, "indicePalabra" => 4);
  $coleccionJuegos[6] = array("puntos"=> 13, "indicePalabra" => 5);

    return $coleccionJuegos;
}



/**
AGREGA LOS DATOS DE UNA PARTIDA JUGADA A LA COLECCION DE JUEGOS
* Agrega un nuevo juego al arreglo de juegos
* @param array $coleccionJuegos
* @param int $puntos
* @param int $indicePalabra
* @return array
*/
function agregarJuego($coleccionJuegos,$puntos,$indicePalabra){
  /**
  *@var int $i
  */
    $i=Count($coleccionJuegos);
    $coleccionJuegos[$i] = array("puntos"=> $puntos, "indicePalabra" => $indicePalabra);
    return $coleccionJuegos;
}



/**
MUESTRA LOS DATOS DE UNA PARTIDA JUGADA
(1)
* Muestra los datos completos de un juego
* @param array $coleccionJuegos
* @param array $coleccionPalabras
* @param int $indiceJuego
*/
function mostrarJuego($coleccionJuegos,$coleccionPalabras,$indiceJuego){
  /**
  *@var int $indPalabra, $intentos
  */
    echo "\n------------------------------------------------------------\n";
    echo "Juego: ".$indiceJuego."\n";
    echo "Puntos ganados: ".$coleccionJuegos[$indiceJuego]["puntos"]."\n";
    $indPalabra = $coleccionJuegos[$indiceJuego]["indicePalabra"];
    $intentos  = ($coleccionJuegos[$indiceJuego]["puntos"]) - ($coleccionPalabras[$indPalabra]["puntosPalabra"]);
    echo "Intentos sobrantes: ".$intentos."\n";
    echo "Información de la palabra: \n";
    mostrarPalabra($coleccionPalabras,$indPalabra);
    echo "\n";
}



/**
MUESTRA LOS DATOS DE LA PALABRA CUANDO SON SOLICITADOS POR EL MODULO (1)
(2)
* Muestra los datos completos de una palabra
* @param array $coleccionPalabras
* @param int $indicePalabra
*/
function mostrarPalabra($coleccionPalabras,$indicePalabra){
  /**
  *@var string $palabra, $pista
  *@var int $puntaje
  */
    $palabra = $coleccionPalabras[$indicePalabra]["palabra"];
    $pista = $coleccionPalabras[$indicePalabra]["pista"];
    $puntaje = $coleccionPalabras[$indicePalabra]["puntosPalabra"];
    echo "Palabra: ".$palabra."\n";
    //echo "Pista: ".$pista."\n";
    echo "Puntaje de la palabra: ".$puntaje."\n";

}



/**
PARTIDA CON MAS PUNTAJE
*@param array $juegos
*@param array $coleccionPalabras
*/
function mayorPuntaje ($juegos){
  /**
  *@var int $mayor, $i, $indPalabra, $intentos
  */
  $mayor = 0;
  $i= "";
  foreach($juegos as $nuevoi => $valor){
      if ($valor["puntos"]> $mayor) {
          $mayor = $valor["puntos"];
          $i = $nuevoi;
      }
  }

  return $i;
}



/**
PUNTAJE MAYOR AL SELECCIONADO
*@param array $juegos
*@param array $coleccP
*/
function puntajeMayorA ($juegos, $coleccP){
  /**
  *@var int $maximo, $indiceSelec, $seleccion, $nuevoi, $valorMaximo, $valorIdeal
  *@var array $valor
  */
  echo "\n------------------------------------------------------------\n";
  echo "Coloque su puntaje: \n";
  $maximo = 0;
  $indiceSelec= 0;
  $i=0;
  foreach($juegos as $nuevoi => $valor){
      if ($valor["puntos"]> $maximo) {
          $maximo = $valor["puntos"];
      }
    }
  $seleccion = solicitarIndiceEntre(0,($maximo-1));
  $valorMaximo = $maximo;
  $break = Count($juegos);
  $valorIdeal = 0;
    do {
      if ($juegos[$i]["puntos"] < $valorMaximo && $juegos[$i]["puntos"]> $seleccion) {
         $valorMaximo = $juegos[$i]["puntos"];
         $valorIdeal= $juegos[$i]["puntos"];
         $indiceSelec = $juegos[$i]["indicePalabra"];
      }
      $i++;
    } while ($i <> $break);

  echo "\n------------------------------------------------------------\n";
  echo "Puntaje que supere al seleccionado es: \n";
  echo "Puntos ganados: ".$valorIdeal."\n";
  echo "Del juego: ".$indiceSelec."\n";
  $indPalabra = $juegos[$indiceSelec]["indicePalabra"];
  $intentos  = ($juegos[$indiceSelec]["puntos"]) - ($coleccP[$indPalabra]["puntosPalabra"]);
  echo "Intentos sobrantes: ".$intentos."\n";
  echo "Información de la palabra: \n";
  mostrarPalabra($coleccP,$indPalabra);
  echo "\n";
}



/**
LISTA DE PALABRAS POR ORDEN ALFABERICO
* imprime en pantalla la coleccion de palabras ordenadas de forma descendiente
* @param array $ColPalabras
*/
function mostrasPalabrasOrdenadas($ColPalabras) {
   usort($ColPalabras, 'cmp');//Ordena el arreglo dada una funcion de comparacion
   print_r($ColPalabras);

}



/**
PARAMETROS DE ORDENAMIENTO
 * define la funcion de comparacion descendiente para el ordenamiento de un arreglo multidimensional
 * @param array $a
 * @param array $b
 * @return float
 */
function cmp($a, $b) {
    return strcmp($a["palabra"], $b["palabra"]);
}



/**
###################################PROGRAMA PRINCIPAL (JUEGO AHORCADO)###################################
*@var int $cantDeIntentos, $opcion, $aleatorio, $puntaje, $cantPalabras
*@var array $todasPalabras, $juegosHechos, $nuevoJuego, $nuevoIngreso
*/
$cantDeIntentos = 6; //Cantidad de intentos para adivinar cada palabra si este falla en alguna letra
$todasPalabras = cargarPalabras ();
$juegosHechos = cargarJuegos();

do{//Debe llamar a las funciones correspondientes para ejecutar cada opcion
    $opcion = seleccionarOpcion();
    switch ($opcion) {
    case 1: //Jugar con una palabra aleatoria
    $aleatorio = indiceAleatorioEntre (0, (Count($todasPalabras))-1);//Le resto 1 porque count me da un numero mas del que tengo en el arreglo
    $puntaje = jugar($todasPalabras,$aleatorio,$cantDeIntentos);
    $nuevoJuego = agregarJuego($juegosHechos,$puntaje,$aleatorio);//agregar nombre
    $juegosHechos = $nuevoJuego;
        break;
    case 2: //Jugar con una palabra elegida
    $seleccion = solicitarIndiceEntre (0, (Count($todasPalabras))-1);
    $puntaje = jugar($todasPalabras,$seleccion,$cantDeIntentos);
    $nuevoJuego = agregarJuego($juegosHechos,$puntaje,$seleccion);
    $juegosHechos = $nuevoJuego;
        break;
    case 3: //Agregar una palabra al listado
    $cantPalabras = Count($todasPalabras);//Solo ya me suma 1 porque Count no cuenta desde 0
    $nuevoIngreso = agregarPalabras();
    $todasPalabras[$cantPalabras]= $nuevoIngreso;
        break;
    case 4: //Mostrar la información completa de un número de juego
    $seleccion = solicitarIndiceEntre (0, (Count($juegosHechos))-1);
    mostrarJuego($juegosHechos,$todasPalabras,$seleccion);
        break;
    case 5: //Mostrar la información completa del primer juego con más puntaje
    $iM = mayorPuntaje($juegosHechos);
    mostrarJuego($juegosHechos,$todasPalabras,$iM);
        break;
    case 6: //Mostrar la información completa del primer juego que supere un puntaje indicado por el usuario
    puntajeMayorA ($juegosHechos, $todasPalabras);
        break;
    case 7: //Mostrar la lista de palabras ordenada por orden alfabetico
    mostrasPalabrasOrdenadas($todasPalabras);
        break;
    case 8: //Resta el valor que asigne el usuario a mayor puntaje
    echo "\nIngrese un valor que desee restar a mayor puntaje\n";
    $res = trim(fgets(STDIN));
    $iM = mayorPuntaje($juegosHechos);
    $juegosHechos[$iM]["puntos"] = $juegosHechos[$iM]["puntos"] - $res;
        break;
    }
}while($opcion != 9);

/**
FIN PROGRAMA
*/