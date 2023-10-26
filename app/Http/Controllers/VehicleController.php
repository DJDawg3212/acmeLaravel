<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Owner;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function getVehicles()
    {
        $vehicles = Vehicle::all();
        $owners = Owner::all();

        foreach ($vehicles as $vehicle) {
            $vehicle->nameOwner = $vehicle->owner->name;
            $vehicle->lastNameOwner = $vehicle->owner->last_name;
        }

        return response()->json([
            'vehicles' => $vehicles,
            'owners' => $owners,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function getVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        $owners = Owner::all();

        if (is_null($vehicle)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $conductors = $vehicle->conductors;
        $owner = $vehicle->owner;

        return response()->json([
            'vehicle' => $vehicle,
            'conductors' => $conductors,
            'owner' => $owner,
            'owners' => $owners,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addVehicle(Request $request)
    {
        $vehicle = Vehicle::create([
            'owner_id' => $request->owner_id,
            'num_serie' => $request->num_serie,
            'color' => $request->color,
            'brand' => $request->brand,
            'type' => $request->type,
        ]);

        $vehicle->save();

        return response()->json([
            'vehicle' => $vehicle,
            'message' => 'Usuario Agregado Correctamente'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateVehicle(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        if (is_null($vehicle)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $vehicle->fill([
            'owner_id' => $request->owner_id,
            'num_serie' => $request->num_serie,
            'color' => $request->color,
            'brand' => $request->brand,
            'type' => $request->type,
        ]);

        $vehicle->save();

        return response()->json([
            'vehicle' => $vehicle,
            'message' => 'Actualizado Correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteVehicle(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
        if (is_null($vehicle)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        if ($vehicle->conductors->count() > 0) {
            foreach ($vehicle->conductors as $conductor) {
                $vehicle->conductors()->detach($conductor->id);
            }
        }

        $vehicle->delete();

        return response()->json(['message' => "Eliminados Correctamente"], 200);
    }

    /**
     * Remove relation.
     */
    public function detachConductor(Request $request)
    {
        $vehicle = Vehicle::find($request->vehicle_id);
        $conductor = Conductor::find($request->conductor_id);
        if (is_null($vehicle) || is_null($conductor)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $vehicle->conductors()->detach($conductor->id);

        return response()->json(['message' => "Eliminados Correctamente"], 200);
    }
}
