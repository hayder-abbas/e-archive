<template>
  <footer
    class="text-center text-sm text-primary border-t border-sidebar-border/70 p-6 md:px-4"
  >
    &copy; {{ new Date().getFullYear() }} - {{ $t("footer.author_name") }}
  </footer>
</template>
