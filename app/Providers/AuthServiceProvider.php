<?php

namespace App\Providers;


use App\Models;
use App\Policies;
use Closure;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ProvidersAuthServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class AuthServiceProvider  extends ProvidersAuthServiceProvider
{

    public function generatePolicyArray(): array
    {
        $modelsDirectory = app_path('Models');
        $array = [];
            $files = File::allFiles($modelsDirectory);
            foreach ($files as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $relativePath = str_replace([$modelsDirectory, '.php', DIRECTORY_SEPARATOR], ['', '', '\\'], $file->getPathname());
                    $className = Str::beforeLast($file->getFilename(), '.php');
                    $namespace = rtrim(str_replace('/', '\\', $relativePath), '\\');
                    $policyClassName = "App\\Policies{$namespace}Policy";
                    if (class_exists($policyClassName)) {
                        $array["App\\Models$namespace"] = "$policyClassName";
                    }
                }
            }
        return $array;
    }


    public function register()
    {
        $this->booting(function () {
            $this->policies = $this->generatePolicyArray();
            $this->registerPolicies();
        });
    }



}
