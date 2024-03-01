<template>
  <div :class="[error ? '' : '', '']">
    <slot />
  </div>
</template>
<script>
export default {
  components: {

  },
  props: {
    error: {
      type: Boolean,
      default: null
    },
  }
}
</script>