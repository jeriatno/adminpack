<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasAttachments
{
    /**
     * Store attachments dynamically based on the model and request data.
     *
     * @param  Request  $request
     * @param  null  $number
     * @return array
     */
    public function attach($request, $number = null): array
    {
        $attachments = [];

        foreach ($this->attachmentFields as $field) {
            $file = $request->file($field);
            if ($file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $slug = Str::slug($originalName);
                $extension = $file->getClientOriginalExtension();

                // Initial file name
                $fileName = ($this->docNumberFile ?? $number) . '_' . $slug . '.' . $extension;

                // Check if file exists
                $fullPath = $this->storagePath . '/' . $fileName;
                if (Storage::disk('public')->exists($fullPath)) {
                    // Generate a unique ID
                    $uniqueId = now()->timestamp . Str::random(5);
                    $fileName = ($this->docNumberFile ?? $number) . '_' . $slug . '_' . $uniqueId . '.' . $extension;
                }

                // Save the file
                $path = $file->storeAs($this->storagePath, $fileName, 'public');

                // Attach to the field
                $attachments[$field] = [
                    'path' => $path,
                    'name' => $originalName . '.' . $extension,
                ];
            }
        }

        return $attachments;
    }

    /**
     * Accessor to get doc number
     * @return mixed|null
     */
    public function getDocNumberFileAttribute()
    {
        return $this->attributes[$this->docNo ?? 'doc_no'] ?? null;
    }
}

