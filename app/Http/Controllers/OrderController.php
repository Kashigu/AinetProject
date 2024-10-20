<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use DateTime;
use Illuminate\Support\Facades\Auth;

use App\Utils\PdfGenerator;

class OrderController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->authorizeResource(Order::class, 'order');
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tablesize = 40;
        $userType = auth()->user()?->user_type;
        $orderQuery = Order::query();

        $filterByStatus = $request->estado ?? '';
        $filterByID = $request->numero ?? '';
        $filterByClientID = $request->numeroCliente ?? '';
        $sortBy = $request->sort ?? '';

        if ($filterByID === '') {
            $filterByID = null;
        } else {
            $orderQuery->where('id', $filterByID);
        }

        if ($userType == 'C') {
            $customerId = auth()->user()->id;
            $orderQuery->where('customer_id', $customerId);
        } elseif ($filterByClientID === '') {
            $filterByClientID = null;
        } else {
            $orderQuery->where('customer_id', $filterByClientID);
        }

        if ($filterByStatus === '') {
            $filterByStatus = null;
        } else {
            $orderQuery->where('status', $filterByStatus);
        }

        switch ($sortBy) {
            case 'dateOldest':
                $orderQuery->orderBy('created_at', 'asc');
                break;
            case 'dateNewest':
                $orderQuery->orderBy('created_at', 'desc');
                break;
            default:
                $sortBy = null;
        }

        switch ($userType) {
            case 'A':
                break;
            case 'E':
                $orderQuery->where(function ($query) {
                    $query->where('status', 'pending')
                        ->orWhere('status', 'paid');
                });
                break;
            case 'C':
                $customerId = auth()->user()->id;
                $orderQuery->where('customer_id', $customerId);
                break;
            default:
                return view('auth/login');
        }

        $orders = $orderQuery->paginate($tablesize);

        return view('order/index', compact('orders', 'filterByStatus', 'filterByID', 'filterByClientID', 'sortBy'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userID = Auth::user();
        $user = Customer::find($userID->id);

        $userNIF = $user->nif;
        $userAddress = $user->address;
        $userDefaultPT = $user->default_payment_type;
        $userDefaultPR = $user->default_payment_ref;

        return view('order.create', compact('userNIF', 'userAddress', 'userDefaultPT', 'userDefaultPR'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cartData = session('cart');

        $newOrder = new Order;
        $currentDate = (new DateTime())->format('Y-m-d');

        $newOrder->status = 'pending';
        $newOrder->customer_id = auth()->user()->id;
        $newOrder->date = $currentDate;

        $totalPrice = 0;
        foreach ($cartData as $cartDataItem) {
            $totalPrice += $cartDataItem['precoComDesconto'] * $cartDataItem['quantidade'];
        }
        $newOrder->total_price = $totalPrice;


        $validateRequest = $request->validate([
            'nif' => 'required|numeric|digits:9',
            'address' => 'required',
            'payment_type' => 'required|in:VISA,MC,PAYPAL',
        ], [
            'nif.required' => 'NIF is Mandatory.',
            'nif.numeric' => 'Must Only Contain Numbers.',
            'nif.digits' => 'Must have Exactly 9 Digits.',
            'address.required' => 'Address is Mandatory.',
            'payment_type.required' => 'Payment Type Required.',
            'payment_type.in' => 'Select Valid Payment Type.',
        ]);

        $newOrder->nif = $validateRequest['nif'];
        $newOrder->address = $validateRequest['address'];
        $newOrder->payment_type = $validateRequest['payment_type'];

        if ($validateRequest['payment_type'] === 'PAYPAL') 
        {
            $validatePaymentRef =  $request->validate([
                'payment_ref' => 'required|email',
            ], [
                'payment_ref.required' => 'For PAYPAL an Email is Required',
                'payment_ref.email' => 'For PAYPAL Must be a Valid Email Address',
            ]);
        }
        else 
        {
            $validatePaymentRef =  $request->validate([
                'payment_ref' => 'required|numeric|digits:16',
            ], [
                'payment_ref.required' => 'A Payment Reference is Required.',
                'payment_ref.numeric' => 'Must Only Contain Numbers.',
                'payment_ref.digits' => 'Must have Exactly 16 Digits.',
            ]);
        }

        $newOrder->payment_ref = $validatePaymentRef['payment_ref'];
        $newOrder->notes = $request->notes;

        try {
            $newOrder->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        
        // Create OrderItems
        $newOrderID = $newOrder->id;
        $newOrderItem = app(OrderItemController::class);
        $newOrderItem->store($newOrderID, $cartData);

        session()->forget('cart');

        return redirect()->route('root');
    }


    public function showReceipt(Order $order)
    {
        $this->authorize('showReceipt', $order);


        $pdfPath = $order->receipt_url;

        if ($pdfPath == NULL || $pdfPath == '') 
        {
            abort(404); 
        }

        if (Storage::exists($pdfPath)) 
        {
            $pdfContents = Storage::get($pdfPath);
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response($pdfContents, 200, $headers);
        } 
        else 
        {
            abort(404); 
        }
    }

    ###################################################

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orderItemsQuery = app(OrderItemController::class);
        $orderItems = $orderItemsQuery->show($order->id);

        return view('order.show',  compact('order', 'orderItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if ($request->input('action') !== '' && $request->input('action') !== null) {
            
            if ($order->status == 'pending' && $request->input('action') !== 'canceled') 
            {
                // Create PDF Receipt
                $pdfData = $this->pdfGenerator->generateReceipt($order);
                $pdfPath = 'receipts\\' . $order->id . '.pdf';
                Storage::put($pdfPath, $pdfData);

                $order->receipt_url = $pdfPath;
            }
            $order->status = $request->input('action');
            $order->save();
        }

        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
