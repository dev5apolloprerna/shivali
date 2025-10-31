<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /** List page (filters + table) */
    public function index(Request $request)
    {
        $q          = trim($request->get('q', ''));
        $categoryId = (int) $request->get('category_id', 0);
        $subcatId   = (int) $request->get('subcategory_id', 0);

        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');

        $list = Product::with(['category','subcategory'])
            ->where('isDelete', 0)
            ->when($q !== '', function($x) use ($q) {
                $x->where(function($w) use ($q) {
                    $w->where('product_name','like',"%{$q}%")
                      ->orWhere('slug','like',"%{$q}%")
                      ->orWhere('description','like',"%{$q}%");
                });
            })
            ->when($categoryId > 0, fn($x)=>$x->where('category_id', $categoryId))
            ->when($subcatId > 0, fn($x)=>$x->where('subcategory_id', $subcatId))
            ->orderByDesc('product_id')
            ->paginate(20)
            ->appends($request->query());

        return view('admin.product.index', compact('categories','subcategories','list','q','categoryId','subcatId'));
    }

    /** Add page */
    public function create()
    {
        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');

        return view('admin.product.form', [
            'row' => null,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    /** Save new */
        // app/Http/Controllers/Admin/ProductController.php

public function store(Request $request)
{

    $request->validate([
        'product_name'   => ['required','string','max:255'], // "string" will also reject arrays
        'description'    => ['nullable','string','max:255'],
        'category_id'    => ['required','integer'],
        'subcategory_id' => ['required','integer'],
        'iStatus'        => ['nullable','in:0,1'],
        'product_image'  => ['required','image','mimes:jpg,jpeg,png,webp','max:2048'],
    ]);


        $imageRel = null;
        $uploadFile = $request->file('product_image') ?: $request->file('product_image');
        if ($uploadFile) {
            $meta = anx_upload($uploadFile, 'products');
            $imageRel = $meta['relative']; // store relative path
        }

    $p = new Product();
    $p->product_name   = $request->product_name;
    $p->slug           = Product::makeUniqueSlug($p->product_name);
    $p->description    = $request->input('description') ?: null;
    $p->category_id    = (int)$request->input('category_id');
    $p->subcategory_id = (int)$request->input('subcategory_id');
    $p->product_image = $imageRel;

    /*if ($request->hasFile('product_image')) {


        $p->product_image = anx_upload($request->file('product_image'), 'products');
    }*/

    $p->save();
    return redirect()->route('admin.products.index')->with('success','Product added.');
}

public function update(Request $request, \App\Models\Product $product)
{
    if (is_array($request->input('product_name'))) {
        return back()
            ->withErrors(['product_name' => 'Product name must be a single value.'])
            ->withInput();
    }

    $request->validate([
        'product_name'   => ['bail','required','string','max:255'],
        'description'    => ['nullable','string','max:255'],
        'category_id'    => ['required','integer'],
        'subcategory_id' => ['required','integer'],
        'iStatus'        => ['nullable','in:0,1'],
        'product_image'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
    ]);

    $product->product_name   = trim((string)$request->input('product_name'));
    $product->slug           = \App\Models\Product::makeUniqueSlug($product->product_name, $product->product_id);
    $product->description    = $request->input('description') ?: null;
    $product->category_id    = (int)$request->input('category_id');
    $product->subcategory_id = (int)$request->input('subcategory_id');
    $product->iStatus        = (int)($request->input('iStatus', $product->iStatus));
    $product->updated_at     = now();


        $uploadFile = $request->file('product_image') ?: $request->file('product_image');
        if ($uploadFile) {
            // delete old file if present
            anx_delete($product->product_image);

            $meta = anx_upload($uploadFile, 'products');
            $product->product_image = $meta['relative'];
        }



    $product->save();
    $product->image_url = anx_url($product->product_image);


    return redirect()->route('admin.products.index')->with('success','Product updated.');
}


    /** Edit page */
    public function edit(Product $product)
    {
        abort_if($product->isDelete, 404);

        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');

        return view('admin.product.form', [
            'row' => $product,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

   

    /** Soft delete */
    public function destroy(Product $product)
    {
        $product->isDelete   = 1;
        $product->updated_at = now();
        $product->save();

        if (!empty($product->product_image)) {
            anx_delete($product->product_image);
        }
        return back()->with('success','Product deleted.');
    }

    /** Toggle Active/Inactive */
    public function toggleStatus(Product $product)
    {
        abort_if($product->isDelete, 404);

        $product->iStatus = $product->iStatus ? 0 : 1;
        $product->updated_at = now();
        $product->save();

        return back()->with('success','Status updated.');
    }
}
