<template>
  <input
    :id="id"
    :type="type"
    :value="modelValue"
    :placeholder="placeholder"
    @input="updateInput"
    :class="[$props.error ? 'bg-ruby text-white placeholder:text-white' : 'bg-silver', 'outline-none text-xs md:text-sm !border-0 ring-0 focus:ring-0 py-4 leading-none px-8 w-full placeholder:leading-none placeholder:text-graphite']"
  />
</template>
<script>
export default {
  name: "FormInput",
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

    error: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    updateInput(event) {
      this.$emit("update:modelValue", event.target.value);
    }
  }
};
</script>