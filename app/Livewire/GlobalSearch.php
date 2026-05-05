<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class GlobalSearch extends Component
{
    public $query = '';

    #[Computed]
    public function results()
    {
        $searchTerm = trim($this->query);

        if (strlen($searchTerm) < 3) {
            return [];
        }

        $user = Auth::user();
        if (!$user) return [];

        $documents = Document::active()->get();
        $results = [];
        $searchTerm = strtolower($searchTerm);

        // Search logic
        foreach ($documents as $doc) {
            $matchedHeadings = [];
            $titleMatches = str_contains(strtolower($doc->title), $searchTerm);

            if (is_array($doc->toc)) {
                foreach ($doc->toc as $heading) {
                    if (str_contains(strtolower($heading['text']), $searchTerm)) {
                        $matchedHeadings[] = $heading;
                    }
                }
            }

            if ($titleMatches || count($matchedHeadings) > 0) {
                $results[] = [
                    'id' => $doc->id,
                    'slug' => $doc->slug,
                    'title' => $doc->title,
                    'headings' => $matchedHeadings
                ];
            }
        }

        return $results;
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}