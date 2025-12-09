<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

class RouteNameToPermission extends Command
{
    protected $signature = 'routes:send-api';
    protected $description = 'Send all route names with web middleware to the main website';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            if ($route->getName() != '' && $route->getAction()['middleware']['0'] == 'web') {
                $response = Http::post(env('API_BASE_URL') . '/api/store-route', [
                    'name' => $route->getName(),
                ]);

                if ($response->successful()) {
                    $this->info("Route {$route->getName()} sent successfully to main website.");
                } else {
                    $this->error("Failed to send route {$route->getName()} to main website.");
                }
            }
        }

        $this->info('All routes have been processed.');
    }
}