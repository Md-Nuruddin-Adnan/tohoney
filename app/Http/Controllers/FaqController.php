<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use Auth;
use Carbon\Carbon;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.faq.index', [
          'faqs' => Faq::latest()->get(),
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
    public function store(Request $request, Faq $faq)
    {
        $request->validate([
            'faq_question' => 'required|min:10',
            'faq_answer' => 'required|min:15',
        ]);
        Faq::insert($request->except('_token') + [
            'created_by' => Auth::id(),
            'created_at' => Carbon::now()
        ]);
        return back()->with('faq_success_status', 'Faq added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.faq.edit', [
            'faq_info' => Faq::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'faq_question' => 'required|min:10',
            'faq_answer' => 'required|min:15',
        ]);
        $faq->update($request->except('_token', '_method'));

        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Faq delete
    public function delete($faq_id){
        Faq::findOrFail($faq_id)->forceDelete();
        return back()->with('faq_delete_status', 'Faq delete successfully');
    }

    // Faq mark delete
    public function markdeletefaq(Request $request){
        if(isset($request->faq_id)){
            foreach ($request->faq_id as $id) {
              Faq::findOrFail($id)->forceDelete();
            }
            return back()->with('mark_delete_status', 'Faq mark delete successfully');
        }
        return back();
    }
}
