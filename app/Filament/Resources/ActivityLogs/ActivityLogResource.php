<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ManageActivityLogs;
use App\Helpers\ModelHelper;
use App\Models\ActivityLog;
use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityLogResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = ActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'restore',
            'restore_any',
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('site.activity_logs');
    }

    public static function getModelLabel(): string
    {
        return __('site.activity_log');
    }

    public static function getPluralModelLabel(): string
    {
        return __('site.activity_log');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label(__('site.user'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model_type')
                    ->getStateUsing(fn($record) => $record->translateWithTableName())
                    ->label(__('site.model'))
                    ->sortable()
                    ->searchable(),



                TextColumn::make('action')
                    ->sortable()
                    ->badge()
                    ->label(__('site.action'))
                    ->color(fn(string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default   => 'gray',
                    }),


                TextColumn::make('created_at')
                    ->label(__('site.created_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->defaultSort(fn($query) => $query->orderBy('created_at', 'desc'))
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('admin')
                    ->label(__('site.admin'))
                    ->relationship(
                        name: 'admin',
                        titleAttribute: 'id',
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                    ->searchable()
                    ->preload(),
                SelectFilter::make('action')
                    ->label(__('site.action'))
                    ->options(ModelHelper::actions()),
                SelectFilter::make('model_type')
                    ->label(__('site.model'))
                    ->options(ModelHelper::models())
                    ->searchable()
                    ->preload()
            ])
            ->recordActions([

                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
                Action::make('viewChanges')
                    ->label(__('site.changes'))
                    ->icon('heroicon-o-eye')
                    ->visible(fn($record) => $record->action === 'updated')
                    ->modalHeading(__('site.changes'))
                    ->modalWidth('4xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('site.close'))
                    ->form(function ($record) {
                        $changes = $record->changes ?? [];
                        $modelClass = $record->model_type;
                        $model = class_exists($modelClass) ? $modelClass::find($record->model_id) : null;

                        if (is_string($changes)) {
                            $changes = json_decode($changes, true) ?? [];
                        }

                        $data = collect($changes)->map(function ($values, $attribute) use ($record, $model) {
                            return [
                                'attribute' => \Illuminate\Support\Str::headline($attribute),
                                'old' => $record->formatChangeValue($model, $attribute, $values['old'] ?? '-'),
                                'new' => $record->formatChangeValue($model, $attribute, $values['new'] ?? '-'),
                            ];
                        })->values()->toArray();

                        return [
                            \Filament\Forms\Components\Repeater::make('changes')
                                ->schema([
                                    \Filament\Forms\Components\TextInput::make('attribute')
                                        ->label(__('site.attribute'))
                                        ->disabled(),
                                    \Filament\Forms\Components\TextInput::make('old')
                                        ->label(__('site.before'))
                                        ->disabled()
                                        ->extraAttributes(['class' => 'text-red-600']),
                                    \Filament\Forms\Components\TextInput::make('new')
                                        ->label(__('site.after'))
                                        ->disabled()
                                        ->extraAttributes(['class' => 'text-green-600 font-semibold']),
                                ])
                                ->default($data)
                                ->disableItemCreation()
                                ->disableItemDeletion()
                                ->disableItemMovement()
                                ->columns(3),
                        ];
                    })



            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageActivityLogs::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
