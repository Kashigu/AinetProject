<?php

namespace App\Utils;

use Dompdf\Dompdf;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Color;
use App\Models\User;

class PdfGenerator
{
    public function generateReceipt(Order $order)
    {

        $pdf = new Dompdf();

        $orderItems = OrderItem::where('order_id', $order->id)->get();
        foreach ($orderItems as $orderItem) 
        {
            $colorID = Color::query()->where('code', $orderItem->color_code)
                                     ->value('name');
            $orderItem->color_code = $colorID;
        }

        $customer = User::find($order->customer_id);

        $image = public_path('img/plain_white.png');
        $imageData = base64_encode(file_get_contents($image));
        $srcimg = 'data:'.mime_content_type($image).';base64,'.$imageData;

        $htmlView = view('pdf.template', compact('order' , 'orderItems', 'customer', 'srcimg'));
        $pdf->loadHtml($htmlView);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $pdf->output();
    }
}