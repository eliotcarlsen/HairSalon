<?php
/**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */
    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    require_once "src/Stylist.php";
    require_once "src/Client.php";

    class ClientTest extends PHPUnit_Framework_TestCase {
        function test_save()
        {
            $test_stylist = new Stylist("Sam");
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $test_client = new Client("Eliot", $stylist_id);
            $result = $test_client->save();
            $this->assertTrue($result, "Client not successfully saved to database");
        }
        function test_getId()
        {
            $test_stylist = new Stylist("Sam");
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $test_client = new Client("Eliot", $stylist_id);
            $test_client->save();
            $result = $test_client->getId();
            $this->assertTrue(is_numeric($result));
        }
        function test_setName()
        {
            $name = "Henry";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $name2 = "Orwell";
            $test_client = new Client($name2, $stylist_id);
            $new_name = "George";
            $test_client->setName($new_name);
            $result = $test_client->getName();
            $this->assertEquals($new_name, $result);
        }
        function test_getStylistId()
        {
            $test_stylist = new Stylist ("Sally");
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();

            $test_client = new Client("Steve", $stylist_id);
            $test_client->save();
            $result = $test_client->getStylistId();
            $this->assertEquals($stylist_id, $result);
        }

    }


?>
