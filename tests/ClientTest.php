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

        protected function tearDown()
        {
        Stylist::deleteAll();
        Client::deleteAll();
        }

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
        function test_getAll()
        {
            $test_stylist = new Stylist("Sally");
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $test_stylist2 = new Stylist("June");
            $test_stylist2->save();
            $stylist_id2 = $test_stylist2->getId();

            $test_client = new Client("Sam", $stylist_id);
            $test_client->save();
            $test_client2 = new Client("Bobby", $stylist_id2);
            $test_client2->save();
            $result = Client::getAll();
            $this->assertEquals([$test_client, $test_client2], $result);
        }
        function test_deleteAll()
        {
          $test_stylist = new Stylist("Sally");
          $test_stylist->save();
          $stylist_id = $test_stylist->getId();
          $test_stylist2 = new Stylist("June");
          $test_stylist2->save();
          $stylist_id2 = $test_stylist2->getId();

          $test_client = new Client("Sam", $stylist_id);
          $test_client->save();
          $test_client2 = new Client("Bobby", $stylist_id2);
          $test_client2->save();
          Client::deleteAll();
          $result = Client::getAll();
          $this->assertEquals([], $result);
        }

        function test_find()
        {
          $test_stylist = new Stylist("Sally");
          $test_stylist->save();
          $stylist_id = $test_stylist->getId();
          $test_stylist2 = new Stylist("June");
          $test_stylist2->save();
          $stylist_id2 = $test_stylist2->getId();

          $test_client = new Client("Sam", $stylist_id);
          $test_client->save();
          $test_client2 = new Client("Bobby", $stylist_id2);
          $test_client2->save();
          $result = Client::find($test_client2->getId());
          $this->assertEquals($test_client2, $result);
        }

    }


?>
