<x-filament-widgets::widget>
    <div class="grid my-4 grid-cols-1 gap-6 lg:grid-cols-3 xl:grid-cols-4">
    @foreach($data as $key=>$dt)
                   @foreach($dt as $page)
                      <a wire:navigate href="{{$page['url']}}" class="w-full bg-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 transition-all duration-200 rounded-md dark:bg-gray-800  ">
                        <div class="flex items-center gap-4  align-middle">
                                <div class="p-4 rounded-s-md bg-gray-300 dark:bg-gray-700">
                                    @svg($page['icon'],'w-14 h-14 text-primary-500')
                                </div>
                            <div class="uppercase text-lg">
                                <div class="text-sm opacity-50 capitalize">
                                    {{$page['group']}}
                                </div>
                                {{$page['title']}}

                            </div>
                        </div>
                      </a>
                   @endforeach
        @endforeach
    </div>
</x-filament-widgets::widget>
