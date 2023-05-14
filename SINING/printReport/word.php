<?php 
//Convert Number to Philippine Currency Format

class PhilippineCurrency{

    public function __construct($amount){
    $this->amount=$amount;
    $this->hasSentimo=false;
    $arr=explode(".",$this->amount);
    $this->peso=$arr[0];
    if(isset($arr[1])&&((int)$arr[1])>0){
    if(strlen($arr[1])>2){
    $arr[1]=substr($arr[1],0,2);
    }
    $this->hasSentimo=true;
    $this->sentimo=$arr[1];
    }
}
    
public function get_words(){
    $w="";
    $million=(int)($this->peso/1000000);
    $this->peso=$this->peso%1000000;
    $w.=$this->single_word($million,"Million ");
    $thousand=(int)($this->peso/1000);
    $this->peso=$this->peso%1000;
    $w.=$this->single_word($thousand,"Thousand ");
    $hundred=(int)($this->peso/100);
    $w.=$this->single_word($hundred,"Hundred ");
    $ten=$this->peso%100;
    $w.=$this->single_word($ten,"");
    $w.="Pesos ";
    if($this->hasSentimo){
    if($this->sentimo[0]=="0"){
    $this->sentimo=(int)$this->sentimo;
    }
    else if(strlen($this->sentimo)==1){
    $this->sentimo=$this->sentimo*10;
    }
    $w.=" and ".$this->single_word($this->sentimo," Centavos");
    }
    return $w." Only";
}
    
private function single_word($num,$unit){
    $one = array("", "One ", "Two ", "Three ", "Four ", "Five ", "Six ", "Seven ", "Eight ", "Nine ", "Ten ",
    "Eleven ", "Twelve ", "Thirteen ", "Fourteen ", "Fifteen ", "Sixteen ", "Seventeen ", "Eighteen ", "Nineteen ");
    $ten = array("", "", "Twenty ", "Thirty ", "Forty ", "Fifty ", "Sixty ", "Seventy ", "Eighty ", "Ninety ");
    $word="";
    if($num>19){
    $word.=$ten[(int)($num/10)].$one[$num%10];
    }
    else{
    $word.=$one[$num];
    }
    if($num){
    $word.=$unit;
    }
    return $word;
}
}
?>