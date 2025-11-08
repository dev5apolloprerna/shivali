<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\TagMaster;
use Illuminate\Http\Request;
use GPBMetadata\Google\Api\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;


class FrontviewController extends Controller

{

    public function index(Request $request, $slugname = null)
    {
        try {
            $newinProducts = Product::with('category')->where('isDelete', 0)->orderBy('product_id', 'desc')->take(4)->get();

            $banners = Banner::orderBy('id', 'desc')->get();
            $bestProducts = Product::with('category')->where(['best_product' => 1, 'isDelete' => 0])->get();
            $explore_by_occasion = SubCategory::where('iCategoryId', 12)->get();
            $shop_by_style = SubCategory::where('iCategoryId', 13)->get();

            $Categories = Category::where('iCategoryId', 14)->first();

            return view('frontview.index', compact('Categories', 'newinProducts', 'banners', 'bestProducts', 'explore_by_occasion', 'shop_by_style'));
        } catch (\Throwable $th) {
            // ✅ Log detailed error info
            Log::error('Error in FrontController@index: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->withInput();
        }
    }

    public function productdetail(Request $request, $catslugname, $productslug)
    {
        try {
            $product = Product::with([
                'productimage' => function ($query) {
                    $query->where('isDelete', 0);
                },
                'videos',
                'category',
                'subcategory'
            ])
                ->where('slug', $productslug)
                ->where('isDelete', 0)
                ->firstOrFail();


            // Fetch related products (same category)
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('product_id', '!=', $product->product_id)
                ->where('isDelete', 0)
                ->take(4)
                ->get();

            return view('frontview.product-detail', compact('product', 'relatedProducts'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function productlist(Request $request, $slugname = null)
    {
        try {

            $subcategory = SubCategory::where('strSlug', $slugname)->first();
            $category = Category::where('strSlug', $slugname)->first();
            $tagmaster = TagMaster::get();

            $query = Product::with(['category', 'subcategory', 'tags'])->where('isDelete', 0);

            // Filter by slug
            if ($subcategory) {
                $query->where('subcategory_id', $subcategory->iSubCategoryId);
            } elseif ($category) {
                $query->where('category_id', $category->iCategoryId);
            }

            // Filter by tags (any product having any selected tag)
            if ($request->filled('tags')) {
                $tagIds = $request->input('tags'); // must be IDs like [1,2,3]
                $query->whereHas('tags', function ($q) use ($tagIds) {
                    $q->whereIn('tag_id', $tagIds); // adjust to your actual PK
                });
            }

            // Filter by categories
            if ($request->filled('categories')) {
                $query->whereIn('category_id', $request->categories);
            }

            // Sorting
            if ($request->sort === 'Recommended') {

                $query->orderBy('product_id', 'desc');
            } elseif ($request->sort === 'best-product') {

                $query->where('best_product', 1)->orderBy('product_id', 'desc');
            } elseif ($request->sort === 'newest') {
                $query->orderBy('product_id', 'desc');
            }

            //dd($query->toSql());
            $products = $query->get();

            return view('frontview.product-list', compact('products', 'tagmaster'));
        } catch (\Throwable $th) {
            \Log::error($th);
            return redirect()->back()->withInput();
        }
    }




    public function AboutUs(Request $request)
    {
        try {
            return view('frontview.Aboutus');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function ContactUs(Request $request)
    {
        try {
            return view('frontview.contactus');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function contactstore(Request $request)
    {
        try {

            $user = Inquiry::create([
                'name'    => $request->name,
                'business_type'    => $request->business_type,
                'email'     => $request->email,
                'mobileNumber'         => $request->mobileno,
                'address'     => $request->address,
                'city'     => $request->city,
                'state'     => $request->state,
                'country'     => $request->country,
                'pincode'     => $request->pincode,
                'message'     => $request->message,

            ]);
            $sendEmailDetails = DB::table('sendemaildetails')->where(['id' => 4])->first();

            $msg = [
                'FromMail' => $sendEmailDetails->strFromMail,
                'Title' => $sendEmailDetails->strTitle,
                'ToEmail' => 'ai.dev.laravel10@gmail.com',
                'Subject' => $sendEmailDetails->strSubject ?? '',
            ];

            $data = [
                'Name' => $user->name,
                'Email' => $user->email,
                'Mobile' => $user->mobileNumber,
                'Message' => $user->message,
                'business_type' => $user->business_type,
            ];

            Mail::send('emails.contactemail', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });


            return redirect()->route('front.index')->with('success', 'Inquiry added successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }





    public function image(Request $request)
    {
        try {
            $images = GalleryMaster::with('album')->where('isDelete', 0)->paginate(config('app.per_page'));
            return view('frontview.image', compact('images'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function video(Request $request)
    {
        try {
            $videos = VideoGallery::where('isDelete', 0)->paginate(config('app.per_page'));
            return view('frontview.video', compact('videos'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function ThankYou(Request $request)
    {
        try {
            return view('frontview.ThankYou');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function imagedetail(Request $request, $slugname)
    {
        try {
            $album = Album::where('slugname', $slugname)->first();
            $albumid = $album->album_id ?? '';
            $GalleryMaster = GalleryMaster::where('album_id', $albumid)->paginate(config('app.per_page'));
            //$gallarys = GalleryMaster::where(['iStatus'=> 1,'isDelete'=>0])->with('album')->get();

            return view('frontview.imagedetail', compact('GalleryMaster'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function ContactUs_sendmail(Request $request)
    {
        try {

            $name = $request->name;
            $email = $request->email;
            $mobile = $request->mobileno;
            $messageContent = $request->message;
            $sendEmailDetails = DB::table('sendemaildetails')->where(['id' => 4])->first();

            $msg = [
                'FromMail' => $sendEmailDetails->strFromMail,
                'Title' => $sendEmailDetails->strTitle,
                'ToEmail' => 'shreeshyamsewasamitivadodara@gmail.com',
                'Subject' => $sendEmailDetails->strSubject ?? '',
            ];

            $data = [
                'Name' => $name,
                'Email' => $email,
                'Mobile' => $mobile,
                'Message' => $messageContent,
            ];

            Mail::send('emails.contactemail', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });
            return redirect()->route('Front.ThankYou');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }
}
