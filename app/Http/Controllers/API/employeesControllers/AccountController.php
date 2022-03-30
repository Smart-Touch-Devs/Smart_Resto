<?php

namespace App\Http\Controllers\API\employeesControllers;


use App\Http\Controllers\Controller;
use App\Models\Restaurant;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function restaurants()
    {
        $restaurants = Restaurant::all();
        return $restaurants;
    }
  
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        return $restaurant;
    }

}
