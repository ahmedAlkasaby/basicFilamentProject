<?php

namespace App\Filament\Resources\TrashBuckets\Tables;

use App\Helpers\ModelHelper;
use App\Models\TrashBucket;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TrashBucketsTable
{
    public static function configure(Table $table): Table
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


                TextColumn::make('created_at')
                    ->label(__('site.deleted_at'))
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
            ])
            ->defaultSort(fn($query) => $query->orderBy('created_at', 'desc'))
             ->filters([
                SelectFilter::make('admin')
                    ->label(__('site.admin'))
                    ->relationship(
                        name: 'admin',
                        titleAttribute: 'id', 
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->searchable()
                    ->preload(),
                           
                SelectFilter::make('model_type')
                    ->label(__('site.model'))
                    ->options(ModelHelper::models())
                    ->searchable()
                    ->preload()
            ])
            ->recordActions([
                Action::make('restore')
                    ->label(__('site.restore'))
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->authorize(fn ($record) => auth()->user()->can('restore', $record))

                    ->action(function ($record) {
                        $modelClass = $record->model_type;
                        $modelId = $record->model_id;

                        if (class_exists($modelClass)) {
                            $modelInstance = $modelClass::withTrashed()->find($modelId);
                            if ($modelInstance) {
                                $modelInstance->restore();
                                $record->delete();
                            }
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('restore_any')
                        ->label(__('site.restore_selected'))
                        ->icon('heroicon-o-arrow-path')
                        ->requiresConfirmation()
                        ->authorize(fn () => auth()->user()->can('restoreAny', TrashBucket::class))

                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $modelClass = $record->model_type;
                                $modelId = $record->model_id;

                                if (class_exists($modelClass)) {
                                    $modelInstance = $modelClass::withTrashed()->find($modelId);
                                    if ($modelInstance) {
                                        $modelInstance->restore();
                                        $record->delete();
                                    }
                                }
                            }
                        }),
                ]),
            ]);
    }
}
