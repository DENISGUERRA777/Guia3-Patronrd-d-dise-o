<?php

// Clase abstracta Personaje
abstract class Personaje {
    protected $velocidad;
    protected $ataque;

    // Método  para obtener los datos del personaje
    public function getDatos() {
        return "Velocidad: {$this->velocidad}, Ataque: {$this->ataque}";
    }
}

// Clase Esqueleto 
class Esqueleto extends Personaje {
    public function __construct() {
        $this->velocidad = 5;
        $this->ataque = "Machetazo";
    }
}

// Clase Zombi 
class Zombi extends Personaje {
    public function __construct() {
        $this->velocidad = 8;
        $this->ataque = "Vomito acido ";
    }
}

// Clase Factory para crear personajes
class PersonajeFactory {
    public static function crearPersonaje($nivel) {
        if ($nivel === "facil") {
            return new Esqueleto();
        } elseif ($nivel === "dificil") {
            return new Zombi();
        } else {
            throw new Exception("Nivel no válido $nivel");
        }
    }
}

//funcion para capturar la informacion del usuario
function prompt($mensaje){
    echo $mensaje;
    $input = trim(fgets(STDIN));
    return $input;
}

// Ejemplo de uso
try {
    // Crear un personaje pregunatnado al usario
    $nivel = prompt("Elige nivel: \n facil/dificil\n");
    $personaje = PersonajeFactory::crearPersonaje($nivel);
    echo "Personaje creado en nivel $nivel: " . $personaje->getDatos() . PHP_EOL;

    // Crear un personaje en nivel difícil
    $personajeDificil = PersonajeFactory::crearPersonaje("dificil");
    echo "Personaje creado en nivel difícil: " . $personajeDificil->getDatos() . PHP_EOL;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}