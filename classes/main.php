<?php
    class Main 
    {
        public $prizeName;
        public $prizeRange;
    
        function __constructor()
        {

        }

        function random()
        {
            return rand($this->prizeName[0], $this->prizeName[1]);            
        }
    }

    class Money extends Main
    {
        
    }

    class Bonus extends Main
    {
        
    }

    class Item extends Main
    {
        
    }