<?php

namespace App\Http\Controllers\API\employeesControllers;

use App\Http\Controllers\Controller;
use App\Models\Command;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CommandController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employeeId' => 'required',
            'dishId' => 'required',
            'restaurantId' => 'required',
            'done' => 'required'
        ]);
        if ($validator->failed()) {
            return response()->json(['error' => "Vous devez fournir toutes les champs!"], 401);
        }

        $count = Ticket::where('employeeId', auth()->user()->custom->id)->pluck('ticketNumber')->toArray();
        $getNumberTickets = array_sum($count);
        if ($getNumberTickets === 0) {
            return response()->json([
                'warning' => 'Le nombre de ticket pour l\'acquisition d\'un plat est insuffisant.Veuillez acheter des tickets !!'
            ], 200);
        } elseif (Auth::user()->custom->account->amount === 0) {
            return response()->json([
                'warning' => 'Veuillez recharger votre compte'
            ], 200);
        } else {
            Command::create([
                'employeeId' => $request->employeeId,
                'dishId' => $request->dishId,
                'restaurantId' => $request->restaurantId,
                'done' => false
            ]);

            return response()->json([
                'success' => 'commande effectuée avec succés'
            ], 200);
        }
    }
}
