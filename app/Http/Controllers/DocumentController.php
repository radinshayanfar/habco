<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Traits\ApiResponder;
use Illuminate\Contracts\Auth\Authenticatable;

class DocumentController extends Controller
{
    use ApiResponder;

    public function doctorEdit(DocumentRequest $request, Authenticatable $user)
    {
        $this->authorize('upload', Document::class);

        $request->validate([
            'file' => 'required',
            'file_type' => 'required',
        ]);

        $file = base64_decode($request->get('file'));

        if ($user->doctor->document_id !== null) {
            $user->doctor->document()->update(['file' => $file, 'file_type' => $request->file_type, 'verified' => false]);
        } else {
            $document = $user->doctor->document()->create(['file' => $file, 'file_type' => $request->file_type]);
            $user->doctor()->update(['document_id' => $document->id]);
        }

        return $this->success(new DocumentResource($user->doctor->document), 'Document uploaded');
    }

    public function adminEdit(DocumentRequest $request, Document $document)
    {
        $this->authorize('verify', Document::class);

        $request->validate([
            'verified' => 'required',
        ]);

        $document->verified = $request->verified;
        $document->verification_explanation = $request->input('verification_explanation', null);
        $document->save();

        return $this->success(new DocumentResource($document), 'Document ' . $document->verified ? 'verified' : 'unverified');
    }

    public function show(Document $document)
    {
        $this->authorize('show', $document);

        return response($document->file)
            ->header('Content-Type', $document->file_type);
    }
}
