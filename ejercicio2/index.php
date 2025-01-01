<?php

// Interfaz común para los sistemas operativos
interface SistemaOperativo {
    public function abrirArchivo($nombreArchivo);
}

// Clase para Windows 10 (puede abrir archivos compatibles)
class Windows10 implements SistemaOperativo {
    public function abrirArchivo($nombreArchivo) {
        echo "Abriendo archivo $nombreArchivo en Windows 10." . PHP_EOL;
    }
}

// Clase para Windows 7 (archivos antiguos)
class Windows7 {
    public function abrirArchivoViejo($nombreArchivo) {
        echo "Abriendo archivo $nombreArchivo en Windows 7 (formato antiguo)." . PHP_EOL;
    }
}

// Adaptador que traduce los archivos de Windows 7 a Windows 10
class AdaptadorWindows7 implements SistemaOperativo {
    private $windows7;

    public function __construct(Windows7 $windows7) {
        $this->windows7 = $windows7;
    }

    public function abrirArchivo($nombreArchivo) {
        // Adaptación: Usamos el método de Windows 7 para abrir archivos antiguos
        echo "Adaptando archivo $nombreArchivo para Windows 10..." . PHP_EOL;
        $this->windows7->abrirArchivoViejo($nombreArchivo);
    }
}

// Programa principal
function main($archivo) {
    //se extrael la extencion del archivo y se valida
    $subArchivo = substr($archivo, strrpos($archivo, '.')+1);
    if($subArchivo === ".docx" || $subArchivo === ".xlsx" || $subArchivo === ".pptx"){
        $windows10 = new Windows10();
        $windows10->abrirArchivo($archivo);
    }elseif($subArchivo === "doc" || $subArchivo === ".xls" || $subArchivo === ".ppt"){

        $windows7 = new Windows7();
        $adaptador = new AdaptadorWindows7($windows7);
        $adaptador->abrirArchivo($archivo);
    }else{
        echo $subArchivo;
        $nombreArchivo= prompt("Archivo no valido \nasegurese que la extension de su archivo se a la correcta o presione x para salir.\n");
        if($nombreArchivo === "x"){
            
        }else{
            main($nombreArchivo);
        }
       
    }
}

//funcion para capturar lo que escriba el ususario 
function prompt($mensaje){
    echo $mensaje;
    $input = trim(fgets(STDIN));
    return $input;
}

$nombreArchivo = prompt("Ingrese el nombre del archivo que que desea abrir(Ej.Curriculum.docx):\n");
main($nombreArchivo);

?>

