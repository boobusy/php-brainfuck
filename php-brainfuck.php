<?php
/**
 *   php-brainfuck parser
 *   <战线> booobusy@gmail.com
 *   2015-08-17
 */

error_reporting(E_ALL & ~E_NOTICE);

class bfvm {

	private $mem = array();
	private $code = "";
	private $whilemap = array();
	private $pos  = 0;
	private $keys = "<>+-.,[]";


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

	public function parse($code=null){
	
		$whilemap = array();
		$pos = 0;
		$pc  = 0;

		while ($char = $code{$pos++}) {
			if(strstr($this->keys,$char)){
					$this->code .= $char;

					if($char == '['){
						$whilemap[$pc] = 0; 
					}
					if($char == ']'){
						end($whilemap);
						$key =  key($whilemap);						
						$this->whilemap[$key] = $pc;
						$this->whilemap[$pc]  = $key;
						array_pop($whilemap);
					}
				$pc++;
			}
		}

		
		return $this;
	}

}

/*
$_POST['code'] = <<<BFCODE
	++++++++[>++++[>++>+++>+++>+<<<<-]>+>+>->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<.+++.------.--------.>>+.>++.
BFCODE;
*/

if(isset($_POST['code'])){
	$bfvm = new bfvm;
	$bfvm ->parse($_POST['code']) -> run();
	return;
}
