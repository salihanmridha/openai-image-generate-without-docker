<?php

namespace App\Factories\Contracts;

interface StorageFactoryInterface
{
    /**
     * @return StorageInterface
     */
    public function create(): StorageInterface;
}
