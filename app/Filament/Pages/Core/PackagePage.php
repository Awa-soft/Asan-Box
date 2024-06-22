<?php

namespace App\Filament\Pages\Core;

<<<<<<< Updated upstream
use App\Filament\Widgets\Core\PackageOverview;
=======
>>>>>>> Stashed changes
use App\Models\Core\Package;
use App\Traits\Core\TranslatableForm;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use ZipArchive;

class PackagePage extends Page implements HasForms
{
    use  TranslatableForm;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public ?array $packageData = [];
    protected function getForms(): array
    {
        return [
            'packageForm',
        ];
    }

<<<<<<< Updated upstream
   


=======
>>>>>>> Stashed changes
    public function packageForm(Form $form): Form
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
        $data = $this->packageForm->getState();
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
        // Package::create(
        //     [
        //         'name' => $metadata['name'],
        //         'version' => $metadata['version'],
        //         'description' => $metadata['description'],
        //         'price' => $metadata['price'],
        //         'image' => "assets/img/$metadata[name].png",
        //         'type' => $metadata['type'],
        //         'status' => 1,
        //     ]
        // );

        // moving lang folder of temp to app lang folder if not exists inside lang folder then create lang folder inside lang folder
        if (!File::exists(base_path("lang/en/{$metadata['name']}"))) {
            File::makeDirectory(base_path("lang/en/{$metadata['name']}"));
        }
        if (!File::exists(base_path("lang/ckb/{$metadata['name']}"))) {
            File::makeDirectory(base_path("lang/ckb/{$metadata['name']}"));
        }
        File::moveDirectory(storage_path("app/public/temp/$metadata[name]/lang"), base_path("lang"));
        File::moveDirectory(storage_path("app/public/temp/$metadata[name]/lang"), base_path("lang"));
    }
    protected static string $view = 'filament.pages.core.package-page';
}
