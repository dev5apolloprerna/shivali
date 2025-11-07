<?php



namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;



use Illuminate\Http\Request;
use App\Models\TagMaster;
use GPBMetadata\Google\Api\Service;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\ValidationException;

class TagMasterController extends Controller

{

    public function index(Request $request)
    {
        try {
            $TagMaster = TagMaster::paginate(config('app.per_page'));

            return view('admin.TagMaster.index', compact('TagMaster'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function store(Request $request)

    {

        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $TagMaster = TagMaster::create([


                'Name' => $request->name,
                'created_at' => date('Y-m-d H:i:s'),

            ]);
            DB::commit();

            return redirect()->route('TageMaster.index')
                ->with('success', 'Tag Add successfully!');
        } catch (ValidationException $e) {

            DB::rollBack();

            $errors = $e->errors();

            $errorMessages = [];
            foreach ($errors as $field => $messages) {

                foreach ($messages as $message) {

                    $errorMessages[] = $message;
                }
            }

            $errorMessageString = implode(', ', $errorMessages);

            return redirect()->back()->withInput();
        } catch (\Throwable $th) {

            DB::rollBack();


            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }



    public function edit(Request $request, $id)

    {
        try {
            $data = TagMaster::where('id', $id)->first();
            return json_encode($data);
        } catch (\Throwable $th) {

            // Rollback and return with Error

            DB::rollBack();

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }



    public function update(Request $request)

    {

        DB::beginTransaction();
        try {

            TagMaster::where(['id' => $request->id])->update([

                'Name' => $request->edit_name,
                'updated_at' => date('Y-m-d H:i:s'),

            ]);
            DB::commit();
            return redirect()->route('TageMaster.index')->with('success', 'Tage Master updated successfully!');
        } catch (ValidationException $e) {

            DB::rollBack();

            $errors = $e->errors();

            $errorMessages = [];

            foreach ($errors as $field => $messages) {

                foreach ($messages as $message) {

                    $errorMessages[] = $message;
                }
            }
            $errorMessageString = implode(', ', $errorMessages);

            return redirect()->back()->withInput();
        } catch (\Throwable $th) {

            DB::rollBack();


            return redirect()->back()->withInput();
        }
    }

    public function delete(Request $request, $id)

    {

        DB::beginTransaction();
        try {
            TagMaster::where(['id' => $id])->delete();
            DB::commit();
            return redirect()->route('TageMaster.index')->with('success', 'Deleted Successfully!.');
            return response()->json(['success' => true]);
        } catch (ValidationException $e) {

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function deleteselected(Request $request)

    {
        try {

            $ids = $request->input('Banner_ids', []);
            Banner::whereIn('id', $ids)->delete();

            Toastr::success('Banner deleted successfully :)', 'Success');

            return back();
        } catch (ValidationException $e) {

            DB::rollBack();

            Toastr::error(implode(', ', $e->errors()));

            return redirect()->back()->withInput();
        } catch (\Throwable $th) {

            DB::rollBack();

            Toastr::error('Error: ' . $th->getMessage());

            return redirect()->back()->withInput();
        }
    }
}
