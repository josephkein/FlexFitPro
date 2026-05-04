
<header class="sticky top-0 z-39 flex justify-between items-center px-6 py-4 bg-white border-b-1 border-violet-200">
        <div class="flex">
            <span class="hidden md:flex text-3xl font-medium">Welcome,<span class="text-violet-800 ml-2 font-bold"><?= ucfirst($_SESSION['username'] ?? 'User') ?>!</span></span>
            <button id="burger" class="md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(128, 82, 246);"><rect width="18" height="1.5" x="3" y="7.001" fill="currentColor" rx=".75"></rect><rect width="15" height="1.5" x="3" y="11.251" fill="currentColor" rx=".75"></rect><rect width="18" height="1.5" x="3" y="15.499" fill="currentColor" rx=".75"></rect></svg>
            </button>
        </div>
        <div class="flex items-center gap-3">
            <span class="flex items-center justify-center rounded-full text-lg md:text-xl text-violet-800 font-bold p-2 md:p-3 bg-violet-200"><?= strtoupper($_SESSION['role'][0] . $_SESSION['role'][1]) ?></span>
            <div class="flex flex-col">
                <span class="text-lg md:text-xl"><?= ucfirst($_SESSION['username'] ?? 'User') ?></span>
                <span class="text-sm md:text-md text-gray-400"><?= ucfirst($_SESSION['role'] ?? 'User') ?></span>
            </div>
        </div>
</header>