<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use Illuminate\Http\Request;
use App\Repositories\ConcessionRepositoryInterface;
use App\Http\Requests\UpdateConcessionRequest;

class ConcessionController extends Controller
{
    protected $concessionRepo;

    public function __construct(ConcessionRepositoryInterface $concessionRepo)
    {
        $this->concessionRepo = $concessionRepo;
    }

    public function AddConcession()
    {
        $concessions = $this->concessionRepo->all();
        return view('concessions.add-concession',compact('concessions'));
    }

    public function StoreConcession(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

       
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('concessions', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }
        

       
        $this->concessionRepo->create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       =>$data['image'],
        ]);

        $notification = [
            'message' => 'Concession added successfully.',
            'alert-type' => 'success'
        ];
        

        return redirect()->back()->with($notification);
    }
    public function UpdateConcession(UpdateConcessionRequest $request, $id)
    {
        $data = $request->validated();

        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('concessions', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        $this->concessionRepo->update($id, $data);

        $notification = [
            'message' => 'Concession updated successfully.',
            'alert-type' => 'success'
        ];
        
        return redirect()->back()->with($notification);
        
    }

    public function destroy($id)
{
    $concession = $this->concessionRepo->find($id);

    if (!$concession) {
        return redirect()->back()->with('error', 'Concession not found.');
    }

    // Delete the image if it exists
    if ($concession->image && file_exists(public_path($concession->image))) {
        unlink(public_path($concession->image));
    }

    $this->concessionRepo->delete($id);

    $notification = [
        'message' => 'Concession deleted successfully.',
        'alert-type' => 'success'
    ];

    return redirect()->route('concession.add')->with($notification);
}

    
}