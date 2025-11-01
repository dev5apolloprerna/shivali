<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

/**
 * Resolve the absolute filesystem root where "Shivali" lives.
 * Live:   /.../public_html/Shivali
 * Local:  {project}/public/Shivali  (fallback)
 */
if (! function_exists('anx_target_root')) {
    function anx_target_root(): string
    {
        // Try to locate cPanel-like path relative to the project
        $live = realpath(base_path('../public_html/Shivali')) ?: base_path('../public_html/Shivali');

        // If that exists/useable, prefer it
        if (File::isDirectory($live)) {
            return rtrim($live, '/\\');
        }

        // Fallback to local public/Shivali
        return rtrim(public_path('Shivali'), '/\\');
    }
}

/**
 * Base public URL that maps to anx_target_root()
 * Live:   {APP_URL}/Shivali
 * Local:  {APP_URL}/Shivali
 */
if (! function_exists('anx_base_url')) {
    function anx_base_url(string $append = ''): string
    {
        $base = rtrim(config('app.url'), '/') . '/Shivali';
        return $append ? $base . '/' . ltrim($append, '/') : $base;
    }
}

/**
 * Upload a file under {anx_target_root()}/uploads/{folder}/{filename}
 * Returns the relative DB path like: uploads/{folder}/{filename}
 */
if (! function_exists('anx_upload')) {
    function anx_upload(UploadedFile $file, string $folder, ?array $allowedExt = null): string
    {
        $allowedExt = $allowedExt ?: ['jpg','jpeg','png','webp','gif','pdf','doc','docx','xls','xlsx','csv','txt'];

        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        if (!in_array($ext, $allowedExt, true)) {
            throw new \RuntimeException("File type .$ext not allowed.");
        }

        $root = anx_target_root(); // e.g., /home/USER/public_html/Shivali
        $dir  = $root . '/uploads/' . trim($folder, '/');

        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0775, true);
        }

        $filename = time() . '_' . uniqid('', true) . '.' . $ext;
        $absPath  = $dir . '/' . $filename;

        // Move the file
        $file->move($dir, $filename);

        // Return relative path to be stored in DB
        return 'uploads/' . trim($folder, '/') . '/' . $filename;
    }
}

/**
 * Delete previously stored relative path (uploads/...)
 */
if (! function_exists('anx_delete')) {
    function anx_delete(?string $relative): void
    {
        if (!$relative) return;
        $abs = anx_target_root() . '/' . ltrim($relative, '/');
        if (File::exists($abs)) {
            File::delete($abs);
        }
    }
}

/**
 * Build a public URL from a stored relative path
 */
if (! function_exists('anx_url')) {
    function anx_url(?string $relative): ?string
    {
        return $relative ? anx_base_url($relative) : null;
    }
}
