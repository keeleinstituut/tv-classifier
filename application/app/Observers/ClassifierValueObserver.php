<?php

namespace App\Observers;

use App\Models\ClassifierValue;
use SyncTools\AmqpPublisher;

class ClassifierValueObserver
{
    /**
     * Handle events after all transactions are committed.
     */
    public bool $afterCommit = true;

    public function __construct(private readonly AmqpPublisher $publisher)
    {
    }

    /**
     * Handle the ClassifierValue "saved" event.
     */
    public function saved(ClassifierValue $classifierValue): void
    {
        $this->publishEvent($classifierValue, 'classifier-value.saved');
    }

    public function deleted(ClassifierValue $classifierValue): void
    {
        $this->publishEvent($classifierValue, 'classifier-value.saved');
    }

    /**
     * Handle the ClassifierValue "deleted" event.
     */
    public function forceDeleted(ClassifierValue $classifierValue): void
    {
        $this->publishEvent($classifierValue, 'classifier-value.deleted');
    }

    private function publishEvent(ClassifierValue $classifierValue, string $routingKey): void
    {
        $this->publisher->publish(
            ['id' => $classifierValue->id],
            'classifier-value',
            $routingKey
        );
    }
}
