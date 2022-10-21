<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Index page for Admin Task view
    public function tasks_for_admin_index()
    {
        return view('Admin.Tasks');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    public function fetch_tasks_for_admin(Request $request)
    {
        $tasks = Task::select('*');
        if ($request->has('status') && !is_null($request->status))
        {
            $tasks->where('status', $request->status);
        }

        // foreach ($tasks as $key => $task) {
        //     $dueAt = Carbon::parse($task->due_date);
        //     $task->date_due = $dueAt->format('M d, Y');
        // }
        
        return $tasks->orderBy('created_at', 'DESC')->get();
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
            'title' => 'required',
            'description' => 'required',
            'dueDate' => 'required',
            'priority' => 'required'
        ]);

        $random = Str::random(11);

        $task = Task::create([
            'task_id' => $random,
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->dueDate,
            'priority' => $request->priority
        ]);

        return response()->json(['status' => true, 'message' => 'create successful']);
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
        $task = Task::where('id', $id)->first();

        return $task;
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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'dueDate' => 'required',
            'priority' => 'required',
            'status' => 'required'
        ]);

        $task = Task::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->dueDate,
            'priority' => $request->priority,
            'status' => $request->status
        ]);

        return response()->json(['status' => true, 'message' => 'update successful']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->delete();

        return response()->json(['status' => true, 'message' => 'delete successful']);
    }
}
