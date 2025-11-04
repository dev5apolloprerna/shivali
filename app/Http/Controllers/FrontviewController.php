<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Inquiry;
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
        // try {


        // $album = Album::where('slugname',$slugname)->first();
        // $albumid = $album->album_id ?? '';
        // $GalleryMaster = GalleryMaster::where('album_id', $albumid)->paginate(config('app.per_page'));

        return view('frontview.index');
        // } catch (\Throwable $th) {
        //     // ✅ Log detailed error info
        //     Log::error('Error in FrontController@index: ' . $th->getMessage(), [
        //         'file' => $th->getFile(),
        //         'line' => $th->getLine(),
        //         'trace' => $th->getTraceAsString(),
        //         'request_data' => $request->all(),
        //     ]);

        //     return redirect()->back()->withInput();
        // }
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
