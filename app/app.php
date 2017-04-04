<?php
  date_default_timezone_set('America/Los_Angeles');
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Stylist.php";
  require_once __DIR__."/../src/Client.php";

  use Symfony\Component\HttpFoundation\Request;
  Request::enableHttpMethodParameterOverride();

  use Symfony\Component\Debug\Debug;
  Debug::enable();
  $app = new Silex\Application();
  $app['debug'] = true;

  $server = 'mysql:host=localhost:8889;dbname=hair_salon';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
    ));

  $app -> get("/", function() use($app) {
    $stylists = Stylist::getAll();
    return $app['twig']->render('index.html.twig', array ('stylists'=>$stylists));
  });

  $app -> post("/addstylist", function () use($app) {
    $new_stylist = new Stylist($_POST['stylistname']);
    $new_stylist->save();
    $stylists = Stylist::getAll();
    return $app['twig']->render('index.html.twig', array ('stylists'=>$stylists));
  });

  $app -> get("/stylist/{id}/edit", function($id) use($app) {
      $stylist = Stylist::find($id);
      return $app['twig']->render('stylist_edit.html.twig', array('stylist'=>$stylist));
  });

  $app->patch("/stylist/{id}", function($id) use($app) {
      $name = $_POST['name'];
      $stylist = Stylist::find($id);
      $stylist->update($name);
      return $app['twig']->render('stylist.html.twig', array('stylist'=>$stylist));
  });

  $app->delete("/stylist/{id}", function($id) use($app) {
      $stylist = Stylist::find($id);
      $stylist->delete();
      $stylists = Stylist::getAll();
      return $app['twig']->render('index.html.twig', array('stylists'=>$stylists));
  });

  $app -> get("/stylists/{id}", function($id) use($app) {
      $stylist = Stylist::find($id);
      $clients = Client::findAllClients($id);
      return $app['twig']->render('stylist.html.twig', array ('stylist'=>$stylist, 'clients'=>$clients));
  });

  $app -> get("/addclient", function() use($app) {
    $new_client = new Client($_GET['clientname'], $_GET['stylist_id']);
    $new_client->save();
    $new_stylist = Stylist::find($_GET['stylist_id']);
    $clients = Client::findAllClients($_GET['stylist_id']);
    return $app['twig']->render('clients.html.twig', array ('clients'=>$clients, 'stylist'=>$new_stylist));
  });

  $app -> get("/client/{id}", function($id) use($app) {
      $client = Client::find($id);
      return $app['twig']->render('client.html.twig', array ('client'=>$client, 'id'=>$id));
  });

  $app->patch("/client/{id}", function($id) use($app) {
      $name = $_POST['name'];
      $client = Client::find($id);
      $client->update($name);
      return $app['twig']->render('client.html.twig', array('client'=>$client));
  });

  $app->delete("/client/{id}", function($id) use($app) {
      $client = Client::find($id);
      $client->delete();
      $stylists = Stylist::getAll();
      return $app['twig']->render('index.html.twig', array('stylists'=>$stylists));
  });

  return $app;
?>
