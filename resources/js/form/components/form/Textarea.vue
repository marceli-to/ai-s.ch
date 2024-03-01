<template>
  <textarea
    :id="id"
    :type="type"
    :value="modelValue"
    :placeholder="placeholder"
    @input="updateInput"
    :class="[$props.error ? 'bg-rosewater' : 'bg-cloud-mist', 'border-0 ring-0 focus:ring-0 px-8 md:px-10 py-12 md:py-15 xl:py-20 min-h-[150px] w-full text-base md:text-md xl:text-lg placeholder:text-xxs md:placeholder:text-xs xl:placeholder:text-sm placeholder:leading-none placeholder:text-midnight']">
  </textarea>
</template>
<script>
export default {
  name: "FormTextarea",
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