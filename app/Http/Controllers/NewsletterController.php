<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{

    public function index(Request $request)
    {
        $newsletters = Newsletter::all();

        if ($request->has('view_deleted')) {
            $newsletters = Newsletter::onlyTrashed()->get();
        }

        return view('index', [
            'newsletters' => $newsletters,
        ]);

    }

    public function store(Request $request)
    {

        $newsletter = Newsletter::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::user()->id,

        ]);

        return redirect()->back()->with('success', 'Data inserted successfully!');

    }

    public function show($id)
    {

        $newsletter = Newsletter::find($id);

        return view('show', [
            'newsletter' => $newsletter,
        ]);

    }

    public function edit($id)
    {

        $newsletter = Newsletter::find($id);

        return view('edit', [
            'newsletter' => $newsletter,
        ]);

    }

    public function update(Request $request, $id)
    {

        $newsletter = Newsletter::find($id);
        $newsletter->title = $request->title;
        $newsletter->content = $request->content;
        $newsletter->save();

        return redirect()->back()->with('success', 'Data updated successfully!');

    }

    public function delete($id)
    {
        $newsletter = Newsletter::where('id', $id)->first();
        $newsletter->delete();

        return back();

    }

    public function restore($id)
    {
        Newsletter::withTrashed()->find($id)->restore();

        return back();
    }
}
