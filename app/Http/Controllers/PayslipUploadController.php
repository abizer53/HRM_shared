<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class PayslipUploadController extends Controller
{
    public function index()
    {

        if(\Auth::user()->can('Manage Document Type'))
        {
            $documents = Document::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('payslipupload.index', compact('documents'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
