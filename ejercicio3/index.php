<?php

// Interfaz común para los personajes
interface Personaje {
    public function getNombre();
    public function getAtaque();
    public function getDatos();
}

// Clase concreta: Guerrero
class Guerrero implements Personaje {
    private $nombre;
    private $ataque = 10;

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getAtaque() {
        return $this->ataque; // Poder de ataque base
    }

    public function getDatos() {
        return "Guerrero: {$this->getNombre()}, Ataque: {$this->getAtaque()}";
    }
}

// Clase concreta: Mago
class Mago implements Personaje {
    private $nombre;
    private $ataque= 8;

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getAtaque() {
        return $this->ataque ; // Poder de ataque base
    }

    public function getDatos() {
        return "Mago: {$this->getNombre()}, Ataque: {$this->getAtaque()}";
    }
}

// Clase abstracta: Decorador de armas
abstract class ArmaDecorator implements Personaje {
    protected $personaje;

    public function __construct(Personaje $personaje) {
        $this->personaje = $personaje;
    }

    public function getNombre() {
        return $this->personaje->getNombre();
    }

    abstract public function getAtaque(); // Cada decorador puede modificar este método

    public function getDatos() {
        return $this->personaje->getDatos(); 
    }
}

// Decorador concreto: Espada
class Espada extends ArmaDecorator {
    private $bonusAtaque = 5;
    
    public function getAtaque() {
        return $this->personaje->getAtaque() + $this->bonusAtaque; // Incrementa el ataque en 5
    }
}

// Decorador concreto: Arco
class Arco extends ArmaDecorator {
    private $bonusAtaque = 3;
    public function getAtaque() {
        return $this->personaje->getAtaque() + $this->bonusAtaque; // Incrementa el ataque en 3
    }
}



//funcion para capturar la informacion del usuario
function prompt($mensaje){
    echo $mensaje;
    $input = trim(fgets(STDIN));
    return $input;
}

// Programa principal
function main($rol, $nombre, $arma) {
    if($rol === "guerrero"){
        $guerrero = new Guerrero($nombre);
        if($arma === "espada"){
            $guerreroConEspada = new Espada($guerrero);
            $guerreroConEspadayArco = new Arco($guerreroConEspada);
            echo "Se ha agregado arco como arma secundaria\n";
            echo "Personaje: " . $guerreroConEspadayArco->getNombre() . ", Ataque: " . $guerreroConEspadayArco->getAtaque() ."  base " . $guerrero->getAtaque(). " + bonificacion por armas". PHP_EOL;
        }
        else{
            $guerreroConArco = new Arco($guerrero);
            $guerreroConArcoyEspada = new Espada($guerreroConArco);
            echo "Se ha agregado espada como arma secundaria\n";
            echo "Personaje: " . $guerreroConArcoyEspada->getNombre() . ", Ataque: " . $guerreroConArcoyEspada->getAtaque() ."  base " . $guerrero->getAtaque(). " + bonificacion por armas". PHP_EOL;
        }
    }elseif($rol === "mago"){
        $mago = new Mago($nombre);
        if($arma === "espada"){
            $magoConEspada = new Espada($mago);
            $magoConEspadayArco = new Arco($magoConEspada);
            echo "Se ha agregado arco como arma secundaria\n";
            echo "Personaje: " . $magoConEspadayArco->getNombre() . ", Ataque: " . $magoConEspadayArco->getAtaque() ."  base " . $mago->getAtaque(). " + bonificacion por armas". PHP_EOL;
        }
        else{
            $magoConArco = new Arco($mago);
            $magoConArcoyEspada = new Espada($magoConArco);
            echo "Se ha agregado espada como arma secundaria\n";
            echo "Personaje: " . $magoConArcoyEspada->getNombre() . ", Ataque: " . $magoConArcoyEspada->getAtaque() ."  base " . $mago->getAtaque(). " + bonificacion por armas". PHP_EOL;
        }
    }
    
}
//Funcion para mostrar el menu
function display () {
    $datos = [];
    echo "---- Elden Ring ---- \n";
    echo "Crea tu personaje\n";
    $datos [0] = prompt("Elije un rol: \nGuerrero/Mago\n");
    
    if(strtolower($datos[0]) != "guerrero" && strtolower($datos[0]) != "mago"){
        echo "rol invalido\n";
        $datos [0] = prompt("Elije un rol: \nGuerrero/Mago(x para salir)\n");
        if($datos [2] === "x"){return;}
    }
    $datos [1] = prompt("Elije un nombre: \n");
    $datos [2] = prompt("Elije tu arma pricipal: \n(espada/arco)\n");
    if(strtolower($datos[2]) != "espada" && strtolower($datos[2]) != "arco"){
        echo "arma no valida\n";
        $datos [2] = prompt("Elije tu arma pricipal: \n(espada/arco)o x para salir");
        if($datos [2] === "x"){return;}
    }
    echo"";
    return $datos;
}

$datos = display ();
if(!empty($datos) && count($datos) === 3){
    main($datos[0], $datos[1], $datos[2]);
}




?>