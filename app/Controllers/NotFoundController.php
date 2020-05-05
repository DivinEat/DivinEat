<?php

namespace App\Controllers;

use App\Core\Controller\Controller;

class NotFoundController extends Controller
{
    public function show()
    {
        echo '404 : J\'ai po trouvé grand chose';
    }
}