<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Session;

class AppointmentController extends Controller
{

    public function create(Service $service)
    
    {
        $customer = Auth::guard('customers')->user();
        $user = $service->user;
        $userID = $user->id;
        

        return view('customer.appointments.create', compact('user','customer','service', 'userID'));
    }

    public function store(Request $request, Service $service)
    {
        
        $request->validate([
            'date' => 'required|string',
            'time' => 'required|string', 
            'service'=>'required'
            
        ]);
        

        $formattedTime = Carbon::createFromFormat('H:i', $request->time)->format('H:i:s');

        $date = preg_replace('/\sGMT[^\)]+\)/', '', $request->date);
        $formattedDate = Carbon::parse($date)->format('Y-m-d');
        // return $request;
        
        return redirect()->route('customer.confirm.appointment', [
            'date' => $formattedDate,
            'time' => $formattedTime,
            'service'=>$service
        ]); 
    }


    public function confirmAppointment(Request $request)
    {
        $date = $request->query('date'); 
        $time = $request->query('time');
        $serviceId = $request->query('service');
        $service = Service::with('user')->find($serviceId);
        $user=$service->user;
        // return $date;
        

        return view("customer.appointments.confirmation", compact('date', 'time','serviceId', 'service', 'user'));
    }

    public function check_userEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $exists = Customer::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }

    
    public function login_ValidateUser(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            Auth::guard('customers')->login($customer);
            return response()->json(['success' => true, 
            'name' => $customer->name,
            'email' => $customer->email]);
        }
        return response()->json(['success' => false]);
    }

    public function register_ValidateUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:8', 
            'confirm_password' => 'required|same:password', 
        ]);

        try {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->password = Hash::make($request->password);
            $customer->save();
    
            Auth::guard('customers')->login($customer);
            return response()->json(['success' => true,
            'name' => $customer->name,
            'email' => $customer->email]);
    
        } catch (\Exception $e) {
           
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function store_appointment(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'service' => 'required|exists:services,id',
            'phone' => 'required|string|min:10|max:15|regex:/^[0-9]+$/',
        ]);

       
        $cloverApiToken = env('CLOVER_API_TOKEN');
        $baseUrl = env('CLOVER_BASE_URL');
        $merchantId = env('MERCHANT_ID');


        try {
            
            $customer = Auth::guard('customers')->user();
            $service = Service::findOrFail($validated['service']);
            $payload = [
                "customer" => [
                    "firstName" => $customer->name ?? 'Unknown', 
                    "lastName" => $customer->name ?? 'Unknown',   
                    "email" => $customer->email ?? 'no-email@example.com', 
                ],
                "shoppingCart" => [
                    "lineItems" => [
                        [
                            "name" => $service->title,
                            "price" => $service->price*100,
                            "unitQty" => 1
                        ]
                    ],
                    "total" => $service->price*100 
                ],
                "redirectUrls" => [
                    "success" => "https://1c3c-154-192-136-25.ngrok-free.app/payment/success",
                    "failure" => "https://google.com",
                    "cancel" => "https://google.com"
                ]
            ];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sandbox.dev.clover.com/invoicingcheckoutservice/v1/checkouts',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS=> json_encode($payload),
                
                CURLOPT_HTTPHEADER => array(
                    'X-Clover-Merchant-Id: WHG4S2ZSG9DX1',
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env('CLOVER_API_TOKEN')
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);
            $session_id = $response->checkoutSessionId;
            // return $session_id;
            // if (!isset($response->checkoutSessionId)) {
            //     throw new \Exception('Failed to create checkout session.');
            // }
            Session::put('session_id', $response->checkoutSessionId);
            Session::put('appointment_data', $validated);
    
            return redirect($response->href);
    

        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }

    }
    public function confirm_payment(Request $request)
    {
    try {
        $checkout_id = Session::get('session_id');

        // if (!$checkout_id) {
        //     throw new \Exception('Checkout ID not found.');
        // }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => env('CLOVER_BASE_URL') . "/invoicingcheckoutservice/v1/checkouts/{$checkout_id}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-Clover-Merchant-Id: ' . env('MERCHANT_ID'),
                'Content-Type: application/json',
                'Authorization: Bearer ' . env('CLOVER_API_TOKEN')
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $paymentDetails = json_decode($response, true);

        if (!isset($paymentDetails['status']) || $paymentDetails['status'] !== 'PAID') {
            throw new \Exception('Payment not successful.');
        }

        $validated = Session::get('appointment_data');

        if (!$validated) {
            throw new \Exception('Appointment data not found.');
        }

        $customer = Auth::guard('customers')->user();

        Appointment::create([
            'service_id' => $validated['service'],
            'customer_id' => $customer->id,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'phone' => $validated['phone'],
            'payment_status' => 1
        ]);

        // Clear session data
        Session::forget(['session_id', 'appointment_data']);

        return redirect()->route('customer.appointments.index')->with('success', 'Appointment successfully created!');
    } catch (\Throwable $th) {
        return redirect()->route('customer.services')->with('error', $th->getMessage());
    }
    }   


}

