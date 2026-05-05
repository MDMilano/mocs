<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

class KnowledgeBase extends Component
{
    #[Url(as: 'document')]
    public $documentId = null;

    public ?Document $activeDocument = null;

    public function mount()
    {
        $docs = $this->fetchDocuments();

        if ($this->documentId) {
            $this->activeDocument = $docs->firstWhere('id', $this->documentId);
        }
        
        if (!$this->activeDocument) {
            $this->activeDocument = $docs->first();
        }
    }

    private function fetchDocuments()
    {
        return Document::active()->orderBy('title')->get();
    }

    private function fetchGroupedDocuments($docs)
    {
        return collect([
            'Knowledge Base' => collect([
                'General Documents' => $docs
            ])
        ]);
    }

    public function selectDocument($documentId)
    {
        $docs = $this->fetchDocuments();
        $document = $docs->firstWhere('id', $documentId);
        
        if ($document) {
            $this->activeDocument = $document;
            $this->documentId = $document->id; 
            $this->dispatch('documentSelected');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $docs = $this->fetchDocuments();

        return view('knowledge-base', [
            'documents' => $docs,
            'groupedDocuments' => $this->fetchGroupedDocuments($docs),
        ]);
    }
}