<div class="flex">
    <aside id="sidebar"
        class="font-poppins fixed inset-y-0 my-6 ml-4 w-full max-w-72 md:max-w-60 xl:max-w-64 2xl:max-w-64 z-50 rounded-lg bg-white overflow-y-auto transform transition-transform duration-300 -translate-x-full md:translate-x-0 ease-in-out shadow-xl">
        <div class="p-2">
            <div class="p-4">
                <a href="{{ route('dashboard') }}">
                    <div class="w-32 md:w-28 xl:w-32 2xl:w-32 h-auto flex items-center mx-auto">
                        <img
                            src="{{ asset('logo.png') }}"
                            alt="Wimala Land"
                            class="w-full h-auto object-contain"
                        >
                    </div>
                </a>
            </div>

            <hr class="mx-5 shadow-2xl text-gray-100 rounded-xl" />

            <ul>
                <!-- Dashboard -->
                <li class="p-4 mx-2">
                    <a href="{{ route('dashboard') }}">
                        <div class="flex space-x-4">
                            <div class="bg-sky-600 p-2 rounded-xl">
                                <i class="material-icons text-white">home</i>
                            </div>
                            <div class="my-auto">
                                <h1 class="{{ request()->routeIs('dashboard') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                                    Dashboard
                                </h1>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="p-4 mx-2">
                    <div class="flex space-x-4">
                        <div class="bg-sky-600 p-2 rounded-xl">
                            <i class="material-icons text-white">dataset</i>
                        </div>
                        <div class="my-auto">
                            <h1 class="text-black text-base font-normal">
                                Master Data
                            </h1>
                        </div>
                    </div>
                </li>

                <hr class="mx-5 shadow-2xl text-gray-100 rounded-xl" />

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="#">
                        <h1 class="text-gray-500 hover:text-black text-base font-normal">
                            Proyek &amp; Cluster
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="{{ route('tipe.index') }}">
                        <h1 class="{{ request()->routeIs('tipe.*') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                            Tipe Rumah
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="{{ route('units.index') }}">
                        <h1 class="{{ request()->routeIs('units.*') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                            Data Unit
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="{{ route('buyers.index') }}">
                        <h1 class="{{ request()->routeIs('buyers.*') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                            Pembeli
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="#">
                        <h1 class="text-gray-500 hover:text-black text-base font-normal">
                            Bank Rekanan
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="#">
                        <h1 class="text-gray-500 hover:text-black text-base font-normal">
                            Marketing
                        </h1>
                    </a>
                </li>

                <!-- Penjualan -->
                <li class="p-4 mx-2">
                    <div class="flex space-x-4">
                        <div class="bg-sky-600 p-2 rounded-xl">
                            <i class="material-icons text-white">sell</i>
                        </div>
                        <div class="my-auto">
                            <h1 class="text-black text-base font-normal">
                                Penjualan
                            </h1>
                        </div>
                    </div>
                </li>

                <hr class="mx-5 shadow-2xl text-gray-100 rounded-xl" />

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="{{ route('pipeline.index') }}">
                        <h1 class="{{ request()->routeIs('pipeline.*') || request()->routeIs('transactions.*') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                            Tracking Penjualan
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="#">
                        <h1 class="text-gray-500 hover:text-black text-base font-normal">
                            Pengajuan KPR
                        </h1>
                    </a>
                </li>

                <!-- Keuangan -->
                <li class="p-4 mx-2">
                    <div class="flex space-x-4">
                        <div class="bg-sky-600 p-2 rounded-xl">
                            <i class="material-icons text-white">payments</i>
                        </div>
                        <div class="my-auto">
                            <h1 class="text-black text-base font-normal">
                                Keuangan
                            </h1>
                        </div>
                    </div>
                </li>

                <hr class="mx-5 shadow-2xl text-gray-100 rounded-xl" />

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="{{ route('invoices.index') }}">
                        <h1 class="{{ request()->routeIs('invoices.*') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                            Invoice &amp; Pembayaran
                        </h1>
                    </a>
                </li>

                <li class="p-4 mx-2 ml-16 md:ml-14">
                    <a href="{{ route('kas.index') }}">
                        <h1 class="{{ request()->routeIs('kas.*') ? 'text-sky-700 font-semibold' : 'text-gray-500 hover:text-black' }} text-base font-normal">
                            Kas Masuk / Keluar
                        </h1>
                    </a>
                </li>

                <!-- Laporan -->
                <li class="p-4 mx-2">
                    <a href="#">
                        <div class="flex space-x-4">
                            <div class="bg-sky-600 p-2 rounded-xl">
                                <i class="material-icons text-white">bar_chart</i>
                            </div>
                            <div class="my-auto">
                                <h1 class="text-gray-500 hover:text-black text-base font-normal">
                                    Laporan
                                </h1>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Manajemen User -->
                <li class="p-4 mx-2">
                    <a href="#">
                        <div class="flex space-x-4">
                            <div class="bg-sky-600 p-2 rounded-xl">
                                <i class="material-icons text-white">manage_accounts</i>
                            </div>
                            <div class="my-auto">
                                <h1 class="text-gray-500 hover:text-black text-base font-normal">
                                    Manajemen User
                                </h1>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Pengaturan -->
                <li class="p-4 mx-2">
                    <a href="#">
                        <div class="flex space-x-4">
                            <div class="bg-sky-600 p-2 rounded-xl">
                                <i class="material-icons text-white">settings</i>
                            </div>
                            <div class="my-auto">
                                <h1 class="text-gray-500 hover:text-black text-base font-normal">
                                    Pengaturan
                                </h1>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Logout -->
                <li class="p-4 mx-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <div class="flex space-x-4">
                            <div class="bg-sky-600 p-2 rounded-xl">
                                <i class="material-icons rotate-180 text-white">logout</i>
                            </div>
                            <button type="submit" class="text-gray-500 hover:text-black text-base font-normal">
                                Keluar
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </aside>
</div>
