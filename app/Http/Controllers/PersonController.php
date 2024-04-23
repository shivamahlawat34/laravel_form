<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\CSV;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    public function index()
    {
        $persons = People::all();
        return view('persons.index', compact('persons'));
    }

    public function create()
    {
        return view('persons.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:people',
            'mobile' => 'required|digits:10|unique:people',
            'profile_pic' => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('persons.create')->withErrors($validator)->withInput();
        }

        $person = new People();
        $person->name = $request->name;
        $person->email = $request->email;
        $person->mobile = $request->mobile;
        $person->password = bcrypt($request->password);

        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_pics'), $imageName);
            $person->profile_pic = $imageName;
        }

        $person->save();

        return redirect()->route('persons.index')->with('success', 'Person created successfully.');
    }

    public function edit(People $person)
    {
        return view('persons.edit', compact('person'));
    }

    public function update(Request $request, People $person)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:people,email,' . $person->id,
            'mobile' => 'required|digits:10|unique:people,mobile,' . $person->id,
            'profile_pic' => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('persons.edit', $person->id)->withErrors($validator)->withInput();
        }

        $person->name = $request->name;
        $person->email = $request->email;
        $person->mobile = $request->mobile;
        $person->password = bcrypt($request->password);

        if ($request->hasFile('profile_pic')) {
            if ($person->profile_pic) {
                // If a profile picture already exists, delete it before updating
                Storage::delete('profile_pics/' . $person->profile_pic);
            }

            $image = $request->file('profile_pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_pics'), $imageName);
            $person->profile_pic = $imageName;
        }

        $person->save();

        return redirect()->route('persons.index')->with('success', 'Person updated successfully.');
    }


    public function destroy(People $person)
    {
        $person->delete();
        return redirect()->route('persons.index')->with('success', 'Person deleted successfully.');
    }

    public function export()
    {
        $persons = People::all();

        $csvFileName = 'people.csv';
        $headers = ['Name', 'Email', 'Mobile', 'Profile Pic'];

        $callback = function () use ($persons, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($persons as $person) {
                fputcsv($file, [
                    $person->name,
                    $person->email,
                    $person->mobile,
                    $person->profile_pic,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ]);
    }
}
