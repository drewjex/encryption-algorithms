<?php

class Word {
    
    public $data;
    
    public function __construct($v1, $v2, $v3, $v4) {
        $this->data[] = $v1;
        $this->data[] = $v2;
        $this->data[] = $v3;
        $this->data[] = $v4;
    }
}

?>