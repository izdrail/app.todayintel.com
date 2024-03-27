<?php

namespace App\Filament\Actions;

use App\Models\Network;
use Closure;
use Filament\Actions\StaticAction;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @todo make this implement agent contract

 */
class Share extends Action
{
    public Collection $accounts;
    protected ?Closure $mutateRecordDataUsing = null;

    public function __invoke(Model $record): void
    {
        $this->handle($record);
    }

    public static function make(?string $name = null): static
    {
        return new static();


    }




    public function __construct()
    {
        $this->accounts = collect();
        $this->setUp();
    }

    public static function getDefaultName(): ?string
    {
        return 'view';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Share'));

        $this->modalHeading(fn (): string => __('filament-actions::view.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitAction(false);

        $this->modalCancelAction(fn (StaticAction $action) => $action->label(__('Cancel')));

        $this->color('gray');

        $this->icon(FilamentIcon::resolve('heroicon-o-share'));

       // $this->disabledForm();


    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }

    public function fillForm(Closure $callback): static
    {
        $this->fillForm = $callback;

        return $this;
    }

    public function getRecordTitle(?Model $record = null): string
    {
        return $this->record->getKey();
    }




}
