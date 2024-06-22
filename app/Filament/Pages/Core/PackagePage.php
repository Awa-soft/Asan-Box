<?php

namespace App\Filament\Pages\Core;

use App\Filament\Widgets\Core\PackageOverview;
use App\Models\Core\Package;
use App\Traits\Core\TranslatableForm;
use App\Traits\Core\TranslatableTable;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use ZipArchive;

class PackagePage extends Page implements HasForms, HasTable
{
    use  TranslatableForm,  InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public ?array $packageData = [];
    public $packages;
    protected function getForms(): array
    {
        return [
            'uploadPackageForm',

        ];
    }

    public function mount()
    {
        $this->packages = packages();
        $this->uploadPackageForm->fill();
    }

    public function table(Table $table) :Table{
        return $table
        ->query(Package::query())
        ->columns([
            TextColumn::make('name')
            ->label(trans("lang.name")),
            TextColumn::make('version')
            ->toggleable(isToggledHiddenByDefault: true)
            ->label(trans("lang.version")),
            TextColumn::make('description')
            ->toggleable(isToggledHiddenByDefault: true)
            ->label(trans("lang.description")),
            TextColumn::make('price')
            ->label(trans("lang.price"))
            ->numeric(2)
            ->suffix(" $"),
            TextColumn::make('type')
            ->label(trans("lang.type"))
            ->badge()
            ->color(fn($state)=>$state=="Primary"?"primary":Color::Gray),
            ColorColumn::make('color')
            ->label(trans("lang.color")),
            ToggleColumn::make('status')
            ->label(trans("lang.status"))
            ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('created_at')
            ->label(trans("lang.created_at"))
            ->label(trans("lang.active_date"))
            ->date("Y-m-d"),
        ]);
    }


    public function uploadPackageForm(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('package')
                    ->required()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName()),
                    )
                    ->directory('temp')

            ])
            ->statePath('packageData')
            ->model(Package::class);
    }

    public function uploadPackage()
    {
        $data = $this->uploadPackage->getState();
        $dir_name = explode('.', explode('/', $data['package'])[1])[0];
        // extract package zip into same place
        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/public/' . $data['package']));
        if ($res === TRUE) {
            $zip->extractTo(storage_path('app/public/temp'));
            $zip->close();
            // delete package zip
            File::delete(storage_path('app/public/' . $data['package']));
        }

        // read metdata.json file
        $metadata = json_decode(file_get_contents(storage_path("app/public/temp/$dir_name/metadata.json")), true);
        Package::updateOrCreate(
            [
                'name' => $metadata['name'],
            ],
            [
                'name' => $metadata['name'],
                'version' => $metadata['version'],
                'description' => $metadata['description'],
                'price' => $metadata['price'],
                'image' => "assets/img/packages/$metadata[name].png",
                'type' => $metadata['type'],
                "color" => $metadata['color'],
                'status' => 1,
            ]
        );

        // moving lang folder of temp to app lang folder if not exists inside lang folder then create lang folder inside lang folder
        if (!File::exists(base_path("lang/en/{$metadata['name']}"))) {
            File::makeDirectory(base_path("lang/en/{$metadata['name']}"));
        }
        if (!File::exists(base_path("lang/ckb/{$metadata['name']}"))) {
            File::makeDirectory(base_path("lang/ckb/{$metadata['name']}"));
        }
        if (!File::exists(public_path("assets/img/packages"))) {
            File::makeDirectory(public_path("assets/img/packages"));
        }
        File::copyDirectory(storage_path("app/public/temp/$dir_name/lang"), base_path("lang"));
        File::copyDirectory(storage_path("app/public/temp/$dir_name/lang"), base_path("lang"));
        File::copyDirectory(storage_path("app/public/temp/$dir_name/filament/resources/$metadata[name]"), app_path("Filament/Resources/$metadata[name]"));
        File::copyDirectory(storage_path("app/public/temp/$dir_name/filament/resources/$metadata[name]"), app_path("Filament/Resources/$metadata[name]"));
        File::copyDirectory(storage_path("app/public/temp/$dir_name/models/$metadata[name]"), app_path("Models/$metadata[name]"));
        File::copyDirectory(storage_path("app/public/temp/$dir_name/migrations/$metadata[name]"), base_path("database/migrations/$metadata[name]"));
        File::copy(storage_path("app/public/temp/$dir_name/$metadata[name].png"), public_path("assets/img/packages/$metadata[name].png"));
        File::deleteDirectory(storage_path("app/public/temp"));
        $this->uploadPackage->fill();
    }
    protected static string $view = 'filament.pages.core.package-page';
}
