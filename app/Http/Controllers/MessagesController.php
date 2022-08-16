<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::with('user')->where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'DESC')->get();
        foreach ($messages as $key => $msg) {
            $createdAt = Carbon::parse($msg->created_at);
            $msg->date_created = $createdAt->format('M d, Y, h:i a');
        }

        return $messages;
    }

    // Index page for Admin Message view
    public function messages_for_admin_index()
    {
        return view('Admin.messages');
    }

    //  fetch messages for admin
    public function fetch_messages_for_admin()
    {
        $messages = Message::with('user')->orderBy('created_at', 'DESC')->get();
        foreach ($messages as $key => $msg) {
            $createdAt = Carbon::parse($msg->created_at);
            $msg->date_created = $createdAt->format('M d, Y, h:i a');
        }

        return $messages;
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
        $request->validate([
            'message' => 'required'
        ]);

        $message = Message::create([
            'user_id' => Auth::user()->id,
            'message' => $request->message
        ]);

        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
