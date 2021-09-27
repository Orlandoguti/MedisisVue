<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Import SendaMail and Mail
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    public function sendEmail(Request $request){


        $contenido = $request -> validate([
            'subject'   => 'required',
            'email'     => 'required',
            'text'      => 'required',
        ]);
        
        

        Mail::to($contenido['email'])->send(new SendMail($contenido));

        return response()->json(true);
    }
}
