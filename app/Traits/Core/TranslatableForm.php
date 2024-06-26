<?php

namespace App\Traits\Core;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;

trait TranslatableForm
{
      public  function removeIdSuffix($string) {
            // Use a regular expression to remove '_id' if it is at the end of the string
            return preg_replace('/_id$/', '', $string);
        }

    public function form(Form $form): Form
    {
        $components = [];
        foreach (parent::form($form)->getComponents() as $component){
            if($component->getChildComponents() == []){
                try {

                    $components[]=$component->label(trans('lang.'.$this->removeIdSuffix($component->getName())));
                }catch (\Exception $e){
                    $components[]=$this->checkComponent($component);
                }
            }else{
                $components[]=$this->checkComponent($component);
            }
        }
        return parent::form($form)->schema($components); // TODO: Change the autogenerated stub
    }

    public function checkComponent($component){
        if($component instanceof  Fieldset || $component instanceof Wizard\Step || $component instanceof Section|| $component instanceof Repeater||$component instanceof Builder\Block){
            $subComponents = [];
            foreach ($component->getChildComponents() as $subComponent){
                $subComponents[]=$this->checkComponent($subComponent);
            }
            return $component->label(trans('lang.'.$this->removeIdSuffix($component->getLabel())))
                ->schema($subComponents);
        }elseif($component instanceof  Group){
            $subComponents = [];
            foreach ($component->getChildComponents() as $subComponent){
                $subComponents[]=$this->checkComponent($subComponent);
            }
            return $component
                ->schema($subComponents);
        }elseif($component instanceof Tabs){
            $subComponents = [];
            foreach ($component->getChildComponents() as $subComponent){
                $subComponents[]=$this->checkComponent($subComponent);
            }
            return $component->label(trans('lang.'.$this->removeIdSuffix($component->getLabel())))
                ->tabs($subComponents);
        }elseif($component instanceof  Tabs\Tab){
            $subComponents = [];
            foreach ($component->getChildComponents() as $subComponent){
                $subComponents[]=$this->checkComponent($subComponent);
            }
            return $component->label(trans('lang.'.$this->removeIdSuffix($component->getLabel())))
                ->schema($subComponents);
        }elseif ($component instanceof Wizard || $component instanceof Split){
            $subComponents = [];
            foreach ($component->getChildComponents() as $subComponent){
                $subComponents[]=$this->checkComponent($subComponent);
            }
            return $component::make($subComponents);
        }
        elseif ($component instanceof Builder){
            $subComponents = [];
            foreach ($component->getChildComponents() as $subComponent){
                $subComponents[]=$this->checkComponent($subComponent);
            }
            return $component->blocks($subComponents);
        }elseif($component instanceof Placeholder){
            return $component;
        }
        return $component->label(trans('lang.'.$this->removeIdSuffix($component->getName()))); // TODO: Change the autogenerated stub
    }
}
