<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;

class ProfileController extends Controller
{

    public function index()
    {
        $profiles = Profile::all();
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'profile_image' => 'required|image|mimes:jpg',
            'name' => 'required|max:25',
            'phone' => 'required|regex:/^\+1-\(\d{3}\) \d{3}-\d{4}$/',
            'email' => 'required|email|unique:profiles',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required|in:CA,NY,AT',
            'country' => 'required|in:IN,US,EU'
        ]);
    
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
    
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            $file->move(public_path('uploads'), $fileName);
    
            $validatedData['profile_image'] = 'uploads/' . $fileName;
        }
        Profile::create($validatedData);
    
        return redirect('/profiles')->with('success', 'Profile created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpg',
            'name' => 'required|max:25',
            'phone' => 'required|regex:/^\+1-\(\d{3}\) \d{3}-\d{4}$/',
            'email' => 'required|email|unique:profiles,email,' . $id,
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required|in:CA,NY,AT',
            'country' => 'required|in:IN,US,EU'
        ]);

        $profile = Profile::findOrFail($id);

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image && file_exists(public_path($profile->profile_image))) {
                unlink(public_path($profile->profile_image));
            }

            $file = $request->file('profile_image');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads'), $fileName);

            $validatedData['profile_image'] = 'uploads/' . $fileName;
        }
        $profile->update($validatedData);

        return redirect('/profiles')->with('success', 'Profile updated successfully.');
    }
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if ($profile->profile_image && file_exists(public_path($profile->profile_image))) {
            unlink(public_path($profile->profile_image));
        }

        $profile->delete();
        return redirect('/profiles')->with('success', 'Profile deleted successfully.');
    }
  
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $path = $request->file('csv_file')->getRealPath();

        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            $validator = Validator::make($rowData, [
                'profile_image' => 'required|string',
                'name' => 'required|string|max:25',
                'phone' => 'required|regex:/^\+1-\(\d{3}\) \d{3}-\d{4}$/',
                'email' => 'required|email|unique:profiles,email',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|in:CA,NY,AT',
                'country' => 'required|in:IN,US,EU',
            ]);

            if ($validator->fails()) {
                continue;
            }
            Profile::create([
                'profile_image' => $rowData['profile_image'],
                'name' => $rowData['name'],
                'phone' => $rowData['phone'],
                'email' => $rowData['email'],
                'street_address' => $rowData['street_address'],
                'city' => $rowData['city'],
                'state' => $rowData['state'],
                'country' => $rowData['country'],
            ]);
        }
        return redirect('/profiles')->with('success', 'CSV file imported successfully.');
    }
}
