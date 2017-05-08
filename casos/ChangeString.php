<?php 

class ChangeString{
	
	private $abecedario;
	private $char;
	
	function __construct(){
		$this->abecedario = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );		
	}

	private function next_chart($char)
	{
		$this->char = strtolower($char);
		$key = array_search($this->char,$this->abecedario);
		if(array_key_exists($key + 1, $this->abecedario ))		
			return ctype_upper($char) ? strtoupper($this->abecedario[$key + 1]) : $this->abecedario[$key + 1] ;		
		else 
			return ctype_upper($char) ? strtoupper($this->abecedario[0]) : $this->abecedario[0];
	}
	
	
	public function build($string){
		$cadena = str_split($string);
		$resultado = "";
		foreach($cadena as $val){			
			if(ctype_alpha($val))
			{
				$val = $this->next_chart($val);
			}
			$resultado.=$val;
		}
		return $resultado;
	}


}

$object = new ChangeString();

echo "123 Abcd*3". " => ".$object->build("123 Abcd*3").'<br/>';
echo "**Casa 52". " => ".$object->build("**Casa 52").'<br/>';
echo "Casa 52Z". " => ".$object->build("Casa 52Z").'<br/>';

?>