<?php



namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;



use Illuminate\Http\Request;
use App\Models\CelebrityORDesigner;
use GPBMetadata\Google\Api\Service;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\ValidationException;

class CelebrityOrDesignerController extends Controller

{

    public function index(Request $request)
    {
        try {
            $CelebrityORDesigner = CelebrityORDesigner::paginate(config('app.per_page'));
            return view('admin.CelebrityORDesigner.index', compact('CelebrityORDesigner'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function store(Request $request)

    {

        DB::beginTransaction();
        try {
            $request->validate([
                'image' => 'required|file',
            ]);
            $img = "";
            if ($request->hasFile('image')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('image');
                $img = time() . '_' . date('dmYHis') . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/uploads/CelebrityORDesigner/';

                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }

                $image->move($destinationpath, $img);
            }

            $CelebrityORDesigner = CelebrityORDesigner::create([

                'Type' => $request->Type,
                'image' => $img,
                'created_at' => date('Y-m-d H:i:s'),

            ]);
            DB::commit();

            return redirect()->route('Celebrity_Designer.index')
                ->with('success', 'Celebrity OR Designer Image Add successfully!');
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
            $data = CelebrityORDesigner::where('id', $id)->first();
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

            if ($request->hasFile('edit_CelebrityDesigner')) {

                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('edit_CelebrityDesigner');
                $img = time() . '_' . date('dmYHis') . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/uploads/CelebrityORDesigner/';


                // Create directory if it doesn't exist
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }

                // Move the image to the destination path
                $image->move($destinationpath, $img);

                // Delete the old image if it exists
                $oldImg = $request->input('hiddenimagePhoto');
                if ($oldImg && file_exists($destinationpath . '/' . $oldImg)) {
                    unlink($destinationpath . '/' . $oldImg);
                }
            } else {
                $img = $request->input('hiddenimagePhoto'); // Retain the old image if no new image is uploaded
            }
            CelebrityORDesigner::where(['id' => $request->id])->update([

                'Type' => $request->editType,
                'image' => $img,
                'updated_at' => date('Y-m-d H:i:s'),

            ]);
            DB::commit();
            return redirect()->route('Celebrity_Designer.index')->with('success', 'Celebrity Designer updated successfully!');
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

            CelebrityORDesigner::where(['id' => $id])->delete();
            DB::commit();
            return redirect()->route('Celebrity_Designer.index')->with('success', 'Deleted Successfully!.');
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
