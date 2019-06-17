<?php
class Response{
    public $status = '';
    public $mesage;
    public $content;

    public function setMesage($str){
        $this->mesage = $str."\n";
        $this->status = false;
    }
    public function setContent($obj){
        $this->content = $obj;
        $this->status = true;
    }

    public function getResponse(){
        return json_encode($this);
    }
}


?>
