<?php

namespace App\Listeners;

use App\Events\ProductCreated;

class SendProductCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        $product = $event->product;

        session()->flash('success', 'New product created: ' . $product->getName());
    }
}
