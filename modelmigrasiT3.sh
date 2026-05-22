php artisan make:model Device -m
php artisan make:model SoilReading -m
php artisan make:model WaterReading -m
php artisan make:middleware DeviceApiKeyMiddleware
php artisan make:controller Api/IoT/SoilReadingApiController
php artisan make:controller Api/IoT/WaterReadingApiController
php artisan make:controller Monitoring/MonitoringDashboardController
php artisan make:request Monitoring/StoreSoilReadingRequest
php artisan make:request Monitoring/StoreWaterReadingRequest
php artisan make:seeder DeviceSeeder
