<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * get all owners.
     */
    public function getOwners()
    {
        $owners = Owner::all();

        return response()->json(['owners' => $owners, 200]);
    }

    /**
     * get one owner.
     */
    public function getOwner($id)
    {
        $owner = Owner::find($id);
        if (is_null($owner)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }
        return response()->json([
            'owner' => $owner::find($id),
            'vehicles' => $owner->vehicles()->get()
        ], 200);
    }

    /**
     * add one owner.
     */
    public function addOwner(Request $request)
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

        $owner = Owner::create([
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
            'owner' => $owner,
            'message' => 'Agregado Correctamente'
        ], 200);
    }

    /**
     * update one owner.
     */
    public function updateOwner(Request $request)
    {
        $owner = Owner::find($request->id);
        if (is_null($owner)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        $owner->fill([
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

        $owner->save();

        return response()->json([
            'owner' => $owner,
            'message' => 'Actualizado Correctamente'
        ], 200);
    }

    /**
     * delete one owner.
     */
    public function deleteOwner(Request $request)
    {
        $owner = Owner::find($request->id);
        if (is_null($owner)) {
            return response()->json(['message' => 'No se encontro ninguna coincidencia', 404]);
        }

        if ($owner->vehicles->count() > 0) {
            return response()->json(['message' => 'Por favor Elimina los Vehiculos ascociados a ' . $owner->name, 400]);
        }

        $owner->delete();



        return response()->json([
            'owner' => $owner,
            'message' => 'Eliminado Correctamente'
        ], 200);
    }
}
