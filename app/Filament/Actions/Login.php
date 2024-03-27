<?php

namespace App\Filament\Actions;

use Filament\Support\Contracts\TranslatableContentDriver;
use Closure;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class Login extends Action
{

    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
        return 'view';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Login'));


        $this->icon(FilamentIcon::resolve('actions::view-action') ?? 'heroicon-o-lock-closed');
        $this->color('blue');
       // $this->disabledForm();

        $this->fillForm(function (Model $model, Table $table): array {
            if (($translatableContentDriver = $table->makeTranslatableContentDriver()) instanceof TranslatableContentDriver) {
                $data = $translatableContentDriver->getRecordAttributesToArray($model);
            } else {
                $data = $model->attributesToArray();
            }

            if ($this->mutateRecordDataUsing instanceof Closure) {
                $data = $this->evaluate($this->mutateRecordDataUsing, ['data' => $data]);
            }

            return $data;
        });

        $this->action(static function (): void {
            //
        });
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
