<?php

use App\Models\Document;
use App\Models\User;
use App\Livewire\Member\KnowledgeBase;
use Livewire\Livewire;

test('it can load a document via slug in the URL', function () {
    $user = User::factory()->create();
    $document = Document::factory()->create([
        'title' => 'Test Document',
        'slug' => 'test-document',
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->withQueryParams(['document' => 'test-document'])
        ->test(KnowledgeBase::class)
        ->assertSet('documentSlug', 'test-document')
        ->assertSee($document->title);
});

test('it can select a document and update the slug', function () {
    $user = User::factory()->create();
    $doc1 = Document::factory()->create(['slug' => 'doc-1', 'is_active' => true]);
    $doc2 = Document::factory()->create(['slug' => 'doc-2', 'is_active' => true]);

    Livewire::actingAs($user)
        ->test(KnowledgeBase::class)
        ->call('selectDocument', 'doc-2')
        ->assertSet('documentSlug', 'doc-2')
        ->assertSee($doc2->title);
});

test('it falls back to the first document if the slug is invalid', function () {
    $user = User::factory()->create();
    $doc1 = Document::factory()->create(['slug' => 'first-doc', 'is_active' => true]);

    Livewire::actingAs($user)
        ->withQueryParams(['document' => 'invalid-slug'])
        ->test(KnowledgeBase::class)
        ->assertSet('activeDocument.id', $doc1->id)
        ->assertSee($doc1->title);
});
