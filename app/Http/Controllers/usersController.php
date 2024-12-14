<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    // Display the list of users
    public function index()
    {
        $users = DB::select('select * from users');
        return view('users', ['users' => $users]);
    }

    // Show the create user form
    public function create()
    {
        return view('create');
    }

    // Store the user data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'cphone' => 'required'
        ]);

        DB::insert('insert into users (name, email, cphone) values (?, ?, ?)', [
            $request->name, 
            $request->email, 
            $request->cphone
        ]);

        return redirect('users')->with('success', 'User added successfully');
    }

    // Show the edit form for a specific user
    public function edit($id)
    {
        $user = DB::select('select * from users where id = ?', [$id])[0];
        return view('edit', ['user' => $user]);
    }

    // Update the user details
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'cphone' => 'required'
        ]);

        DB::update('update users set name = ?, email = ?, cphone = ? where id = ?', [
            $request->name, 
            $request->email, 
            $request->cphone, 
            $id
        ]);

        return redirect('users')->with('success', 'User updated successfully');
    }

    // Delete a single user
    public function destroy($id)
    {
        DB::delete('delete from users where id = ?', [$id]);
        return redirect('users')->with('success', 'User deleted successfully');
    }

    // Bulk delete multiple users
    public function destroySelected(Request $request)
    {
        $ids = $request->input('user_ids');
        
        if (!empty($ids)) {
            DB::delete('delete from users where id in (' . implode(',', $ids) . ')');
            return redirect('users')->with('success', 'Selected users deleted successfully');
        } else {
            return redirect('users')->with('error', 'No users selected for deletion');
        }
    }
}
