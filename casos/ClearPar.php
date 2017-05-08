<?php 

class ClearPar{

	private $start;
	private $end;

	function __construct()
	{
		$this->start = "(";
		$this->end = ")";		
	}

	public function build($string){
								
		$cadena = str_split($string);
		$resultado = "";
		for($i = 0 ; $i < count($cadena); $i++){			
			
			if ( array_key_exists($i + 1, $cadena ) )
			{
				if( $cadena[$i] == $this->start && $cadena[$i+1] == $this->end)
				{
					$resultado .= $cadena[$i];
				}
			}			
			if ( array_key_exists($i - 1, $cadena ) ){
				if( $cadena[$i] == $this->end && $cadena[$i-1] == $this->start)
				{
					$resultado .= $cadena[$i];
				}
			}
			
		}
		return $resultado.'<br>';				
	}

}

$object = new ClearPar();

echo "Input: ()())()". " => Output: ".$object->build("()())()");
echo "Input: ()(()". " => Output: ".$object->build("()(()");
echo "Input: )(". " => Output: ".$object->build(")(");
echo "Input: ((()". " => Output: ".$object->build("((()");


?>