<aside id="default-sidebar"
    class="{{-- fixed top-0 left-0 z-40 --}} sticky top-0 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <h2 class=" text-3xl mb-6 font-semibold text-white dark:text-white"><a href="/">DevsCode</a>
        </h2>
        <ul class="space-y-2">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['url'] }}"
                        class="flex items-center p-2 text-base font-normal text-gray-100 rounded-lg hover:bg-gray-700 {{ $link['active'] ? 'bg-gray-700' : '' }}">
                       {{--  <svg aria-hidden="true"
                            class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg> --}}
                        <span style="color: white" class="w-6 h-6 text-gray-500">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                        <span class="ml-3">{{ $link['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
