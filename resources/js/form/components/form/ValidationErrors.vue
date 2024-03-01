<template>
  <h2 class="mt-18 xl:mt-24 text-xs md:text-sm text-ruby leading-6">Es sind Fehler aufgetreten, bitte überprüfen Sie ihre Angaben:</h2>
</template>
<script>
export default {
  props: {
    validationErrors: {
      type: Array,
      default: () => []
    }
  }
}
</script>