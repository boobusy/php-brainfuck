<?php

/**
 *	 php-brainfuck parser
 *   <战线> booobusy@gmail.com
 */
class bfvm {

	private $mem = array();
	private $code = "";
	private $whilemap = array();
	private $pos  = 0;
	private $keys = "<>+-.,[]";


	public function parse($code=null){
	
		$whilemap = array();
		$pos = 0;

		while ($code{$pos}) {
			if(strstr($this->keys,$code{$pos})){		

					$this->code .= $code{$pos};

					if($code{$pos} == '['){
						$whilemap["$pos"] = "null"; 
					}
					if($code{$pos} == ']'){
						end($whilemap);
						$key =  key($whilemap);						
						$this->whilemap["$key"] = $pos; //8=>11;
						$this->whilemap["$pos"] = $key;
						array_pop($whilemap);

					}
			}
			$pos++;
		}

		return $this;
	}

	public function run(){
		$pc = 0;
		while ($this->code[$pc]) {
			
			switch ($this->code[$pc]) {
				case '>':
					$this->pos++;
					if (count($this->mem) <= $this->pos) {
						array_push($this->mem, 0);
					}					
				break;
				case '<':
					$this->pos--;
				break;
				case '+':
					$this->mem[$this->pos]++;
				break;
				case '-':
					$this->mem[$this->pos]--;
				break;
				case '.':
					echo chr($this->mem[$this->pos]);
				break;
				case ',':
				# code...
				break;
				case '[':
					if ($this->mem[$this->pos] == 0){
						$pc = $this->whilemap[$pc];
					}
				break;
				case ']':
					if ($this->mem[$this->pos] != 0){
						$pc = $this->whilemap[$pc];
					}
				break;
			}
			$pc++;

		}


		return $this;	
	}

}


if(isset($_POST['code'])){
	$bfvm = new bfvm;
	$bfvm ->parse($_POST['code']) -> run();
	return;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BF 解释器 </title>
</head>
<body>

	<form action="#" method="post">
		<textarea style="width:500px; height:350px" name="code"></textarea>
		<br/>
		<input type="submit" name="submit" value="submit"/>	
	</form>

</body>
</html>
