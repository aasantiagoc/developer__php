<?php
require "vendor/autoload.php";

$app = new \Slim\Slim();

$app->config(array(
    'templates.path' => 'views',
));
$app->contentType('text/html; charset=utf-8');

//Views
//Listado de Empleados
$app->get('/', function() use($app) {
	echo file_get_contents("employees.json");
});
//Buscar Empleado por Email
$app->get('/buscar/:email', function($email = "") use($app) {

    $employees = json_decode(file_get_contents("employees.json"), true);
	echo json_encode(array_filter($employees,function($item) use($email){ return $item['email'] == $email; }));

});

//Detalle de un Empleado
$app->get('/empleado/:id', function($id) use($app) {

    $employees = json_decode(file_get_contents("employees.json"), true);
    $key = array_search($id, array_column($employees, 'id'));
	echo json_encode($employees[$key]);
});


//Api
$app->get('/api/empleados/:min/:max', function($min,$max) use($app) {

   $app->response()->header('Content-Type','application/xml');
   $xml = new SimpleXMLElement('<root/>');
   $employees = json_decode(file_get_contents("employees.json"), true);
   $r = array();
   foreach ($employees as $employee) {
        if ( clearmoney($employee['salary']) >= $min && clearmoney($employee['salary']) <= $max) {
            $r[] = $employee;
        }
   }
   array_to_xml($r, $xml);
   echo $xml->asXML();
});

//Functions
function array_to_xml($template_info, &$xml_template_info) {
    foreach($template_info as $key => $value) {

        if(is_array($value)) {
            if(!is_numeric($key)){

                $subnode = $xml_template_info->addChild("$key");

                if(count($value) >1 && is_array($value)){
                    $jump = false;
                    $count = 1;
                    foreach($value as $k => $v) {
                        if(is_array($v)){
                            if($count++ > 1)
                                $subnode = $xml_template_info->addChild("$key");

                            array_to_xml($v, $subnode);
                            $jump = true;
                        }
                    }
                    if($jump) {
                        goto LE;
                    }
                    array_to_xml($value, $subnode);
                }
                else
                    array_to_xml($value, $subnode);
            }
            else{
                $employee = $xml_template_info->addChild('employee');
                array_to_xml($value, $employee);
            }
        }
        else {

            $xml_template_info->addChild("$key","$value");
        }

        LE: ;
    }
}
function clearmoney($monto)
{
    $monto = str_replace(array("$",","),"",$monto);
    return (float)$monto;

}

$app->run();