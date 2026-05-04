<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document Details')
                    ->description('Fill in the document details below')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(4)
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->columnSpan(2),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->readOnly()
                                    ->helperText('This field is auto-generated from the Title.')
                                    ->columnSpan(1),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText('Inactive documents are hidden from the Knowledge Base and Search.')
                                    ->columnSpan(1),
                            ]),

                        RichEditor::make('content')
                            ->label('Procedure Content')
                            ->required()
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public') 
                            ->fileAttachmentsDirectory('knowledge-base-images') 
                            ->fileAttachmentsVisibility('public')
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'textColor', 'highlight', 'clearFormatting'],
                                [
                                    ToolbarButtonGroup::make('Format', ['paragraph', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'])
                                        ->textualButtons()
                                ],
                                [
                                    ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])
                                        ->textualButtons()
                                ],
                                ['bulletList', 'orderedList', 'blockquote', 'codeBlock'],
                                ['grid', 'details', 'table', 'link', 'attachFiles'],
                                ['undo', 'redo'],
                            ])
                            ->floatingToolbars([
                                'paragraph' => [
                                    'bold', 'italic', 'underline', 'textColor', 'highlight', 'link',
                                ],
                                'heading' => [
                                    'h1', 'h2', 'h3', 'h4',
                                ],
                                'grid' => [
                                    'gridDelete',
                                ],
                                'table' => [
                                    'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn',
                                    'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow',
                                    'tableMergeCells', 'tableSplitCell',
                                    'tableToggleHeaderRow',
                                    'tableDelete',
                                ],
                            ])
                    ])
            ]);
    }
}
