<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();
        return view('admin.membership', compact('plans'));
    }
    public function create()
    {
        return view('admin.membership');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        // dd($request->all());
        $isNewPlan = !$request->input('id');
        $plan = MembershipPlan::findOrNew($request->input('id'));
        $plan->title = $request->title;
        $plan->slug = Str::slug($request->title);
        $plan->description = $request->description;
        // $plan->available_features = $request->available_features;
        // $plan->not_available_features = $request->not_available_features;
        // $plan->price = $request->price;
        // $plan->duration = $request->duration;
        // $plan->trial = $request->trial;
        $plan->save();
        // Alert::toast('Membership created successfully', 'success');
        // return redirect()->route('admin.membership.index');
        if ($isNewPlan) {
            return response()->json(['message' => 'Membership plan created successfully'], 200);
        } else {
            return response()->json(['message' => 'Membership plan updated successfully'], 200);
        }
    }
    public function edit($id)
    {
        $plan = MembershipPlan::find($id);
        // return view('admin.membership', compact('plan'));
        return response()->json($plan, 200);
    }
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title' => ''
        // ])
        // dd($request->all());
        $plan = MembershipPlan::find($id);
        $plan->title = $request->title;
        $plan->slug = Str::slug($request->title);
        $plan->description = $request->description;
        $plan->available_features = $request->available_features;
        $plan->not_available_features = $request->not_available_features;
        $plan->price = $request->price;
        $plan->duration = $request->duration;
        $plan->trial = $request->trial;
        $plan->save();
        Alert::toast('Membership updated successfully', 'success');
        return redirect()->route('admin.membership.index');
    }
    public function destroy($id)
    {
        MembershipPlan::destroy($id);
        Alert::toast('Membership deleted successfully', 'success');
        return redirect()->back();
    }
}