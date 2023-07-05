<?php

namespace App\Providers;

use App\Models\ClassifierValue;
use App\Observers\ClassifierValueObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
    ];

    /**
     * The model observers for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $observers = [
        ClassifierValue::class => [ClassifierValueObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
