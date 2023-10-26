<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getConductors()
    {
        $conductors = Conductor::all();

        return response()->json(['conductors' => $conductors, 200]);
    }

    /**
     * Display the specified resource.
     */
    public function getConductor($id)
    {
        $conductor = Conductor::find($id);
        $allVehicles = Vehicle::all();

        if (is_null($conductor)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $vehicles = $conductor->vehicles;

        $notRelatedVehicles = $allVehicles->diff($vehicles);

        return response()->json([
            'conductor' => $conductor,
            'vehicles' => $vehicles,
            'notRelatedVehicles' => $notRelatedVehicles,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addConductor(Request $request)
    {
        $this->validate($request, [
            'num_doc' => ['required'],
            'type_doc' => ['required'],
            'name' => ['required'],
            'other_name' => ['nullable'],
            'last_name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'city' => ['required'],
        ]);

        $conductor = Conductor::create([
            'num_doc' => $request->num_doc,
            'type_doc' => $request->type_doc,
            'name' => $request->name,
            'other_name' => $request->other_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
        ]);
        return response()->json([
            'conductor' => $conductor,
            'message' => 'Usuario Agregado Correctamente'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateConductor(Request $request)
    {
        $conductor = Conductor::find($request->id);
        if (is_null($conductor)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $conductor->fill([
            'num_doc' => $request->num_doc,
            'type_doc' => $request->type_doc,
            'name' => $request->name,
            'other_name' => $request->other_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        $conductor->save();

        return response()->json([
            'conductor' => $conductor,
            'message' => 'Actualizado Correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteConductor(Request $request)
    {
        $conductor = Conductor::find($request->id);
        if (is_null($conductor)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        if ($conductor->vehicles->count() > 0) {
            return response()->json(['message' => 'Por favor Elimina los Vehiculos ascociados a ' . $conductor->name, 400]);
        }

        $conductor->delete();

        return response()->json(['message' => "Eliminados Correctamente"], 200);
    }

    /**
     * Add Relation Conductor-Vehicle.
     */
    public function attachVehicle(Request $request)
    {
        $vehicle = Vehicle::find($request->vehicle_id);
        $conductor = Conductor::find($request->conductor_id);

        if (is_null($vehicle) || is_null($conductor)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $conductor->vehicles()->attach($vehicle->id);

        return response()->json(['message' => "Agregado Correctamente"], 200);
    }
}
