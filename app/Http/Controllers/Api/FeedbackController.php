<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'contact' => 'required',
            'content' => 'required',
        ]);

        $attributes = $request->all();
        $attributes['user_id'] = Auth::user()->id;

        Feedback::create($attributes);

        return $this->response->created();
    }
}
