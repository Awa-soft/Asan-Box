<?php

namespace App\Filament\Pages\Core;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Closure;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

class Settings extends \Outerweb\FilamentSettings\Filament\Pages\Settings
{
    public static function getNavigationLabel(): string
    {
        return trans('settings/lang.settings.plural_label');
    }
    public function getTitle(): string
    {
        return trans('settings/lang.settings.singular_label'); // TODO: Change the autogenerated stub
    }
    public static function getNavigationGroup(): ?string
    {
        return trans('settings/lang.group_label'); // TODO: Change the autogenerated stub
    }

    public function schema(): array|Closure
    {
        return [
            Tabs::make('settings')
                ->schema([
                    Tabs\Tab::make(trans('lang.system'))
                        ->schema([
                            TinyEditor::make('settings.installment_contract')
                                ->label(trans('lang.installment_contract'))
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->direction('auto|ltr|rtl'),
                            TinyEditor::make('settings.bill_of_exchange')
                                ->label(trans('lang.bill_of_exchange'))
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->direction('auto|ltr|rtl'),
                            TinyEditor::make('settings.pledge')
                                ->label(trans('lang.pledge'))
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->direction('auto|ltr|rtl'),
                        ]),
                    Tabs\Tab::make(trans('lang.contracts'))
                        ->schema([
                            TinyEditor::make('settings.installment_contract')
                                ->label(trans('lang.installment_contract'))
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->direction('auto|ltr|rtl'),
                            TinyEditor::make('settings.bill_of_exchange')
                                ->label(trans('lang.bill_of_exchange'))
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->direction('auto|ltr|rtl'),
                            TinyEditor::make('settings.pledge')
                                ->label(trans('lang.pledge'))
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsDirectory('uploads')
                                ->profile('default|simple|full|minimal|none|custom')
                                ->direction('auto|ltr|rtl'),
                        ]),
                ]),
        ];
    }
}
