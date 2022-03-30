<?php

namespace App\Http\Controllers\API\employeesControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Dish;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dishes = Dish::all();

        return $dishes->toJson(JSON_PRETTY_PRINT);
    }
    public function home() {
        $restaurants = auth()->user()->custom->organization->restaurants;
        return $restaurants;
    }
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search'=>'required|min:2'
        ]);
        if($validator->failed()) {
            return response()->json(['error' => "Vous devez fournir toutes les champs!"], 401);
        }
        if(strlen($request->search) < 2)
        {
            return response()->json(['error' => "Le nombre de caractère doit être de 3 minimun"], 401);
        }else{
            $q = $request->search;
            $dishes = Dish::where('name', 'LIKE', "%$q%")->orWhere('description','LIKE', "%$q%")->paginate(12);
            return response()->json($dishes);
        }

    }

}
