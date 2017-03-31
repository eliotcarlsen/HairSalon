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

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach ($returned_clients as $client) {
                $name = $client['name'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                $new_client = new Client($name, $stylist_id, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM clients;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($client_id)
        {
            $found_client = null;
            $returned_client = $GLOBALS['DB']->prepare("SELECT * FROM clients WHERE id = :id");
            $returned_client->bindParam(':id', $client_id, PDO::PARAM_STR);
            $returned_client->execute();
            foreach($returned_client as $client) {
                $name = $client['name'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                if ($id == $client_id) {
                    $found_client = new Client($name, $stylist_id, $id);
                }
            }
            return $found_client;
        }

        static function findAllClients($stylist_id)
        {
            $clients = array();
            $returned_clients = $GLOBALS['DB']->prepare("SELECT * FROM clients WHERE stylist_id = :id");
            $returned_clients->bindParam(':id', $stylist_id, PDO::PARAM_STR);
            $returned_clients->execute();
            foreach ($returned_clients as $client) {
                $name = $client['name'];
                $stylistId = $client['stylist_id'];
                $id = $client['id'];
                if ($stylistId == $stylist_id) {
                    $found_client = new Client($name, $stylistId, $id);
                    array_push($clients, $found_client);
                }
            }
            return $clients;
        }
    }


?>
