<?php

namespace App\Http\Controllers;


use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MiscController extends Controller
{
    /**
     * Display a listing of the resource with view.
     */
    public function updateServer($migrate, $seed)
    {

        //go to project folder
        $cmd  =  '/var/www/html/efs-web/prod_systems/learning_cms_dev/';

        $cmd  .= ' && git pull origin master';

        if (isset($migrate) && !empty($migrate) && $migrate == 1)
            $cmd .= ' && php artisan migrate:fresh';

        if (isset($seed) && !empty($seed) && $seed == 1)
            $cmd .= ' && php artisan db:seed';

        $cmd .= ' && php artisan optimize';
        echo shell_exec($cmd);
    }
    /**
     * Display a listing of the resource as json .
     */
}
