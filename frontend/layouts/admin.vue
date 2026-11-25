<template>
  <div class="min-h-screen bg-[#060b18] text-white flex">
    <!-- Sidebar Admin -->
    <AdminSidebar />

    <!-- Main area -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Admin topbar -->
      <AdminTopbar />

      <!-- Page content -->
      <main class="flex-1 p-6 overflow-auto">
        <slot />
      </main>
    </div>

    <!-- Toast notifications -->
    <ToastContainer />
  </div>
</template>
