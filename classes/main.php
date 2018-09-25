<?php
    class Main 
    {
        public $prizeName;
        public $minRange;
        public $maxRange;
    
        function __construct($row)
        {
            $this->prizeName = $row['name'];
            $this->minRange = $row['min_range'];
            $this->maxRange = $row['max_range'];
        }

        function random()
        {
            return rand($this->minRange, $this->maxRange);            
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