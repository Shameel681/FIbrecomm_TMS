<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Trainee; // Make sure this is imported

class ProfileController extends Controller
{
    public function index()
    {
        /** @var Trainee $trainee */
        $trainee = Auth::guard('trainee')->user();

        // Check if trainee exists to avoid errors, then load relationship
        if ($trainee) {
            $trainee->load('applicationDetails');
        }

        return view('trainee.profile', compact('trainee'));
    }
}