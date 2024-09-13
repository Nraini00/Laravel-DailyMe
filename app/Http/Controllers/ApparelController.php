<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Apparel;
use App\Models\Type;


class ApparelController extends Controller
{
    public function index()
    {
       // Fetch apparels with associated types 
    $apparels = Apparel::with('type')->where('user_id', auth()->id())->get();
    
    // dropdown
    $types = Type::all();

    return view('main.apparel', compact('apparels', 'types'));
    }



    // create the apparel
    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
            'color' => 'required',
            'quantity' => 'required',
            'purchase_date' => 'required',
            'price' => 'required',
            'brand' => 'required',
            'attachment' => 'nullable|file'
        ]);

        $apparel = new Apparel();
        $apparel->user_id = auth()->id(); // Set user_id from authenticated user
        $apparel->type_id = $request->type_id;
        $apparel->name = $request->name;
        $apparel->color = $request->color;
        $apparel->quantity = $request->quantity;
        $apparel->purchase_date = $request->purchase_date;
        $apparel->price = $request->price;
        $apparel->brand = $request->brand;
        $apparel->remarks = $request->remarks;

        if ($request->hasFile('attachment')) {
            // Store the file and get the file path
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $apparel->attachment = $filePath;
        }

        $apparel->save();

        return redirect()->route('apparel.index')->with('success', 'Apparel added successfully!');
    }


    // view the edit 
    public function edit($id)
    {
        $apparel = Apparel::findOrFail($id);
        
        $types = Type::all();
        return view('main.apparel_edit', compact('apparel', 'types'));
    }

    // update the apparel
    public function update(Request $request, Apparel $apparel)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
            'color' => 'required',
            'quantity' => 'required',
            'purchase_date' => 'required',
            'price' => 'required',
            'brand' => 'required',
            'attachment' => 'nullable|file'
        ]);

        // Ensure the user is authorized to update this apparel
        if ($apparel->user_id !== auth()->id()) {
            return redirect()->route('apparel.index')->with('error', 'Unauthorized action.');
        }

        $apparel->type_id = $request->type_id;
        $apparel->name = $request->name;
        $apparel->color = $request->color;
        $apparel->quantity = $request->quantity;
        $apparel->purchase_date = $request->purchase_date;
        $apparel->price = $request->price;
        $apparel->brand = $request->brand;
        $apparel->remarks = $request->remarks;

        if ($request->hasFile('attachment')) {
            // Delete the old attachment if it exists
            if ($apparel->attachment) {
                Storage::disk('public')->delete($apparel->attachment);
            }

            // Store the new attachment
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $apparel->attachment = $filePath;
        }

        $apparel->save();

        return redirect()->route('apparel.index')->with('success', 'Apparel updated successfully!');
    }

    
    //  delete the apparel
    public function destroy(Apparel $apparel)
    {
        $apparel->delete();
        return redirect()->route('apparel.index')->with('success', 'Apparel deleted successfully!');
    }
}
