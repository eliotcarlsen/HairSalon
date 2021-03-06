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

      function test_find()
      {
        $test_stylist = new Stylist("Sally");
        $test_stylist->save();
        $test_stylist2 = new Stylist("June");
        $test_stylist2->save();
        $result = Stylist::find($test_stylist->getId());
        $this->assertEquals($test_stylist, $result);
      }

      function test_update()
      {
          $new_stylist = new Stylist("Eliot");
          $new_stylist->save();
          $new_name = "Julie";
          $new_stylist->update($new_name);
          $this->assertEquals("Julie", $new_stylist->getName());
      }

      function test_delete()
      {
          $new_stylist = new Stylist("Holly");
          $new_stylist->save();
          $stylist2 = new Stylist("Ben");
          $stylist2->save();
          $new_stylist->delete();
          $this->assertEquals([$stylist2], Stylist::getAll());
      }

      function test_delete_stylistclients_too()
      {
        $test_stylist = new Stylist("Sally");
        $test_stylist->save();
        $stylist_id = $test_stylist->getId();
        $test_stylist2 = new Stylist("June");
        $test_stylist2->save();
        $stylist_id2 = $test_stylist2->getId();

        $test_client = new Client("Sam", $stylist_id);
        $test_client->save();
        $test_client2 = new Client("Bobby", $stylist_id);
        $test_client2->save();
        $test_client3 = new Client("Laurie", $stylist_id);
        $test_client3->save();
        $test_stylist->delete();
        $this->assertEquals([], Client::getAll());
      }



    }
?>
