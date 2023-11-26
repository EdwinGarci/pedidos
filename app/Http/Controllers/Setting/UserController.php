<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\v1\BaseController;
use App\Models\Person;
use App\Models\UserRol;
use Exception;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    //
    public function user()
    {
        $menu = $this->getMenuKeys(1);

        return view('setting.user')->with('menu', $menu);
    }

    public function rol()
    {
        return view('setting.rol');
    }

    public function get_rols_api()
    {
        $rols = UserRol::all();

        $response = array(
            'rows' => $rols,
            'total' => count($rols)
        );

        return response()->json($response);
    }

    public function user_table()
    {
        return view('setting.components.UserTable');
    }

    public function get_users_api() {
        $rows = Person::select(
                'person.id', 'person.dni', 'person.name', 'person.lastname'
            )   ->join('users','users.person_id', '=', 'person.id')
                ->get();
        return response()->json($rows);
    }
}
