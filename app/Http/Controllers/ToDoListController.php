<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Carbon;

class ToDoListController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $todolists = ToDoList::all()->where('deleted_at',null);

        return Inertia::render('Todolist/List', [
            'todolists' => $todolists,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function create(Request $request){
        //dd($request);
        $validated = $request->validate([
            'title' => 'required|max:255',
            'text' => 'required',
            'status' => 'required',
        ]);
        $todolist = new ToDoList();
        $todolist->title = $request->title;
        $todolist->text = $request->text;
        $todolist->status = $request->status;
        if($todolist->save()){
            $requestMessage = 'Request have been save';
            return redirect()->back()->with('success', 'Request have been save.');
        }
    }
    /**
     * Display the todolist form.
     */
    public function edit($id)
    {
        $todolist = ToDoList::where('id',$id)->first();

        return Inertia::render('Todolist/Edit', [
            'todolist' => $todolist,
        ]);
    }

    /**
     * Update the todolist's item.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'text' => 'required',
            'status' => 'required',
        ]);
        $todolist = ToDoList::where('id',$id)->first();
        $todolist->title = $request->title;
        $todolist->text = $request->text;
        $todolist->status = $request->status;
        if($todolist->save()){
            return redirect()->route('todolist')->with('success', 'Request have been updated.');
        }
    }

    /**
     * Delete the todolist's item
     */
    public function destroy($id)
    {
        $todolist = ToDoList::where('id',$id)->first();
        $mytime = Carbon\Carbon::now();
        $todolist->deleted_at = $mytime;
        $todolist->save();
        return redirect()->back()->with('success', 'Request have been deleted.');
    }
}
