<?php

class AES {
    
    public $Nb;
    public $Nk;
    public $Nr;
    
    public $Rcon;
    public $Sbox;
    public $InvSbox;
    
    public function __construct($nb, $nk, $nr) {
        $this->Nb = $nb;
        $this->Nk = $nk;
        $this->Nr = $nr;
        
        $this->Rcon = array(0x00000000,                     
            0x01000000, 0x02000000, 0x04000000, 0x08000000, 
            0x10000000, 0x20000000, 0x40000000, 0x80000000, 
            0x1B000000, 0x36000000, 0x6C000000, 0xD8000000, 
            0xAB000000, 0x4D000000, 0x9A000000, 0x2F000000, 
            0x5E000000, 0xBC000000, 0x63000000, 0xC6000000, 
            0x97000000, 0x35000000, 0x6A000000, 0xD4000000, 
            0xB3000000, 0x7D000000, 0xFA000000, 0xEF000000, 
            0xC5000000, 0x91000000, 0x39000000, 0x72000000, 
            0xE4000000, 0xD3000000, 0xBD000000, 0x61000000, 
            0xC2000000, 0x9F000000, 0x25000000, 0x4A000000, 
            0x94000000, 0x33000000, 0x66000000, 0xCC000000, 
            0x83000000, 0x1D000000, 0x3A000000, 0x74000000, 
            0xE8000000, 0xCB000000, 0x8D000000
        );
        
        $this->Sbox = array(
            array( 0x63, 0x7c, 0x77, 0x7b, 0xf2, 0x6b, 0x6f, 0xc5, 0x30, 0x01, 0x67, 0x2b, 0xfe, 0xd7, 0xab, 0x76 ) ,
            array( 0xca, 0x82, 0xc9, 0x7d, 0xfa, 0x59, 0x47, 0xf0, 0xad, 0xd4, 0xa2, 0xaf, 0x9c, 0xa4, 0x72, 0xc0 ) ,
            array( 0xb7, 0xfd, 0x93, 0x26, 0x36, 0x3f, 0xf7, 0xcc, 0x34, 0xa5, 0xe5, 0xf1, 0x71, 0xd8, 0x31, 0x15 ) ,
            array( 0x04, 0xc7, 0x23, 0xc3, 0x18, 0x96, 0x05, 0x9a, 0x07, 0x12, 0x80, 0xe2, 0xeb, 0x27, 0xb2, 0x75 ) ,
            array( 0x09, 0x83, 0x2c, 0x1a, 0x1b, 0x6e, 0x5a, 0xa0, 0x52, 0x3b, 0xd6, 0xb3, 0x29, 0xe3, 0x2f, 0x84 ) ,
            array( 0x53, 0xd1, 0x00, 0xed, 0x20, 0xfc, 0xb1, 0x5b, 0x6a, 0xcb, 0xbe, 0x39, 0x4a, 0x4c, 0x58, 0xcf ) ,
            array( 0xd0, 0xef, 0xaa, 0xfb, 0x43, 0x4d, 0x33, 0x85, 0x45, 0xf9, 0x02, 0x7f, 0x50, 0x3c, 0x9f, 0xa8 ) ,
            array( 0x51, 0xa3, 0x40, 0x8f, 0x92, 0x9d, 0x38, 0xf5, 0xbc, 0xb6, 0xda, 0x21, 0x10, 0xff, 0xf3, 0xd2 ) ,
            array( 0xcd, 0x0c, 0x13, 0xec, 0x5f, 0x97, 0x44, 0x17, 0xc4, 0xa7, 0x7e, 0x3d, 0x64, 0x5d, 0x19, 0x73 ) ,
            array( 0x60, 0x81, 0x4f, 0xdc, 0x22, 0x2a, 0x90, 0x88, 0x46, 0xee, 0xb8, 0x14, 0xde, 0x5e, 0x0b, 0xdb ) ,
            array( 0xe0, 0x32, 0x3a, 0x0a, 0x49, 0x06, 0x24, 0x5c, 0xc2, 0xd3, 0xac, 0x62, 0x91, 0x95, 0xe4, 0x79 ) ,
            array( 0xe7, 0xc8, 0x37, 0x6d, 0x8d, 0xd5, 0x4e, 0xa9, 0x6c, 0x56, 0xf4, 0xea, 0x65, 0x7a, 0xae, 0x08 ) ,
            array( 0xba, 0x78, 0x25, 0x2e, 0x1c, 0xa6, 0xb4, 0xc6, 0xe8, 0xdd, 0x74, 0x1f, 0x4b, 0xbd, 0x8b, 0x8a ) ,
            array( 0x70, 0x3e, 0xb5, 0x66, 0x48, 0x03, 0xf6, 0x0e, 0x61, 0x35, 0x57, 0xb9, 0x86, 0xc1, 0x1d, 0x9e ) ,
            array( 0xe1, 0xf8, 0x98, 0x11, 0x69, 0xd9, 0x8e, 0x94, 0x9b, 0x1e, 0x87, 0xe9, 0xce, 0x55, 0x28, 0xdf ) ,
            array( 0x8c, 0xa1, 0x89, 0x0d, 0xbf, 0xe6, 0x42, 0x68, 0x41, 0x99, 0x2d, 0x0f, 0xb0, 0x54, 0xbb, 0x16 )       
        );
        
        $this->InvSbox = array(
            array( 0x52, 0x09, 0x6a, 0xd5, 0x30, 0x36, 0xa5, 0x38, 0xbf, 0x40, 0xa3, 0x9e, 0x81, 0xf3, 0xd7, 0xfb ) ,
            array( 0x7c, 0xe3, 0x39, 0x82, 0x9b, 0x2f, 0xff, 0x87, 0x34, 0x8e, 0x43, 0x44, 0xc4, 0xde, 0xe9, 0xcb ) ,
            array( 0x54, 0x7b, 0x94, 0x32, 0xa6, 0xc2, 0x23, 0x3d, 0xee, 0x4c, 0x95, 0x0b, 0x42, 0xfa, 0xc3, 0x4e ) ,
            array( 0x08, 0x2e, 0xa1, 0x66, 0x28, 0xd9, 0x24, 0xb2, 0x76, 0x5b, 0xa2, 0x49, 0x6d, 0x8b, 0xd1, 0x25 ) ,
            array( 0x72, 0xf8, 0xf6, 0x64, 0x86, 0x68, 0x98, 0x16, 0xd4, 0xa4, 0x5c, 0xcc, 0x5d, 0x65, 0xb6, 0x92 ) ,
            array( 0x6c, 0x70, 0x48, 0x50, 0xfd, 0xed, 0xb9, 0xda, 0x5e, 0x15, 0x46, 0x57, 0xa7, 0x8d, 0x9d, 0x84 ) ,
            array( 0x90, 0xd8, 0xab, 0x00, 0x8c, 0xbc, 0xd3, 0x0a, 0xf7, 0xe4, 0x58, 0x05, 0xb8, 0xb3, 0x45, 0x06 ) ,
            array( 0xd0, 0x2c, 0x1e, 0x8f, 0xca, 0x3f, 0x0f, 0x02, 0xc1, 0xaf, 0xbd, 0x03, 0x01, 0x13, 0x8a, 0x6b ) ,
            array( 0x3a, 0x91, 0x11, 0x41, 0x4f, 0x67, 0xdc, 0xea, 0x97, 0xf2, 0xcf, 0xce, 0xf0, 0xb4, 0xe6, 0x73 ) ,
            array( 0x96, 0xac, 0x74, 0x22, 0xe7, 0xad, 0x35, 0x85, 0xe2, 0xf9, 0x37, 0xe8, 0x1c, 0x75, 0xdf, 0x6e ) ,
            array( 0x47, 0xf1, 0x1a, 0x71, 0x1d, 0x29, 0xc5, 0x89, 0x6f, 0xb7, 0x62, 0x0e, 0xaa, 0x18, 0xbe, 0x1b ) ,
            array( 0xfc, 0x56, 0x3e, 0x4b, 0xc6, 0xd2, 0x79, 0x20, 0x9a, 0xdb, 0xc0, 0xfe, 0x78, 0xcd, 0x5a, 0xf4 ) ,
            array( 0x1f, 0xdd, 0xa8, 0x33, 0x88, 0x07, 0xc7, 0x31, 0xb1, 0x12, 0x10, 0x59, 0x27, 0x80, 0xec, 0x5f ) ,
            array( 0x60, 0x51, 0x7f, 0xa9, 0x19, 0xb5, 0x4a, 0x0d, 0x2d, 0xe5, 0x7a, 0x9f, 0x93, 0xc9, 0x9c, 0xef ) ,
            array( 0xa0, 0xe0, 0x3b, 0x4d, 0xae, 0x2a, 0xf5, 0xb0, 0xc8, 0xeb, 0xbb, 0x3c, 0x83, 0x53, 0x99, 0x61 ) ,
            array( 0x17, 0x2b, 0x04, 0x7e, 0xba, 0x77, 0xd6, 0x26, 0xe1, 0x69, 0x14, 0x63, 0x55, 0x21, 0x0c, 0x7d )
        );
    }
    
    public function ffAdd($x, $y) {
        return $x ^ $y;
    }
    
    public function xtime($x) {
        $result = $this->makeHex((($x << 1) ^ (($x & 0x80) ? 0x1b : 0x00))); //($x & 0x80) //((1 << 7) & $x)
        
        if (strlen($result) > 2) {
            $result = substr($result, 1);
        }
        
        return hexdec(bin2hex(pack('H*',$result)));
    }
    
    public function ffMultiply($x, $y) {
        return ((($y & 1) * $x) ^
                (($y>>1 & 1) * $this->xtime($x)) ^
                (($y>>2 & 1) * $this->xtime($this->xtime($x))) ^
                (($y>>3 & 1) * $this->xtime($this->xtime($this->xtime($x)))) ^
                (($y>>4 & 1) * $this->xtime($this->xtime($this->xtime($this->xtime($x))))));
    }
    
    public function makeHex($bin) {
        if (strlen(dechex($bin)) < 2 || strlen(dechex($bin)) == 7) {
            return 0 . dechex($bin);
        } else if (strlen(dechex($bin)) == 6) {
            return '00' . dechex($bin);
        } else {
            return dechex($bin);
        }
    }
    
    public function KeyExpansion($key) {
        $i = 0;
        
        $word = array();
        
        while ($i < $this->Nk) {
            $word[$i] = $this->makeHex($key[4*$i]).$this->makeHex($key[4*$i+1]).$this->makeHex($key[4*$i+2]).$this->makeHex($key[4*$i+3]);
            $i++;
        }

        $i = $this->Nk;
        
        while ($i < $this->Nb * ($this->Nr + 1)) {
            $temp = $word[$i-1];
            if ($i % $this->Nk == 0) {
                $temp = $this->makeHex(hexdec(bin2hex(pack('H*',$this->SubWord($this->RotWord($temp))))) ^ $this->Rcon[$i/$this->Nk]);
            } else if ($this->Nk > 6 && $i % $this->Nk == 4) {
                $temp = $this->SubWord($temp);
            }
            $word[$i] = bin2hex(pack('H*',$word[$i-$this->Nk]) ^ pack('H*',$temp));
            $i++;
        }
        
        return $word;
    }
    
    public function getBin($hex) {
        if (is_numeric($hex))
            return $hex;
        switch ($hex) {
            case 'a':
                return 10;
            break;
            case 'b':
                return 11;
            break;
            case 'c':
                return 12;
            break;
            case 'd':
                return 13;
            break;
            case 'e':
                return 14;
            break;
            case 'f':
                return 15;
            break;
        }
    }
    
    public function SubWord($temp) {
        
        $values = array();
        
        $values[] = substr($temp, 0, 2);
        $values[] = substr($temp, 2, 2);
        $values[] = substr($temp, 4, 2);
        $values[] = substr($temp, 6, 2);
        
        foreach ($values as $key => $value) {
            $values[$key] = $this->makeHex($this->Sbox[$this->getBin($value[0])][$this->getBin($value[1])]);
        }
        
        return $values[0].$values[1].$values[2].$values[3];
    }
    
    public function RotWord($temp) {
      
        $v1 = substr($temp, 0, 2);
        $v2 = substr($temp, 2, 2);
        $v3 = substr($temp, 4, 2);
        $v4 = substr($temp, 6, 2);
        
        return $v2.$v3.$v4.$v1;

    }
    
    public function toString($state) {
        $str = '';
        foreach ($state as $key => $value) {
            $str .= $value;
        }
        
        return $str;
    }
    
    public function cipher($in, $word) {
        
        $state = array();
        
        foreach ($in as $key => $value) {
            $state[$key] = $this->makeHex($value);
        }
        
        echo "<br> ROUND[0] input: ".$this->toString($state);
        
        $this->AddRoundKey($state, $word, 0);   
        
        for ($i=1; $i<$this->Nr; $i++) {
            echo "<br> ROUND[".$i."] start: ".$this->toString($state);
            $this->SubBytes($state);
            echo "<br> ROUND[".$i."] s_box: ".$this->toString($state);
            $this->ShiftRows($state);
            echo "<br> ROUND[".$i."] s_row: ".$this->toString($state);
            $this->MixColumns($state);
            echo "<br> ROUND[".$i."] m_col: ".$this->toString($state);
            $this->AddRoundKey($state, $word, $i*$this->Nb);
        }
        
        echo "<br> ROUND[".$this->Nr."] start: ".$this->toString($state);
        $this->SubBytes($state);
        echo "<br> ROUND[".$this->Nr."] s_box: ".$this->toString($state);
        $this->ShiftRows($state);
        echo "<br> ROUND[".$this->Nr."] s_row: ".$this->toString($state);
        $this->AddRoundKey($state, $word, $this->Nr*$this->Nb);
        echo "<br><b> ROUND[".$this->Nr."] final: ".$this->toString($state)."</b>";
        
        return $state;
    }
    
    public function SubBytes(&$state) {
        foreach ($state as $key => $value) {
            $state[$key] = $this->makeHex($this->Sbox[$this->getBin($value[0])][$this->getBin($value[1])]);
        }
    }
    
    public function ShiftRows(&$state) {
        $row = 1;
        for ($i=1; $i<4; $i++) {
            for ($j=0; $j<$row; $j++) {
                $temp = $state[$i];
                $state[$i] = $state[$i+4];
                $state[$i+4] = $state[$i+8];
                $state[$i+8] = $state[$i+12];
                $state[$i+12] = $temp;
            }
            $row++;
        }
    }
    
    public function MixColumns(&$state) {
        
        $matrix = array(0x02, 0x01, 0x01, 0x03, 0x03, 0x02, 0x01, 0x01, 0x01, 0x03, 0x02, 0x01, 0x01, 0x01, 0x03, 0x02);

        for ($i=0; $i<4; $i++) {
            $temp1 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[0]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[4]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[8]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[12]))));
            $temp2 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[1]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[5]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[9]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[13]))));
            $temp3 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[2]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[6]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[10]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[14]))));
            $temp4 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[3]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[7]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[11]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[15]))));
                                     
            $state[4*$i] = $temp1;
            $state[4*$i+1] = $temp2;
            $state[4*$i+2] = $temp3;
            $state[4*$i+3] = $temp4;
        }  
    }
    
    public function AddRoundKey(&$state, $word, $index) {
        for ($i=0; $i<4; $i++) {
            $column = $state[4*$i].$state[4*$i+1].$state[4*$i+2].$state[4*$i+3];
            $column = bin2hex(pack('H*', $column) ^ pack('H*', $word[$index+$i]));
            
            $state[4*$i] = substr($column, 0, 2);
            $state[4*$i+1] = substr($column, 2, 2);
            $state[4*$i+2] = substr($column, 4, 2);
            $state[4*$i+3] = substr($column, 6, 2);
        }
    }
    
    public function InvCipher($in, $word) {
         
        $state = $in;
        
        echo "<br> ROUND[0] input: ".$this->toString($state);
        
        $this->AddRoundKey($state, $word, $this->Nr*$this->Nb);
        
        for ($i=$this->Nr-1; $i>0; $i--) {
            $round_num = $this->Nr - $i;
            echo "<br> ROUND[".$round_num."] istart: ".$this->toString($state);
            $this->InvShiftRows($state);
            echo "<br> ROUND[".$round_num."] is_row: ".$this->toString($state);
            $this->InvSubBytes($state);
            echo "<br> ROUND[".$round_num."] is_box: ".$this->toString($state);
            $this->AddRoundKey($state, $word, $i*$this->Nb);
            echo "<br> ROUND[".$round_num."] ik_add: ".$this->toString($state);
            $this->InvMixColumns($state);
        }
        
        $this->InvShiftRows($state);
        echo "<br> ROUND[".$this->Nr."] is_row: ".$this->toString($state);
        $this->InvSubBytes($state);
        echo "<br> ROUND[".$this->Nr."] is_box: ".$this->toString($state);
        $this->AddRoundKey($state, $word, 0);
        echo "<br><b> ROUND[".$this->Nr."] final: ".$this->toString($state)."</b>";
        
        return $state;
    }
    
    public function InvShiftRows(&$state) {
        $row = 1;
        for ($i=1; $i<4; $i++) {
            for ($j=0; $j<$row; $j++) {
                $temp = $state[$i+12];
                $state[$i+12] = $state[$i+8];
                $state[$i+8] = $state[$i+4];
                $state[$i+4] = $state[$i];
                $state[$i] = $temp;
            }
            $row++;
        }
    }
    
    public function InvSubBytes(&$state) {
        foreach ($state as $key => $value) {
            $state[$key] = $this->makeHex($this->InvSbox[$this->getBin($value[0])][$this->getBin($value[1])]);
        }
    }
    
    public function InvMixColumns(&$state) {
        
        $matrix = array(0x0e, 0x09, 0x0d, 0x0b, 0x0b, 0x0e, 0x09, 0x0d, 0x0d, 0x0b, 0x0e, 0x09, 0x09, 0x0d, 0x0b, 0x0e);
        
        for ($i=0; $i<4; $i++) {
            $temp1 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[0]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[4]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[8]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[12]))));
            $temp2 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[1]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[5]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[9]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[13]))));
            $temp3 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[2]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[6]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[10]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[14]))));
            $temp4 = bin2hex(pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i]))), $matrix[3]))) ^ 
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+1]))), $matrix[7]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+2]))), $matrix[11]))) ^
                             pack('H*', $this->makeHex($this->ffMultiply(hexdec(bin2hex(pack('H*', $state[4*$i+3]))), $matrix[15]))));
                                     
            $state[4*$i] = $temp1;
            $state[4*$i+1] = $temp2;
            $state[4*$i+2] = $temp3;
            $state[4*$i+3] = $temp4;
        }
    }
    
}

?>