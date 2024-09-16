<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Settings;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;

use App\Filament\Resources\SettingsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SettingsResource\RelationManagers;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        $record = $form->getRecord(); // Get the current model record
        $recordId = $record ? $record->id : null; // Get the record ID if it exists
        return $form

            ->schema([
                Card::make()->schema([
                    Wizard::make([
                        Wizard\Step::make('basicinformation')
                            ->label(__('filament.Basic Information'))
                            ->schema([
                                TextInput::make('sitename')
                                    ->label(__('filament.Site_Name'))
                                    ->required(),

                                TextInput::make('hotline')
                                    ->label(__('filament.Hotline Number'))
                                    ->rules([
                                        'min:1',
                                        Rule::unique('settings', 'hotline')
                                            ->ignore($recordId), // Ignore the current record's ID
                                    ]),

                                Repeater::make('phone')
                                    ->label(__('filament.phone'))
                                    ->schema([
                                        TextInput::make('phone')
                                            ->label(__('filament.phone'))
                                            ->required(),

                                    ])
                                    ->columns(3),


                                TextInput::make('email')
                                    ->label(__('filament.email'))
                                    ->email()
                                    ->rules([
                                        'email',
                                    ]),


                                Repeater::make('address')
                                    ->label(__('filament.Address'))
                                    ->schema([
                                        TextInput::make('locatioNname')
                                            ->label(__('filament.Location name'))
                                            ->required(),
                                        TextInput::make('locationDetails')
                                            ->label(__('filament.Location Details'))
                                            ->required(),
                                        Repeater::make('hotline')
                                        ->label(__('filament.hotline'))
                                            ->schema([
                                                TextInput::make('hotline')
                                                    ->label(__('filament.hotline'))
                                                    ->required(),
                                            ])
                                            ->columns(1),
                                    ])
                                    ->columns(3),
                            ]),

                        Wizard\Step::make('socialmedia')
                            ->label(__('filament.Social Media'))
                            ->schema([
                                Repeater::make('social_midea')
                                    ->label(__('filament.Social Media'))
                                    ->schema([
                                        TextInput::make('platform')
                                            ->label(__('filament.Platform')),
                                        TextInput::make('url')
                                            ->label(__('filament.URL')),
                                        TextInput::make('icon')
                                            ->label(__('filament.Icon')),
                                    ])
                                    ->columns(3),
                            ]),

                        Wizard\Step::make('media')
                            ->label(__('filament.Media'))
                            ->schema([
                                FileUpload::make('logo')
                                    ->label(__('filament.Logo'))
                                    ->image() // Validate as an image
                                    ->maxSize(2048) // Max size 2MB
                                    ->required()
                                    ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048']) // Additional validation rules
                                    ->directory('Logo'),

                                FileUpload::make('favicon')
                                    ->label(__('filament.Favicon'))
                                    ->image()
                                    ->maxSize(1000) // Max size 512KB
                                    ->required()
                                    ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:512'])
                                    ->directory('Favicon'),

                                FileUpload::make('hotline_img')
                                    ->label(__('filament.Hotline Image'))
                                    ->image()
                                    ->maxSize(3000)
                                    ->required()
                                    ->rules(['mimes:jpeg,png,jpg,gif,svg,webp', 'max:512'])
                                    ->directory('Hotline_Img'), // Updated directory to match the field
                            ]),
                    ])->skippable(),
                ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sitename')
                    ->label(__('filament.Site_Name')),

                TextColumn::make('hotline')
                    ->label(__('filament.Hotline Number')),

                ImageColumn::make('logo')  // Display the logo image
                    ->label(__('filament.Logo')),

                ImageColumn::make('favicon')  // Display the favicon image
                    ->label(__('filament.Favicon')),

                ImageColumn::make('hotline_img')  // Display the hotline image
                    ->label(__('filament.Hotline Image')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSettings::route('/create'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
        ];
    }

    //  لاخفاء زرار الاضافة بعد اضافه اول صف فى الداتا بيز
    public static function canCreate(): bool
    {
        return Settings::count() === 0;
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.Settings');
    }

    // start tranlation of models
    public static function getNavigationLabel(): string
    {
        return __('filament.Settings');
    }
    public static function getPluralLabel(): string
    {
        return  __('filament.Settings');
    }
    public static function getModelLabel(): string
    {
        return  __('filament.Settings');
    }

    public static function getNavigationSort(): ?int
    {
        return 9;
    }

}
