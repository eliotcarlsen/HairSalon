<?php
    class Client
    {
        private $name;
        private $stylist_id;
        private $id;

        function __construct($name,$stylist_id,$id=null)
        {
            $this->name = $name;
            $this->stylist_id = $stylist_id;
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
        function getStylistId()
        {
            return $this->stylist_id;
        }
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO clients (name, stylist_id) VALUES ('{$this->getName()}', {$this->getStylistId()})");
            if ($executed){
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }
    }


?>
