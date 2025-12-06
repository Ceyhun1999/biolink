<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PatientExaminationController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:10240'
        ]);

        $examination = $patient->examinations()->create([
            'notes' => $validated['notes'] ?? null
        ]);

        $uploadedFiles = [];

        $allFiles = $request->allFiles();
        if (isset($allFiles['files']) && is_array($allFiles['files'])) {
            $uploadedFiles = $allFiles['files'];
        }

        if (empty($uploadedFiles) && $request->hasFile('files')) {
            $fileArray = $request->file('files');
            if (is_array($fileArray)) {
                $uploadedFiles = $fileArray;
            } elseif ($fileArray) {
                $uploadedFiles = [$fileArray];
            }
        }

        foreach ($uploadedFiles as $file) {
            if ($file && $file->isValid() && $file->getSize() > 0) {
                try {
                    $path = $file->store('examinations', 'public');
                    $mimeType = $file->getMimeType();
                    $fileType = str_starts_with($mimeType, 'image/') ? 'image' : 'pdf';

                    $examination->files()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $mimeType,
                        'file_size' => $file->getSize(),
                        'file_type' => $fileType
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error saving file: ' . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', 'Müayinə uğurla əlavə edildi!');
    }

    public function destroy(Patient $patient, Examination $examination)
    {
        $examination->load('files');

        $files = $examination->files;

        foreach ($files as $file) {
            $filePath = $file->file_path;
            try {
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    $deleted = Storage::disk('public')->delete($filePath);
                    if ($deleted) {
                        Log::info("File deleted successfully: {$filePath}");
                    } else {
                        Log::warning("Failed to delete file: {$filePath}");
                    }
                } else {
                    Log::warning("File not found in storage (path: {$filePath})");
                }

            } catch (\Exception $e) {
                Log::error("Error deleting file {$filePath}: " . $e->getMessage());
            }
        }

        $examination->delete();

        return redirect()->back()->with('success', 'Müayinə uğurla silindi!');
    }
}
