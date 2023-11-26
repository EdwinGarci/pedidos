<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\MenuSubMenu;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response);
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'code' => $code
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response);
    }

    public function getMenuKeys($submenuID)
    {
        // $menu = MenuSubMenu::select(
        //     'menus.MnuKey as KeyMenu',
        //     'sub_menus.SumKey as KeySubmenu'
        // )   ->join('menus', 'menus.id', '=', 'menu_sub_menus.MnuID')
        //     ->join('sub_menus', 'sub_menus.id', '=', 'menu_sub_menus.SumID')
        //     ->where('menu_sub_menus.SumID', $submenuID)
        //     ->get();

        // return $menu;
    }
}
