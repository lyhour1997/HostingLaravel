<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $data['posts'] = Post::where('active', 1)
                ->orderBy('id', 'desc')
                ->paginate(5); // for filtered queries

        return view('posts.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {

        $data = array(
            'name' => $r->name,
            'description' => $r->desc,
        );

        $save = Post::create($data);

        if($save){
            return redirect()->route('posts.index')
                ->with('success','Data has been saved successful!');

        }else{
            return redirect()->route('posts.index')
                ->with('error', 'Failed to save data!');

        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
    {
        $data = $r->only(['name', 'description']);

        $update = Post::where('id', $id)->update($data);

        if($update){
            return redirect()->route('posts.index')
                    ->with('success', 'Data has been updated successfully');
        }else{
            return redirect()->route('posts.index')
                    ->with('error', "Failed to update data!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        
        $del = Post::where('id',$id)
                ->update(['active'=>0]);

        if ($del) {
            return redirect()->route('posts.index')
                ->with('success', 'Post has been hidden successfully.');
        }else{
            return redirect()->route('posts.index')
            ->with('error', 'Post not found.');
        }   

        
    }

}
