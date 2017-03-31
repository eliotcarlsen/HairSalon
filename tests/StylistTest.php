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

    class StylistTest extends PHPUnit_Framework_TestCase {

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
          $this->assertTrue($result, "Stylist not successfully saved to database");
      }
      function test_getId()
      {
          $test_stylist = new Stylist("George");
          $test_stylist->save();
          $result = $test_stylist->getId();
          $this->assertTrue(is_numeric($result));
      }
      function test_setName()
      {
          $name = "Henry";
          $test_stylist = new Stylist($name);
          $new_name = "Orwell";
          $test_stylist->setName($new_name);
          $result = $test_stylist->getName();
          $this->assertEquals($new_name, $result);
      }

      function test_getAll()
      {
          $test_stylist = new Stylist("Sally");
          $test_stylist->save();
          $test_stylist2 = new Stylist("June");
          $test_stylist2->save();
          $result = Stylist::getAll();
          $this->assertEquals([$test_stylist, $test_stylist2], $result);
      }

      function test_deleteAll()
      {
        $test_stylist = new Stylist("Sally");
        $test_stylist->save();
        $test_stylist2 = new Stylist("June");
        $test_stylist2->save();
        Stylist::deleteAll();
        $result = Stylist::getAll();
        $this->assertEquals([], $result);
      }


    }
?>
