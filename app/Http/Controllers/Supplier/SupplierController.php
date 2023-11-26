<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\v1\BaseController;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends BaseController
{
    public function index()
    {
        // $menu = $this->getMenuKeys(5);
        return view('supplier.index');
            // ->with('menuleft', $menu);
    }

    public function dataSupplier()
    {
        $suppliers = Supplier::select(
            'id', 'business_name', 'ruc', 'phone',
            'direccion', 'product_amount', 'manager', 'agreement_date'
        )->get();
        return response()->json($suppliers);
    }

    public function createSupplier()
    {
        return view('supplier.create-supplier');
    }

    public function saveSupplier(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            // 'nombreSupplier' => 'required|string|max:255',
        ]);

        // Crea un nuevo registro de área en la base de datos
        $supplier = new Supplier;
        $supplier->business_name = $request->input('businessName');
        $supplier->ruc = $request->input('ruc');
        $supplier->phone = $request->input('phone');
        $supplier->direccion = $request->input('direccion');
        $supplier->product_amount = $request->input('productAmount');
        $supplier->manager = $request->input('manager');
        $supplier->agreement_date = $request->input('agreementDate');
        $supplier->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Área creada con éxito']);
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Devuelve una vista con los detalles del área si se encuentra
        return view('supplier.edit-supplier')->with('supplier', $supplier);
    }

    public function updateSupplier(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'NombreSupplier' => 'required|string|max:255',
        ]);

        // Encuentra el área por su ID
        $supplier = Supplier::find($id);

        if (!$supplier) {
            // Maneja el caso en el que el área no se encuentra
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Actualiza los datos del área
        $supplier->business_name = $request->input('businessName');
        $supplier->ruc = $request->input('ruc');
        $supplier->phone = $request->input('phone');
        $supplier->direccion = $request->input('direccion');
        $supplier->product_amount = $request->input('productAmount');
        $supplier->manager = $request->input('manager');
        $supplier->agreement_date = $request->input('agreementDate');
        $supplier->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Área actualizada con éxito']);
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Realiza una eliminación suave del área
        $supplier->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Área desactivada con éxito']);
    }
}
