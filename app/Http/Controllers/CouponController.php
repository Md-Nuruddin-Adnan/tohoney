<?php

namespace App\Http\Controllers;

use App\Coupon;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupon.index', [
            'coupons' => Coupon::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_name' => 'required|unique:coupons,coupon_name',
            'discount_amount' => 'required|numeric',
            'minimum_purchase_amount' => 'required|numeric',
            'validity_till' => 'required|date',
        ]);
        Coupon::insert($request->except('_token') + [
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('coupon_status', 'Coupon Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit', [
            'coupon_info' => $coupon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'coupon_name' => ['required', 'unique:coupons,coupon_name,'.$coupon->id],
            'discount_amount' => 'required|numeric',
            'minimum_purchase_amount' => 'required|numeric',
            'validity_till' => 'required|date',
        ]);
        $coupon->update($request->except('_token', '_method'));
        return redirect()->route('coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }

    public function coupondelete($coupon_id){
        Coupon::findOrFail($coupon_id)->forceDelete();
        return back()->with('delete_status', 'Coupon deleted sussessfully');
    }
}
