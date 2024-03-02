<template>
  <div class="relative min-h-28 xl:min-h-32 w-full border-b border-black flex justify-start items-center leading-none pl-12">
    <label :for="id" class="text-xs xl:text-sm break-words hyphens-auto cursor-pointer flex items-center w-full">
      <input
        :id="id"
        type="radio"
        :value="modelValue"
        :placeholder="placeholder"
        :checked="$props.selected ? true : false"
        @input="updateInput"
        class="opacity-0 absolute cursor-pointer h-0 w-0"
      />
      <span class="block size-12 xl:size-16 rounded-full border-black border bg-white"></span>
      <div class="ml-8 xl:ml-12">
        <slot name="label"></slot>
      </div>
    </label>
  </div>
</template>
<script>

export default {
  name: "FormCheckbox",
  props: {
    
    id: {
      type: String,
      default: "",
    },
    
    modelValue: {
      type: [String, Number],
      default: "",
    },

    type: {
      type: String,
      default: "text",
    },

    placeholder: {
      type: String,
      default: "",
    },

    selected: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style scoped>
input[type="radio"]:checked ~ span {
  @apply bg-lemon
}
</style>
