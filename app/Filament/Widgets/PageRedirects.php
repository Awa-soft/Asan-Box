<?php

namespace App\Filament\Widgets;

use Filament\Panel;
use Filament\Widgets\Widget;

class PageRedirects extends Widget
{
    protected int | string | array $columnSpan = 'full';
    public  $pages = [],$data = [];
    public function mount(){
        $panel = new Panel();
        $panel =  $panel  ->id('admin')
                    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
                     ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages');
        $pages = $panel->getPages();
        $resources = $panel->getResources();
        $data = array_merge($pages, $resources);
        foreach ($data as $dt){
            $dt = new $dt();
            try {
                if($dt::getNavigationGroup() == trans('POS/lang.group_label') && $dt::canAccess()){
                    $this->pages[] =[
                        'title'=>$dt::getNavigationLabel(),
                        'icon'=>$dt::getNavigationIcon(),
                        'url'=>$dt::getUrl(),
                        'group'=>$dt::getNavigationGroup(),
                        'sort'=>$dt::getNavigationSort()??0
                    ];
                }
            }catch (\Exception $e){
            }
        }
     $this->data =  collect($this->pages)->sortBy('sort')->groupBy('group');
    }
    protected static string $view = 'filament.widgets.page-redirects';
}
