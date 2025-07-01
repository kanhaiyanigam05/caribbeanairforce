<?php

namespace App\Http\Controllers\Admin\Email;

use App\Http\Controllers\Controller;
use App\Models\MailList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class MailListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = MailList::all();
        $users = User::all();
        return view('admin.email.maillist', compact('lists', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $user = User::with('followers')->find(Auth::id());
        // $subscribers = $user->followers;
        $subscribers = User::all();
        return view('admin.email.maillist', compact('subscribers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array'
        ]);
        // dd($request->all());
        $mailList = new MailList();
        $mailList->user_id = Auth::id();
        $mailList->name = $request->name;
        // $mailList->description = $request->description;
        $mailList->save();
        $mailList->subscribers()->sync($request->users);
        Alert::toast('MailList saved successfully', 'success');
        return redirect()->route('admin.email.lists.index')->with('success', 'Mail list created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lists = MailList::all();
        $list = MailList::findOrFail($id);
        return view('admin.email.maillist', compact('lists', 'list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $list = MailList::findOrFail($id);
        $user = User::with('followers')->find(Auth::id());
        $subscribers = $user->followers;
        return view('admin.email.maillist', compact('subscribers', 'list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $list = MailList::findOrFail($id);
        // / Validate that the user ID to be removed exists in the request
        $request->validate([
            'remove_user' => 'required|exists:users,id',
        ]);

        // Get the user ID from the request
        $userId = $request->remove_user;

        // Remove the user from the subscribers of this list
        $list->subscribers()->detach($userId);

        Alert::toast('User removed from the mail list', 'success');

        return redirect()->back()->with('success', 'User removed from the mail list.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $list = MailList::findOrFail($id);
        $list->subscribers()->detach();
        $list->delete();
        Alert::toast('MailList deleted successfully', 'success');
        return redirect()->route('admin.email.lists.index')->with('success', 'Mail list deleted successfully.');
    }
}