<?php
require 'main.php';
    class money extends main
    {
        function random()
        {
            return rand($this->prizeName[0], $this->prizeName[1]);            
        }
    }