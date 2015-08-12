<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/RPS.php";
    require_once __DIR__."/../src/Player.php";

    session_start();

    if (empty($_SESSION['list_of_players'])) {
    $_SESSION['list_of_players'] = array();
    }
    if (empty($_SESSION['list_of_current_players'])) {
    $_SESSION['list_of_current_players'] = array();
    }

    $app = new Silex\Application();
    $app['debug']  = true;
    $app->register(new Silex\Provider\TwigServiceProvider(),array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app){
            return $app['twig']->render('form.html.twig', array('players' => Player::getAll()));

    });


    $app->get("/delete_all_players", function() use ($app) {
     Player::deleteAll();
     return $app['twig']->render('form.html.twig', array('players' => Player::getAll()));
 });


    $app->post("/create_player", function() use ($app) {
        $player = new Player($_POST['name'], $_POST['age'], $_POST['image'], $_POST['email']);
        $player->save();
//var_dump(Player::getAll()[0]);
        return $app['twig']->render('form.html.twig', array('players' => Player::getAll()));
    });

    return $app;





?>
