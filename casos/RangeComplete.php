<?php 

class CompleteRange{
	
	function __construct()
    {
    }
    public function build($collection)
	{
		 return range($collection[0],$collection[count($collection)-1]);	
	}
}

$object = new CompleteRange();
var_dump($object->build(array(1,2,4,5)));
var_dump($object->build(array(2,4,9)));
var_dump($object->build(array(55,58,60)));

?>