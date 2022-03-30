<?php

namespace App\Http\Controllers\employeesControllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Models\Org_resto;
use App\Models\Restaurant;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee.account');
    }


    public function wallet_index()
    {

        return view('employee.wallet');
    }

    public function deposit_index()
    {

        return view('employee.deposit');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'amount' => 'required',
            'otp_code' => 'required',
        ]);

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . env('SMTPAY_API_KEY')
        ])->post("http://smtpay.net/api/payment/v1/pay", [
            'id' => 'OM',
            'customer_msisdn' => $request->phone,
            'amount' => $request->amount,
            'otp' => $request->otp_code
        ]);

        $result = json_decode((string) $response->getBody(), true);
        if (((int) $result['status']) === 200) {
            $clientAccountAmount = auth()->user()->custom->account->amount;
            Account::find(Auth::user()->custom->account->id)->update(['amount' => (int) $clientAccountAmount + (int) $request->amount]);
            return redirect()->back()->with("success", "Votre dépôt a été un succès!");
        } else {
            return redirect()->back()->with('error', "Il y'a eu une erreur!Veuillez réessayer!");
        }
    }

    public function tickets_index()
    {
        $numberTickets = Ticket::where('employeeId', auth()->user()->custom->id)->orderby('created_at', 'DESC')->get();
        $count = Ticket::where('employeeId', auth()->user()->custom->id)->pluck('ticketNumber')->toArray();
        //the using of toArray convert the eloquent collection to a simple PHP array
        $getNumberTickets = array_sum($count);

        return view('employee.tickets', compact('numberTickets', 'getNumberTickets', 'count'));
    }

    public function buy_ticket(Request $request)
    {
        $request->validate([
            'employeeId' => 'required',
            'ticketNumber' => 'required'
        ]);
        $input = $request->all();
        $count = Ticket::where('employeeId', auth()->user()->custom->id)->pluck('ticketNumber')->toArray();
        $getNumberTickets = array_sum($count);
        $numberTicketsAuthorized = Auth::user()->custom->organization->ticketNumber;
        $ticketPrice = Auth::user()->custom->organization->ticketPrice;
        $getUserAmount = Auth::user()->custom->account->amount;

        $ticketValue = ($request->ticketNumber * $ticketPrice) / $numberTicketsAuthorized;


        if ($ticketValue > $getUserAmount) {
            return back()->with('warning', 'Attention votre compte est insuffisant,veuillez recharger avant d \'effectuer un achat');
        }
        if ($numberTicketsAuthorized  >= $request->ticketNumber && $getNumberTickets < ($numberTicketsAuthorized)) {
            Ticket::create($input);
            $updateAccount = Account::where('employeeId',Auth::user()->custom->id)->first();
            $updateAccount->update([
                'amount'=> $getUserAmount -  $ticketValue
            ]);
            return back()->with('success', 'Achat effectué avec succès');
        } else {
            return back()->with('error', 'Vous avez atteint la limite de Ticket Octroyé');
        }
    }

    public function restaurants()
    {
        $restaurants = Restaurant::paginate(4)->fragment('restaurants');
        return view('employee.restaurants', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        $recupMenu = $restaurant->schedules;
        $obj = collect(json_decode($recupMenu, true));
        return view('employee.show', compact('restaurant', 'obj'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
