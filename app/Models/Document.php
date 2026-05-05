<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'toc',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'toc' => 'array',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active documents.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Function to generate UUIDs for the 'uuid' column
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected static function booted()
    {
        // This runs automatically every time you Create or Update a document in Filament
        static::saving(function ($document) {
            
            if (empty($document->content)) {
                $document->toc = [];
                return;
            }

            $toc = [];
            $html = $document->content;

            // Use Regex to find all <h1>, <h2>, <h3>, <h4> tags in the Rich Editor
            $html = preg_replace_callback('/<(h[1-4])([^>]*)>(.*?)<\/\1>/is', function ($matches) use (&$toc) {
                $tag = $matches[1]; // e.g., h1
                $attributes = $matches[2]; // Any existing styles from Filament
                $innerHtml = $matches[3]; 
                
                // Clean the text for the menu
                $text = trim(strip_tags($innerHtml));
                
                // Generate a clean, URL-friendly ID (e.g., "update-agm-date")
                $id = Str::slug($text);
                if (empty($id)) {
                    $id = 'section-' . uniqid();
                }

                // Remove any existing ID to prevent duplicates
                $attributes = preg_replace('/id="[^"]*"/', '', $attributes);

                // Add it to our database array
                $toc[] = [
                    'id' => $id,
                    'text' => $text,
                    'level' => strtoupper($tag),
                ];

                // Rebuild the HTML tag WITH the new ID injected inside it
                return "<{$tag} id=\"{$id}\"{$attributes}>{$innerHtml}</{$tag}>";
            }, $html);

            // Save the modified HTML and the new TOC array
            $document->content = $html;
            $document->toc = $toc;
        });
    }
}
