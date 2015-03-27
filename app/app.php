<?php
    /**
    * @backupGlobals disabled
    *@backupStaticAttribute disabled
    */
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();
    $app['debug'] = TRUE;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app){
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    $app->post("/stores", function() use ($app) {
        $store_name = $_POST['store_name'];
        $store = new Store($store_name);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands'=>$store->getBrands(), 'all_brands'=>Brand::getAll()));
    });

    return $app;

?>
