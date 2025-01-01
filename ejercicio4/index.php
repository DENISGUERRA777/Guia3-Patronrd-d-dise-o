<?php
    interface SalidaStrategy {
        public function mostrar($mensaje);
    }

    //estrategias implementamos nustra interface
    class SalidaConsola implements SalidaStrategy {
        public function mostrar($mensaje) {
            echo "Consola: " . $mensaje . PHP_EOL;
        }
    }

    class SalidaJSON implements SalidaStrategy {
        public function mostrar($mensaje) {
            echo json_encode(["mensaje" => $mensaje]) . PHP_EOL;
        }
    }

    class SalidaArchivo implements SalidaStrategy {
        public function mostrar($mensaje) {
            file_put_contents("salida.txt", $mensaje . PHP_EOL, FILE_APPEND);
            echo "Mensaje guardado en archivo: salida.txt" . PHP_EOL;
        }
    }

    
    //contexto para cambiar de estrategia 
    class ContextoMensaje {
        private $strategy; // Estrategia actual
    
        public function setStrategy(SalidaStrategy $strategy) {
            $this->strategy = $strategy;
        }
    
        public function ejecutar($mensaje) {
            if ($this->strategy) {
                $this->strategy->mostrar($mensaje);
            } else {
                echo "No se ha definido una estrategia de salida." . PHP_EOL;
            }
        }
    }

    //funcion para capturar la informacion del usuario
    function prompt($mensaje){
        echo $mensaje;
        $input = trim(fgets(STDIN));
        return $input;
    }


    // Crear las estrategias 
    $consola = new SalidaConsola();
    $json = new SalidaJSON();
    $archivo = new SalidaArchivo();
    $contexto = new ContextoMensaje();

    $flag = true;
    while($flag){
        $mensaje = prompt("Escribe un mensaje: \n");
    
        // Usar la estrategia de salida por consola
        $contexto->setStrategy($consola);
        $contexto->ejecutar($mensaje);
        // Cambiar a la estrategia de salida JSON
        $contexto->setStrategy($json);
        $contexto->ejecutar($mensaje);
        // Cambiar a la estrategia de salida en archivo
        $contexto->setStrategy($archivo);
        $contexto->ejecutar($mensaje);

        if(prompt("Volver a intetarlo:s/n \n") === "n"){$flag = false;}
    }
    


?>