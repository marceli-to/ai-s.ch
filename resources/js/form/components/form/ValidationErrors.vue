<template>
  <h2 class="text-xs xl:text-sm text-ruby leading-5 xl:leading-6">Es sind Fehler aufgetreten, bitte überprüfen Sie ihre Angaben:</h2>
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