<?php

namespace App\Repositories;

use App\Models\TestModel;

class TestRepository implements TestRepositoryInterface
{
    public function __construct(
       private TestModel  $TestModel
    ){}
}