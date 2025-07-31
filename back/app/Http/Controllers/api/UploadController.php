<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Lista TODOS los archivos del disco público.
     * GET /api/uploads
     */
    public function index(): JsonResponse
    {
        $files = collect(Storage::disk('public')->allFiles())
            ->map(fn($path) => [
                'name'          => basename($path),
                'path'          => $path,
                'url'           => Storage::url($path),
                'size_readable' => $this->humanSize(Storage::size($path)),
                'mime'          => Storage::mimeType($path),
                'last_modified' => date('Y-m-d H:i:s', Storage::lastModified($path)),
            ])
            ->values();

        return response()->json(['files' => $files], 200);
    }

    /**
     * Recibe un archivo y lo guarda en la carpeta indicada.
     * POST /api/uploads
     */
    public function store(Request $request): JsonResponse
    {
        /* 1️⃣ Validación estricta según Laravel 12 */
        $validated = $request->validate([
            'file'   => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx'],
            'folder' => ['required', 'string', 'max:50', 'regex:/^[\w\-\/]+$/'],
        ]);

        /* 2️⃣ Guardado seguro con nombre único */
        $folder   = trim($validated['folder'], '/');
        $path     = $request->file('file')->store($folder, 'public');

        return response()->json([
            'path' => $path,
            'url'  => Storage::url($path),
            'name' => $request->file('file')->getClientOriginalName(),
            'mime' => $request->file('file')->getMimeType(),
            'size' => $request->file('file')->getSize(),
        ], 201);
    }

    /**
     * Actualiza un archivo existente.
     * PUT /api/uploads/{path}
     */
    public function update(Request $request, string $path): JsonResponse
    {
        $request->validate(['file' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx']]);

        $cleanPath = ltrim($path, '/');
        if (! Storage::disk('public')->exists($cleanPath)) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        Storage::disk('public')->delete($cleanPath);

        $folder   = dirname($cleanPath);
        $newPath  = $request->file('file')->store($folder, 'public');

        return response()->json([
            'path' => $newPath,
            'url'  => Storage::url($newPath),
            'name' => $request->file('file')->getClientOriginalName(),
            'mime' => $request->file('file')->getMimeType(),
            'size' => $request->file('file')->getSize(),
        ]);
    }

    /**
     * Devuelve el tamaño legible (KB, MB…).
     */
    private function humanSize(int $bytes, int $decimals = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $pow   = floor(log($bytes, 1024)) ?: 0;

        return round($bytes / 1024 ** $pow, $decimals) . ' ' . $units[$pow];
    }
}
