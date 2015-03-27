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
        return $app['twig']->render('index.html.twig', array('stores'=>Store::getAll(),'brands'=>Brand::getAll()));
    });

    $app->get("/stores", function() use ($app){
        return $app['twig']->render('stores.html.twig');
    });


    $app->post("/stores", function() use ($app) {
        $store_name = $_POST['store_name'];
        $store = new Store($store_name);
        $store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands'=>Brand::getAll()));
    });

    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands'=>$store->getBrands(), 'all_brands'=>Brand::getAll()));
    });

    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    $app->patch("/stores/{id}", function($id) use ($app) {
        $store_name = $_POST['store_name'];
        $store = Store::find($id);
        $store->update($store_name);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands'=>$store->getBrands()));
    });

    $app->delete("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    $app->get("/brands", function() use ($app){
        return $app['twig']->render('brands.html.twig');
    });

    $app->post("/brands", function() use ($app) {
        $brand_name = $_POST['brand_name'];
        $brand = new Brand($brand_name);
        $brand->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands'=>Brand::getAll()));
    });

    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores'=>$store->getStores(), 'all_stores'=>store::getAll()));
    });







































    return $app;

?>
