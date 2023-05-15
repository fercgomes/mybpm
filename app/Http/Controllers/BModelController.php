<?php

namespace App\Http\Controllers;

use App\Models\BModel;
use App\Http\Requests\StoreBModelRequest;
use App\Http\Requests\UpdateBModelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class BModelController extends Controller
{

    public function __construct()
    {
        // $this->authorize(BModel::class, 'bModel');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', BModel::class);
        $userId = $request->user()->id;
        $models = BModel::where('owner_id', $request->user()->id)->get();

        return view('models.index', ["models" => $models]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $user)
    {
        return view('models.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBModelRequest $request)
    {
        $validated = $request->safe();

        $emptyXml = <<<EOD
        <?xml version="1.0" encoding="UTF-8"?>
        <bpmn2:definitions xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:bpmn2="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:dc="http://www.omg.org/spec/DD/20100524/DC" xmlns:di="http://www.omg.org/spec/DD/20100524/DI" id="definitions" targetNamespace="http://bpmn.io/schema/bpmn" exporter="Camunda Modeler" exporterVersion="4.7.0">
        <bpmn2:process id="process" name="Process">
        </bpmn2:process>
        <bpmndi:BPMNDiagram id="BPMNDiagram">
            <bpmndi:BPMNPlane id="BPMNPlane" bpmnElement="process">
            </bpmndi:BPMNPlane>
        </bpmndi:BPMNDiagram>
        </bpmn2:definitions>
        EOD;

        $model = new BModel;
        $model->name = $validated->name;
        $model->owner_id = $request->user()->id;
        $model->content = $emptyXml;
        $model->save();

        return Redirect::route('models.edit', ['id' => $model->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BModel $bModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $model = BModel::find($id);
        $this->authorize('update', $model);
        return view('models.edit', ["model" => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBModelRequest $request, BModel $bModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BModel::find($id)->delete();

        return Redirect::route('models.index');
    }
}