<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\fechas;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:calendar');

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()) {
            $data = fechas::get(['id', 'date']);
            $events = [];
            foreach($data as $datos){
                $event = [];
                $event['id'] = $datos->id;
                $event['title'] = "fecha no valida";
                $event['start'] = $datos->date;
                $event['end'] = $datos->date;
                $event['color'] = "#C81F0E";
                $events[] = $event;
            }    
 
            return response()->json($events);
       }

        return view('calendario.index');
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
        //
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

    public function ajax(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
              $event = fechas::create([
                  'date' => $request->start,
              ]);
 
              return response()->json($event);
             break;
  
           case 'update':
              $event = fechas::find($request->id)->update([
                  'date' => $request->start,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = fechas::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }
}
