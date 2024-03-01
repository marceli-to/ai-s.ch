<template>
  <li class="flex flex-col justify-center">
    <a 
      href="javascript:;" 
      class="menu-item border-b border-t border-black flex"
      @click.prevent="toggleForm('member')">
      <template v-if="hasMemberForm">&downarrow;</template>
      <template v-else>&rightarrow;</template>
      <span class="block pl-8">Mitglied werden</span>
    </a>
    <template v-if="hasMemberForm">
      <template v-if="isSent">
        <feedback />
      </template>
      <validation-errors :validationErrors="validationErrors"  v-if="validationErrors.length > 0" />
      <form class="flex flex-col gap-y-8 my-18 xl:my-24">
        <form-input 
          type="text" 
          v-model="form.firstname" 
          placeholder="Vorname"
          :error="errors.firstname"
          @focus="removeError('firstname')">
        </form-input>
        <form-input 
          type="text" 
          v-model="form.name" 
          placeholder="Name"
          :error="errors.name"
          @focus="removeError('name')">
        </form-input>
        <form-input 
          type="text" 
          v-model="form.email" 
          placeholder="E-Mail"
          :error="errors.email"
          @focus="removeError('email')">
        </form-input>
        <form-group class="flex justify-end w-full">
          <button 
            :class="[isLoading ? 'bg-silver pointer-events-none select-none' : '', 'bg-lemon text-xs md:text-sm text-black py-6 px-10 leading-none inline-flex items-center w-auto text-left']"
            type="button"
            @click.prevent="submit('member')">
            absenden
          </button>
        </form-group>
      </form>
    </template>
  </li>

  <li class="flex flex-col justify-center">
    <a 
      href="javascript:;" 
      :class="[hasMemberForm ? 'border-t border-black' : '', 'menu-item border-b border-black flex']"
      @click.prevent="toggleForm('newsletter')">
      <template v-if="hasNewsletterForm">&downarrow;</template>
      <template v-else>&rightarrow;</template>
      <span class="block pl-8">Newsletter</span>
    </a>
    <template v-if="hasNewsletterForm">
      <template v-if="isSent">
        <feedback />
      </template>
      <validation-errors :validationErrors="validationErrors"  v-if="validationErrors.length > 0" />
      <form class="flex flex-col gap-y-8 my-18 xl:my-24">
        <form-input 
          type="text" 
          v-model="form.firstname" 
          placeholder="Vorname"
          :error="errors.firstname"
          @focus="removeError('firstname')">
        </form-input>
        <form-input 
          type="text" 
          v-model="form.name" 
          placeholder="Name"
          :error="errors.name"
          @focus="removeError('name')">
        </form-input>
        <form-input 
          type="text" 
          v-model="form.email" 
          placeholder="E-Mail"
          :error="errors.email"
          @focus="removeError('email')">
        </form-input>
        <form-group class="flex justify-end w-full">
          <button 
            :class="[isLoading ? 'bg-silver pointer-events-none select-none' : '', 'bg-lemon text-xs md:text-sm text-black py-6 px-10 leading-none inline-flex items-center w-auto text-left']"
            type="button"
            @click.prevent="submit('newsletter')">
            absenden
          </button>
        </form-group>
      </form>
    </template>
  </li>
</template>
<script>
import FormGroup from '@/form/components/form/Group.vue';
import FormInput from '@/form/components/form/Input.vue';
import ValidationErrors from '@/form/components/form/ValidationErrors.vue';
import Feedback from '@/form/components/form/Feedback.vue';

export default {

  components: {
    FormGroup,
    FormInput,
    ValidationErrors,
    Feedback,
  },

  data() {

    return {

      form: {
        firstname: null,
        name: null,
        email: null,
      },

      errors: {
        firstname: null,
        name: null,
        email: null,
      },

      validationErrors: [],

      routes: {
        newsletter: {
          store: '/api/form/newsletter'
        },
        member: {
          store: '/api/form/member'
        }
      },

      isSent: false,
      isLoading: false,
      hasMemberForm: false,
      hasNewsletterForm: false,
    }
  },

  methods: {

    submit(type) {
      this.isSent = false;
      this.isLoading = true;
      this.validationErrors = [];
      this.axios.post(this.routes[type].store, this.form).then(response => {
        this.reset();
        this.isSent = true;
        this.isLoading = false;
      })
      .catch(error => {
        this.isLoading = false;
        this.handleValidationErrors(error.response.data);
      });
    },

    handleValidationErrors(data) {
      let errors = [];
      for (let key in data.errors) {
        this.validationErrors.push(
          data.errors[key][0]
        );
        this.errors[key] = true;
      }
    },

    removeError(field) {
      this.errors[field] = null;
      this.validationErrors = [];
    },

    reset() {
      this.form = {
        firstname: null,
        name: null,
        email: null,
      };
      this.errors = {};
      this.validationErrors = [];
      this.isSent = false;
    },
    
    toggleForm(form) {
      if (form === 'member') {
        this.hasMemberForm = !this.hasMemberForm;
        this.hasNewsletterForm = false;
      }
      if (form === 'newsletter') {
        this.hasNewsletterForm = !this.hasNewsletterForm;
        this.hasMemberForm = false;
      }      
      this.reset();
    }
  },
}
</script>