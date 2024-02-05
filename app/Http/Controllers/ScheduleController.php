<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleToDoBridge;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!UserSession::check_session(Auth::user()->id)) {
            Auth::logout();
            return response()->json(['status' => 'error', 'message' => "The user session is expired"]);
        }


        $schedule = new Schedule();

        try {
            $schedule->user_id = Auth::user()->id;
            $schedule->notes = $request->notes;
            $schedule->date = $request->date;
            $schedule->save();

            foreach ($request->array_to_do as $value) {
                $scheduleToDo = new ScheduleToDoBridge();
                $scheduleToDo->schedule_id = $schedule->id;
                $scheduleToDo->to_do_id = $value;
                $scheduleToDo->save();
            }

            DB::commit();

            return response()->json(['status' => 'ok', 'message' => 'Success in recording']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Error in recording']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
