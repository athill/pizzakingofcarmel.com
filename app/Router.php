<?php
namespace App;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Services\RecipeService;
use App\Services\YoutubeService;

class Router {
    public function route() {
        
        SimpleRouter::get('/api/menu', function() {
            $contents = file_get_contents(__DIR__ . '/../data/menu.json');
            SimpleRouter::response()->header('Content-Type: text/json');
            echo $contents;
            exit(0);
        });
        SimpleRouter::get('/api/pictures', function() {
            $contents = file_get_contents(__DIR__ . '/../data/pictures.json');
            SimpleRouter::response()->header('Content-Type: text/json');
            echo $contents;
            exit(0);
        });
        // SimpleRouter::get('/export/recipes/{id}', function($id) {
        //     $recipeService = new RecipeService;
        //     $response = $recipeService->export($id);

        //     SimpleRouter::response()->header('Content-Type: text/xml');
        //     echo $response;
        //     exit(0);
        // });      
        try {
            SimpleRouter::start();
        } catch (NotFoundHttpException $e) {
            print('404');
        }
    }
}