<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserByType(Request $request){
        $users=User::where('type',$request->type)->get();
        return Api::setResponse('users',$users);
    }

    public function editUser(Request $request){
        $user=User::find($request->user_id);
        return Api::setResponse('user',$user->withToken());
    }
    public function updateUser(Request $request){
        $user=User::find($request->user_id);
        $request->request->remove('api_token');
        $user->update($request->all());
        return Api::setResponse('user',$user->withToken());
    }

    public function deleteUser(Request $request){
        $user=User::find($request->user_id);
        $user->delete();
        return Api::setMessage('User Deleted');
    }

    public function getDataForDashbard(Request $request){
        $saleManagers=User::where('type','Sales Manager')->get()->count();
        $storeManagers=User::where('type','Store Manager')->get()->count();
        $saleOrders=Sale::all()->count();
        $salerReturns=SaleReturn::all()->count();
        $obj= new Api();
        $obj->saleManagers=$saleManagers;
        $obj->storeManagers=$storeManagers;
        $obj->saleOrders=$saleOrders;
        $obj->salerReturns=$salerReturns;
        return Api::setResponse('data',$obj);
    }
}
