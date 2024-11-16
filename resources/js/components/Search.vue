<template>
  <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4">
    <label for="table-search" class="sr-only">Search</label>
    <div class="relative">
      <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-common" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
      </div>
      <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-common border border-common rounded-lg w-96 bg-transparent focus:ring-gray-400 focus:border-gray-400" placeholder="Search for Products">
    </div>
  </div>
</template>
