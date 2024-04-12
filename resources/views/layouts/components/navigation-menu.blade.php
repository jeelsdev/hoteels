@props(['icon' => '', 'links' => ['#' => 'Demos']])

<nav class="z-30 bg-gray-50 lg:ml-56 shadow-md">
    <div class="py-3 px-3 lg:px-5 lg:pl-8">
      <div class="flex justify-between items-center">
        <div class="flex justify-start items-center">
          <button id="toggleSidebarMobileSearch" type="button" class="p-2 text-gray-500 rounded-2xl lg:hidden hover:text-gray-900 hover:bg-gray-100">
            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </button>
          <div class="hidden lg:flex items-center">
            <div>
              <ul>
                @foreach ($links as $link => $value)
                  <li><a href="{{ $link !== '#' ? route($link):$link }}">{{ $value }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="flex lg:hidden items-center">
          <div>
            <ul>
              @foreach ($links as $link => $value)
                <li><a href="{{ $link !== '#' ? route($link):$link }}">{{ $value }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="flex items-center">
            <a href="#">Dash</a>
        </div>
      </div>
    </div>
</nav>