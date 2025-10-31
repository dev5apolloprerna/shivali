<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

if (! function_exists('anx_target_root')) {
    /**
     * Pick the correct disk root for writes:
     * - If live dir exists (../public_html/anvixa), use that
     * - Else fallback to local public/anvixa
     */
    function anx_target_root(): string
    {
        $live = anvixa_base_path(); // from your snippet
        if (File::isDirectory($live)) {
            return $live;
        }
        return public_path('anvixa');
    }
}

if (! function_exists('anx_base_url')) {
    /**
     * Public base URL for the same content.
     * Uses your anvixa_base_url(), and falls back to app url + /anvixa
     */
    function anx_base_url(string $append = ''): string
    {
        $base = anvixa_base_url(); // from your snippet
        // If you're running locally and the above already resolves correctly, remove the fallback:
        if (!$base) {
            $base = rtrim(config('app.url'), '/') . '/anvixa';
        }
        return $append ? rtrim($base, '/') . '/' . ltrim($append, '/') : rtrim($base, '/');
    }
}

if (! function_exists('anx_upload')) {
    /**
     * Move an uploaded file to anvixa/uploads/{subdir}/{filename}
     * Returns array: [relative, url, filename, mime, size]
     *
     * @param UploadedFile $file
     * @param string $subdir (e.g. 'gallery', 'documents')
     * @param array|null $allowedExt override allowed extensions
     */
    function anx_upload($file, $folder)
        {
            // Make sure the folder exists
            $uploadPath = public_path('uploads/' . $folder . '/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique file name
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move file to uploads directory
            $file->move($uploadPath, $fileName);

            // ✅ Return string path (NOT array)
            return 'uploads/' . $folder . '/' . $fileName;
        }

}

if (! function_exists('anx_delete')) {
    /**
     * Delete a previously stored file using its DB 'relative' path (uploads/...).
     */
    function anx_delete(?string $relative): void
    {
        if (!$relative) return;
        $abs = rtrim(anx_target_root(), '/') . '/' . ltrim($relative, '/');
        if (File::exists($abs)) {
            File::delete($abs);
        }
    }
}

if (! function_exists('anx_url')) {
    /**
     * Build public URL from stored relative path.
     */
    function anx_url(?string $relative): ?string
    {
        return $relative ? anx_base_url($relative) : null;
    }
}
