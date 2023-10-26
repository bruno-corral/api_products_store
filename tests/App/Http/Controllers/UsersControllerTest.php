<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\UsersController;
use App\Models\User;
use Tests\TestCase;

# php artisan test --filter=UsersControllerTest
class UsersControllerTest extends TestCase
{
    # php artisan test --filter=UsersControllerTest::testIndex
    public function testIndex(): void
    {
        $user = new User;
        $controller = new UsersController($user);
        $user = $controller->index();
        $this->assertObjectHasProperty('data', $user, "Não existe a posição Data neste objeto.");
    }
}
