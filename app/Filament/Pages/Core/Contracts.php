<?php

namespace App\Filament\Pages\Core;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Traits\Core\OwnerableTrait;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Components\Tab;
use Filament\Resources\Concerns\HasTabs;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Session;

class Contracts extends Page implements HasForms
{
    use InteractsWithForms;
    use OwnerableTrait;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public $activeTab = 'installment_contract';



    public $data = [];


    protected function getHeaderActions(): array
    {
        return [
          Action::make('print')
            ->label(trans('lang.print'))
              ->icon('heroicon-o-printer')
                ->action(function(){
                        $data = $this->form->getState();
                        Session::put('contracts_data',$data['content']);
                        return $this->redirect(route('print.contracts'));
                })
        ];
    }

    public function changeTab($tab):void{
        $this->data['content'] = setting('settings.'. $tab);
        $this->activeTab = $tab;
        static::$title = trans('lang.'.$this->activeTab);
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TinyEditor::make('content')
                    ->label(trans('lang.'.$this->activeTab))
                    ->hiddenLabel()
                    ->fileAttachmentsDisk('public')
                    ->default(setting('settings.installment_contract'))
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->direction('auto|ltr|rtl'),
            ])->statePath('data');
    }
    public function mount(){
        $this->form->fill();
    }

    protected static string $view = 'filament.pages.core.contracts';
}
