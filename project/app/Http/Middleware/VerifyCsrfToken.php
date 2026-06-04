<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/checkout/payment/paytm-notify',
        '/checkout/payment/razorpay-notify',
        '/cflutter/notify',
        '/checkout/payment/ssl-notify',
        '/user/paytm-notify',
        '/user/razorpay-notify',
        '/uflutter/notify',
        '/user/ssl-notify',
        '/user/deposit/paytm-notify',
        '/user/deposit/razorpay-notify',
        '/dflutter/notify',
        '/user/deposit/ssl-notify'
    ];
}
