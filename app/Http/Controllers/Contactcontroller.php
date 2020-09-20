<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Contact;

class Contactcontroller extends Controller
{
    public function contactuploaddownload($contact_id){
        return Storage::download(Contact::findOrFail($contact_id)->contact_attachment);
    }
}
