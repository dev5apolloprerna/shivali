<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopVideo;
use Illuminate\Support\Facades\DB;

class TopViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $TopVideo = TopVideo::orderBy('id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PER_PAGE_COUNT'));

            return view('admin.topvideo.index', compact('TopVideo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $TopVideo = TopVideo::findOrFail($id);

        $validated = $request->validate([
            'video' => 'required|url',  // Adjust validation rules as needed
        ]);

        $validated['strIP'] = $request->ip();
        $TopVideo->update($validated);

        return redirect()->route('TopVideo.index')
            ->with('success', 'Video updated successfully!');
    }


    public function delete(Request $request, $id)
    {
        try {
            DB::table('top_video')->where(['id' => $id])->delete();

            return redirect()->route('TopVideo.index')->with('success', 'Deleted Successfully!.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
