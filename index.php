<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require('CONECTION/conectBD.php');
    //require('LIB/FPDF/fpdf.php'); //FPDF -> Permite manipular el pdf
    //require('LIB/FPDI/src/autoload.php'); //FPDI -> Permite modificar un pdf existente
    
    // Definir la consulta SQL
    $sql = "
        SELECT * 
        FROM glpi_tickets 
        WHERE name = 'Formulario Sanitas'
        AND id = 13
        ";
    // Ejecutar la consulta
    $consulta = $conexion->query($sql);
    // Verificar si hay resultados
    if ($consulta->rowCount() > 0) {
        // Recorrer y mostrar los resultados
        foreach ($consulta as $fila) {
            $html = $fila['content']; // 'content' tiene el HTML completo

            $cadenaDecodificada = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8'); // Codifica HTML

            // Cargar el HTML en DOMDocument
            $dom = new DOMDocument();
            libxml_use_internal_errors(true); // Ignorar errores de formato HTML
            $dom->loadHTML($cadenaDecodificada);
            libxml_clear_errors();

            // Crear un array para almacenar los contenidos de los div
            $arrayDivs = [];

            // Obtener todos los elementos <div> del HTML
            $divs = $dom->getElementsByTagName('div');

            // Recorrer cada div y almacenar su contenido en el array
            foreach ($divs as $key => $div) {
                //$arrayDivs[] = trim($div->textContent); // Guardar el texto de cada div            
                $arrayDivs[] = [explode(":", trim($div->textContent))]; // Guardar el texto de cada div               
            }
            $arrayData = array();
            foreach ($arrayDivs as $item){ //Limpieza de datos
                foreach($item as $i){
                    if(isset($i[0]) && isset($i[1]) && $i[0] != "" && $i[1] != ""){
                        /*
                        if($i[0] == "21) Observaciones ")
                            $arrayData["Observaciones"] = $i[1];
                        if($i[0] == "22) Cedula ")
                            $arrayData["Cedula"] = $i[1];
                        */
                        $arrayData[$i[0]] = $i[1];
                    }
                }
            }
            // Mostrar el array resultante
            //print_r($arrayData);
        }
    } else {
        echo "No se encontraron resultados.";
    }
    
    $jsonData = json_encode($arrayData, true);
    //$pythonScript = escapeshellcmd("python C:\\xampp\\htdocs\\GestionPDFs\\PY\\processPDF.py " . escapeshellarg($jsonData));
    $pythonScript = escapeshellcmd("python C:\\xampp\\htdocs\\GestionPDFs\\PY\\processPDF.py " . $jsonData);
    exec($pythonScript, $output, $resultCode);
  
    print_r($output);

    ?>
</body>
</html>
