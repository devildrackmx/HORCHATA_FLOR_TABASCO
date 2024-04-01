<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
    style="background-image: url('{{ asset('image/2.jpg') }}'); background-size: cover; background-position: center;">
    {{--  <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-black bg-opacity-60 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div> --}}

    <div class="container h-full">
        <div class="g-6 flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200">
            <div class="w-4/6">
                <div class="block rounded-lg bg-black bg-opacity-60 shadow-lg">
                    <div class="g-0 lg:flex lg:flex-wrap">
                        <!-- Left column container-->
                        <div class="px-4 md:px-0 lg:w-6/12">
                            <div class="md:mx-4 md:p-6">
                                <!--Logo-->
                                <div class="text-center">
                                    {{ $logo }}
                                </div>

                                <div>
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>

                        <!-- Right column container with background and description-->
                        <div class="flex items-center rounded-b-lg lg:w-6/12 lg:rounded-r-lg lg:rounded-bl-none"
                            style="background-image: url('{{ asset('image/2.jpg') }}'); background-size: cover; background-position: center;">
                            <div class="px-4
                            py-6 text-white md:mx-6 md:p-12">
                                {{-- <h4 class="mb-6 text-xl font-semibold">
                                    We are more than just a company
                                </h4>
                                <p class="text-sm">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing
                                    elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris nisi ut aliquip ex
                                    ea commodo consequat.
                                </p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
