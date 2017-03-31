<?php
    class Stylist
    {
        private $name;
        private $id;

        function __construct($name,$id=null)
        {
            $this->name = $name;
            $this->id = $id;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getName()
        {
            return $this->name;
        }
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
            if ($executed){
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }
    }


?>
