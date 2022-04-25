<?php

namespace App\Http\Controllers\restaurantsControllers;

use App\Http\Controllers\Controller;
use App\Models\Command;
use App\Models\Ticket;

class CommandController extends Controller
{
    public function commandList()
    {

        $userConnected = Auth()->user()->id;
        $commands = Command::where('restaurantId', $userConnected)->where('done', false)->paginate(5);
        $commandsValidated = Command::where('restaurantId', $userConnected)->where('done', true)->paginate(5);
        return view('restaurants.commands.commands', compact('commands', 'commandsValidated'));
    }
    public function validateCommande($id)
    {
        $userConnected = Auth()->user()->id;
        Command::where('id', $id)->update(['done' => true]);
        $getEmployee = Command::where('restaurantId', $userConnected)->where('id', $id)->first();
        $test = $getEmployee->employeeId;
        $getTicketOfEmployee = Ticket::where('employeeId', $test)->first();
        $getNumerTicket = $getTicketOfEmployee->ticketNumber;
        $newValueTicket = $getTicketOfEmployee->update([
            'ticketNumber' => $getNumerTicket - 1
        ]);
        return back()->with('success', 'Commande validée');
    }
    public function deleteCommande($id)
    {
        $commands  = Command::find($id);
        $commands->delete();
        return redirect()->back()->with('success', 'La commande à été supprimée');
    }
}
