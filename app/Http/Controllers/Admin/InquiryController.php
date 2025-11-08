<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $inquiries = Inquiry::orderBy('inquiry_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PER_PAGE_COUNT'));
            return view('admin.inquiries.index', compact('inquiries'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function exportCsv()
    {
        try {
            $fileName = 'inquiry_list_' . date('Ymd_His') . '.csv';
            $inquiries = Inquiry::where(['iStatus' => 1, 'isDelete' => 0])
                ->orderBy('inquiry_id', 'ASC')
                ->get([
                    'inquiry_id',
                    'name',
                    'mobileNumber',
                    'email',
                    'business_type',
                    'address',
                    'state',
                    'city',
                    'country',
                    'pincode',
                    'message',
                ]);

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            ];

            $columns = [
                'No',
                'Name',
                'Mobile Number',
                'Email',
                'Business Type',
                'Address',
                'State',
                'City',
                'Country',
                'Pincode',
                'Message'
            ];

            $callback = function () use ($inquiries, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($inquiries as $inquiry) {
                    fputcsv($file, [
                        $inquiry->inquiry_id,
                        $inquiry->name,
                        $inquiry->mobileNumber,
                        $inquiry->email,
                        $inquiry->business_type,
                        $inquiry->address,
                        $inquiry->state,
                        $inquiry->city,
                        $inquiry->country,
                        $inquiry->pincode,
                        $inquiry->message,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function view($id)
    {
        try {

            $inquiry = Inquiry::orderBy('inquiry_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0, 'inquiry_id' => $id])->first();
            return view('admin.inquiries.view', compact('inquiry'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function delete(Request $request)
    {
        try {

            DB::table('inquiry')->where(['inquiry_id' => $request->inquiry_id])->delete();

            return redirect()->route('Inquiry.index')->with('success', 'Deleted Successfully!.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
