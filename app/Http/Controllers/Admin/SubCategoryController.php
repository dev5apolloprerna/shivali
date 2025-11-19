<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with('category')
            ->orderBy('iSubCategoryId', 'desc')
            ->paginate(10);
        $categories = Category::orderBy('strCategoryName', 'asc')->pluck('strCategoryName', 'iCategoryId');

        return view('admin.sub-category.index', compact('subcategories', 'categories'));
    }

    /*    public function create()
    {
        return view('admin.sub-category.create', compact('categories'));
    }
*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'strSubCategoryName' => 'required|string|max:50',
            // 'strSlug' => 'required|string|max:50',
            'iCategoryId' => 'required|exists:category,iCategoryId',
        ]);

        $img = "";
        // if ($request->hasFile('subcategory_img')) {
        //     $root = $_SERVER['DOCUMENT_ROOT'];
        //     $image = $request->file('subcategory_img');
        //     $img = time() . '_' . date('dmYHis') . '.' . $image->getClientOriginalExtension();
        //     $destinationpath = $root . '/uploads/subcategory-images/';

        //     if (!file_exists($destinationpath)) {
        //         mkdir($destinationpath, 0755, true);
        //     }

        //     // $image->move($destinationpath, $img);
        //     $image->move(anx_upload('/uploads/subcategory-images'), $img);

        // }
        $img = anx_upload($request->file('subcategory_img'), 'subcategory-images');

        $validated['subcategory_img'] = $img;
        $validated['iStatus'] = 1;
        $validated['isDelete'] = 0;
        $validated['strIP'] = $request->ip();

        SubCategory::create($validated);

        return redirect()->route('admin.sub-category.index')
            ->with('success', 'Sub Category created successfully!');
    }

    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('strCategoryName', 'asc')->pluck('strCategoryName', 'iCategoryId');

        return view('admin.sub-category.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $validated = $request->validate([
            'strSubCategoryName' => 'required|string|max:50',
            // 'strSlug' => 'required|string|max:50',
            'iCategoryId' => 'required|exists:category,iCategoryId',
        ]);

          if ($request->hasFile('subcategory_img')) {
    
            // delete old
            anx_delete($subcategory->subcategory_img);
    
            // upload new (returns string)
            $newImage = anx_upload($request->file('subcategory_img'), 'subcategory-images');
    
            // store in DB
            $validated['subcategory_img'] = $newImage;
    
        } else {
    
            // keep old image
            $validated['subcategory_img'] = $subcategory->subcategory_img;
        }
        
      
        $validated['strIP'] = $request->ip();

        $subcategory->update($validated);

        return redirect()->route('admin.sub-category.index')
            ->with('success', 'Sub Category updated successfully!');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->update(['isDelete' => 1]);

        return redirect()->route('admin.sub-category.index')
            ->with('success', 'Sub Category deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            SubCategory::whereIn('iSubCategoryId', $ids)
                ->update(['isDelete' => 1]);

            return redirect()->route('admin.sub-category.index')
                ->with('success', 'Selected sub-categories deleted successfully!');
        }

        return redirect()->route('admin.sub-category.index')
            ->with('error', 'No sub-categories selected for deletion.');
    }

    /**
     * Return sub categories for given category id
     */
    public function byCategory($iCategoryId)
    {
        $subcategories = SubCategory::where('iCategoryId', $iCategoryId)
            ->where('isDelete', 0)
            ->orderBy('strSubCategoryName', 'asc')
            ->get(['iSubCategoryId', 'strSubCategoryName']);

        return response()->json($subcategories);
    }
}
