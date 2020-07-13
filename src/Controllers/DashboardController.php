<?php


namespace App\Controllers;


use App\System\Database\Model;
use App\System\Request;

class DashboardController {
    public function index(Request $request) {
        $args = $request->get();
        // TODO: add these kind of functions to the templates (make new layer)
        // TODO: or make middlewares which will do it
        $authenticated = $args['authenticated'] = is_authenticated();
        if($authenticated) {
            $args['user'] = user();
        }

        foreach(config('models.models') as $model) {
            $m_name = $model::$model_name;
            $out['models'][$m_name] = str_replace(' ', '', ucwords(str_replace('_', ' ', $m_name)));
        }

        return response()->render('admin/index', $out);
    }
}