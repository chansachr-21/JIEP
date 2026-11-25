<template>
  <div class="min-h-screen bg-navy text-white flex flex-col">
    <!-- Navbar -->
    <AppNavbar />

    <!-- Main content -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- Footer -->
    <AppFooter />

    <!-- Toast notifications -->
    <ToastContainer />
  </div>
</template>
