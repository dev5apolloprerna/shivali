<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BottomVideo;
use Illuminate\Support\Facades\DB;

class BottomViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $BottomVideo = BottomVideo::orderBy('id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PER_PAGE_COUNT'));

            return view('admin.bottomvideo.index', compact('BottomVideo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        $BottomVideo = BottomVideo::findOrFail($id);

        $validated = $request->validate([
            'video' => 'required|url',  // Adjust validation rules as needed
        ]);

        $validated['strIP'] = $request->ip();
        $BottomVideo->update($validated);

        return redirect()->route('BottomVideo.index')
            ->with('success', 'Video updated successfully!');
    }


    public function delete(Request $request, $id)
    {
        try {
            DB::table('bottom_video')->where(['id' => $id])->delete();

            return redirect()->route('BottomVideo.index')->with('success', 'Deleted Successfully!.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
