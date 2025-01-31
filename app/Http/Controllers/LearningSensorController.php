<?php

namespace App\Http\Controllers;

use App\Models\LearningSensor;
use App\Models\StatisticalSensor;
use Illuminate\Http\Request;

class LearningSensorController extends Controller
{
    /**
     * Create a new controller instance.
     * Part Name : CNT
     * * Part Size : 15.1
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $learningsensors = LearningSensor::all();
        return view('modules.learningsensor.index',compact('learningsensors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('modules.learningsensor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 'statistical_sensor_id', 'elements', 'start_time', 'pass_time', 'finish_time', 'aver_temper_glob', 'difer_const', 'sample',
        $request->validate([
            'statistical_sensor_id'=>'required|string|max:100',
            'elements'=>'required|string|max:100',
            'start_time'=>'required|string|max:100',
            'pass_time'=>'required|string|max:100',
            'finish_time'=>'required|string|max:100',
            'aver_temper_glob'=>'required|string|max:100',
            'difer_const'=>'required|string|max:100',
            'sample'=>'required|string',
            
        ]);
        $learningsensor = new LearningSensor([
            'statistical_sensor_id' => $request->get('statistical_sensor_id'),
            'elements' => $request->get('elements'),
            'start_time' => $request->get('start_time'),
            'pass_time' => $request->get('start_time'),
            'finish_time' => $request->get('finish_time'),
            'aver_temper_glob' => $request->get('aver_temper_glob'),
            'difer_const' => $request->get('difer_const'),
            'sample' => $request->get('sample')
            ]);
        $learningsensor->save();
        //return redirect(/learningsensor)->with('success','Muestra prediccion creada');
        toastr()->success('Muestra prediccion creada');
        return redirect()->route('learningsensor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Learning  $learningsensor
     * @return \Illuminate\Http\Response
     */
    public function show(LearningSensor $learningsensor)
    {
        //
        return view('modules.learningsensor.show', compact('learningsensor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Learning  $learningsensor
     * @return \Illuminate\Http\Response
     */
    public function edit(LearningSensor $learningsensor)
    {
        //
        return view('modules.learningsensor.edit',compact('learningsensor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Learning  $learningsensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LearningSensor $learningsensor)
    {
        //
        $request->validate([
            'statistical_sensor_id'=>'required|string|max:100',
            'elements'=>'required|string|max:100',
            'start_time'=>'required|string|max:100',
            'pass_time'=>'required|string|max:100',
            'finish_time'=>'required|string|max:100',
            'aver_temper_glob'=>'required|string|max:100',
            'difer_const'=>'required|string|max:100',
            'sample'=>'required|string',
        ]);
        $learningsensor_request = $request->all();
        $learningsensor->update($learningsensor_request);
        toastr()->warning('Muestra actualizada');
        return redirect()->route('learningsensor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LearningSensor  $learningsensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(LearningSensor $learningsensor)
    {
        //
        $learningsensor->delete();
        //return reditec('/learningsensor'->with('success','Muestra eliminada'));
        toastr()->error('Muestra eliminada');
        return redirect()->route('learningsensor.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chart($id)
    {
        //
        $learningsensor = LearningSensor::find($id);
        $statisticalsensor = StatisticalSensor::find($learningsensor->statistical_sensor_id);
        $sample_1 = \Chart::title(['text' => 'Muestra '.$learningsensor->id,])
                          ->credits(['enabled' => false])
                          ->yaxis(['min' => 0])
                          ->xaxis(['min' => -0.5,'max' => 5.5])
                          ->series([['type'  => 'line',
                                     'name'  => 'Regression Line',
                                     'data'  => [[0, 1.11],[5, 4.51]],
                                     'marker' => ['enabled' => 'false'],
                                     'states' => ['hover' => ['lineWith' => 0]],
                                     'enableMouseTracking' => 'false'],
                                     ['type' => 'scatter',
                                      'name' => 'Observations',
                                      'data' => [1, 1.5, 2.8, 3.5, 3.9, 4.2],
                                      'marker' => ['radius' => 4]
                                     ]])->display();
        //dd($sample1);
        $sample_2 = \Chart::title(['text' => 'Muestra '.$statisticalsensor->id,])
                          ->credits(['enabled' => false])
                          ->yaxis(['min' => 0])
                          ->xaxis(['min' => -0.5,'max' => 5.5])
                          ->series([['type'  => 'line',
                                     'name'  => 'Regression Line',
                                     'data'  => [[0, 1.11],[1, 4.51]],
                                     'marker' => ['enabled' => 'false'],
                                     'states' => ['hover' => ['lineWith' => 0]],
                                     'enableMouseTracking' => 'false'],
                                     ['type' => 'scatter',
                                      'name' => 'Observations',
                                      'data' => [1, 1.5, 2.8, 3.5, 3.9, 4.2],
                                      'marker' => ['radius' => 4]
                                     ]])->display();
    //return view('modules.learningsensor.chart', ['vol1' => $vol1,]);
    return view('modules.learningsensor.chart')->with('sample_1',$sample_1)
                                        ->with('sample_2',$sample_2)
                                        ->with('learning',$learningsensor);
    }
}
