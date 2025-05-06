<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;



use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('register', [AuthController::class, 'register'])
//     ->name('register');

// Route::post('login', [AuthController::class, 'login'])
//     ->name('login');





Route::group(['middleware' => 'api'], function ($router) {
    // Auth protected routes
    // Auth
    require __DIR__ . '/api_routes/auth.php';

    // users
    require __DIR__ . '/api_routes/users.php';
    
    // roles
    require __DIR__ . '/api_routes/roles.php';
    
    // specialities
    require __DIR__ . '/api_routes/specialities.php';

    // tipos de pago
    require __DIR__ . '/api_routes/paymentMethod.php';
    
    // pub
    require __DIR__ . '/api_routes/pub.php';

    // profile
    require __DIR__ . '/api_routes/profile.php';

    
    // pais
    require __DIR__ . '/api_routes/pais.php';
    
    
    // whatsapp
    // require __DIR__ . '/api_routes/whatsapp.php';
    
    
    // documents
    require __DIR__ . '/api_routes/documents.php';

    // solicitudes
    require __DIR__.'/api_routes/solicitudes.php';
    
    // favorite
    require __DIR__.'/api_routes/favorite.php';
    // clients
    require __DIR__.'/api_routes/clients.php';
    // message
    require __DIR__.'/api_routes/message.php';
    // comments
    require __DIR__.'/api_routes/comments.php';


    

    //comandos desde la url del backend

    Route::get('/cache', function () {
        Artisan::call('cache:clear');
        return "Cache";
    });

    Route::get('/optimize', function () {
        Artisan::call('optimize:clear');
        return "Optimización de Laravel";
    });

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return "Storage Link";
    });


    Route::get('/migrate-fresh', function () {
        Artisan::call('migrate:refresh');
        return "Migrate: Actualizando sin borrar";
    });


    Route::get('/migrate-seed', function () {
        Artisan::call('migrate:refresh --seed');
        return "Migrate: creacion con datos, para uso";
    });
    
    Route::get('/migrate-make', function () {
        Artisan::call('make:migration agregar_campo_x');
        return "Migrate:agregar campos a tablas";
    });

    
    Route::get('/send-notification', function () {
        Artisan::call('command:notification-appointments');
        return "Send All notifications";
    });
    
    Route::get('/send-whatsapp', function () {
        Artisan::call('command:notification-appointment-whatsapp');
        return "Send All whatsapp";
    });




    //rutas libres


    // Route::get('/categories', [CategoryController::class, 'index'])
    //     ->name('category.index');


});


