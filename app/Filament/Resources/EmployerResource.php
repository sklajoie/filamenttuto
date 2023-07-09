<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use App\Models\Employer;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployerResource\RelationManagers;
use App\Filament\Resources\EmployerResource\Widgets\EmployerStatsOverview;

class EmployerResource extends Resource
{
    protected static ?string $model = Employer::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    // protected static ?string $navigationGroup = 'System Management';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                Select::make('country_id')
                ->label('Country')
                ->options(Country::all()->pluck('name', 'id')->toArray())
                ->required()
                ->reactive()
                ->afterStateUpdated(fn (callable $set) =>$set('state_id', null)),
                // filtre en fonction du pays choisi
                Select::make('state_id')
                ->label("State")
                ->required()
                ->options( function (callable $get){
                    $country = Country::find($get('country_id'));
                    if(!$country){
                        return State::all()->pluck('name', 'id');
                    }
                    return $country->states->pluck('name', 'id');
                })
                ->reactive()
                ->afterStateUpdated(fn (callable $set) =>$set('city_id', null)),
                   // filtre en fonction de la ville choisie
                Select::make('city_id')
                ->label("City")
                ->required()
                ->options( function (callable $get){
                    $state = State::find($get('state_id'));
                    if(!$state){
                        return City::all()->pluck('name', 'id');
                    }
                    return $state->cities->pluck('name', 'id');
                }),
                // ->reactive()
                // ->afterStateUpdated(fn (callable $set) =>$set('city_id', null)),

                Select::make('department_id')
                ->relationship('department', 'name')->required(),
                TextInput::make('first_name')->required()->maxLength(255),
                TextInput::make('last_name')->required()->maxLength(255),
                TextInput::make('address')->required()->maxLength(255),
                TextInput::make('zip_code')->required()->maxLength(255),
                DatePicker::make('birth_date')->required(),
                DatePicker::make('date_hired')->required(),
                     ])
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('first_name')->sortable()->searchable(),
                TextColumn::make('last_name')->sortable()->searchable(),
                TextColumn::make('address')->sortable()->searchable(),
                // TextColumn::make('department.name')->sortable()->searchable(),
                TextColumn::make('birth_date')->date(),
                
            ])
            ->filters([
                SelectFilter::make('country')->relationship('country', 'name'),
                SelectFilter::make('state')->relationship('state', 'name'),
                SelectFilter::make('city')->relationship('city', 'name'),
                SelectFilter::make('department')->relationship('department', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
       
        return[
        EmployerStatsOverview::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployers::route('/'),
            'create' => Pages\CreateEmployer::route('/create'),
            'edit' => Pages\EditEmployer::route('/{record}/edit'),
        ];
    }    
}
