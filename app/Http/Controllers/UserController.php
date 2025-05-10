<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('address')
            ->when($request->search, fn ($query, $search) =>
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
            )
			->orderBy('last_name')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

	public function show(User $user) {
		$user->load('address');

		return Inertia::render('Users/Show', [
			'user' => $user,
		]);
	}

    public function editByAdmin(User $user) {
        return Inertia::render('Users/EditByAdmin', ['user' => $user]);
    }

	public function updateByAdmin(Request $request, User $user)
	{
		$request->validate([
			'first_name' => 'required|string|max:255',
			'last_name'  => 'required|string|max:255',
			'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
		]);

		$user->update([
			'first_name' => $request->first_name,
			'last_name'  => $request->last_name,
			'email'      => $request->email,
		]);

		return redirect()->route('users.show', $user);
	}

	// TODO: implement soft and hard deletes

    public function toggleStatus(User $user) {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->back();
    }

    public function destroy(User $user) {
        $user->delete(); 
        return redirect()->route('dashboard');
    }
}
