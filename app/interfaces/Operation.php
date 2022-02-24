<?php
namespace app\interfaces;

class Operation {
    public $op1;
    public $op2;
    public $operator;
    public $result;
    public function __construct($a, $b, $c, $d){
        $this->op1 = $a;
        $this->op2 = $b;
        $this->operator = $c;
        $this->result   = $d;
    }
    public function getOp1(){    return $this->op1;}
    public function getOp2(){    return $this->op2;}
    public function getOperator(){    return $this->operator;}
    public function getResult(){      return $this->result;}
}