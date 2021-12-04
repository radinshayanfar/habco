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

    public function store(DocumentRequest $request, Authenticatable $user)
    {
        $this->authorize('upload', Document::class);

        $role = $user->role;
        if ($role == 'pharmacist') {
            $request->validate(['type' => 'not_in:document']);
        }

        $request->validate([
            'file' => 'required',
            'file_type' => 'required',
            'type' => 'required',
        ]);

        $file = base64_decode($request->get('file'));
        $type = $request->type;
        $type_id = $type . '_id';

        if ($user->$role->$type_id !== null) {
            $user->$role->$type()->update(['file' => $file, 'file_type' => $request->file_type, 'verified' => false]);
        } else {
            $document = $user->$role->$type()->create(['file' => $file, 'file_type' => $request->file_type]);
            $user->$role()->update([$type_id => $document->id]);
            $user->refresh();
        }

        return $this->success(new DocumentResource($user->$role->$type), 'Uploaded');
    }

    public function adminUpdate(DocumentRequest $request, Document $document)
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
