<template>
  <ul class="flex flex-col px-18 pt-16 md:pt-0 md:px-0 md:mr-32 xl:mr-56">
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
        <form class="mb-18 xl:mb-24">
          <form-checkbox :id="'member_type_student'" :selected="form.member_type == 'Student:in' ? true : false" @change="setType('Student:in')">
            <template v-slot:label>
              Student:in CHF 25
            </template>
          </form-checkbox>
          <form-checkbox :id="'member_type_single'" :selected="form.member_type == 'Einzelmitglied' ? true : false" @change="setType('Einzelmitglied')">
            <template v-slot:label>
              Einzelmitglied CHF 100
            </template>
          </form-checkbox>
          <form-checkbox :id="'member_type_institution'" :selected="form.member_type == 'Institution' ? true : false" @change="setType('Institution')">
            <template v-slot:label>
              Institution CHF 500
            </template>
          </form-checkbox>
          <div v-if="validationErrors.length > 0" class="mt-16">
            <validation-errors :validationErrors="validationErrors" />
          </div>
          <div class="flex flex-col gap-y-8 mt-24 xl:mt-32">
            <template v-if="form.member_type == 'Institution'">
              <form-input 
                type="text" 
                v-model="form.institution" 
                placeholder="Institution"
                :error="errors.institution"
                @focus="removeError('institution')">
              </form-input>
            </template>
            <template v-else>
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
            </template>
            <form-input 
              type="text" 
              v-model="form.street" 
              placeholder="Strasse, Nr."
              :error="errors.street"
              @focus="removeError('street')">
            </form-input>
            <template v-if="form.member_type == 'Institution'">
              <form-input 
                type="text" 
                v-model="form.additional_address" 
                placeholder="Adresszusatz">
              </form-input>
            </template>
            <form-input 
              type="text" 
              v-model="form.location" 
              placeholder="PLZ, Ort"
              :error="errors.location"
              @focus="removeError('location')">
            </form-input>
            <form-input 
              type="email" 
              v-model="form.email" 
              placeholder="E-Mail"
              :error="errors.email"
              @focus="removeError('email')">
            </form-input>
            <form-input 
              type="tel" 
              v-model="form.phone" 
              placeholder="Telefon">
            </form-input>
            <form-input 
              type="text" 
              v-model="form.occputation" 
              placeholder="Beruf / Ausbildung">
            </form-input>
            <form-group class="flex justify-end w-full">
              <button 
                :class="[isLoading ? 'bg-silver pointer-events-none select-none' : '', 'bg-lemon text-sm xl:text-md text-black py-6 px-10 leading-none inline-flex items-center w-auto text-left']"
                type="button"
                @click.prevent="submit('member')">
                absenden
              </button>
            </form-group>
          </div>
        </form>
      </template>
    </li>
    <!-- 
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
        <form>
          <div class="flex flex-col gap-y-8 mt-20 mt-32">
            <div v-if="validationErrors.length > 0" class="mb-16">
              <validation-errors :validationErrors="validationErrors"  v-if="validationErrors.length > 0" />
            </div>
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
                :class="[isLoading ? 'bg-silver pointer-events-none select-none' : '', 'bg-lemon text-xs xl:text-sm text-black py-6 px-10 leading-none inline-flex items-center w-auto text-left']"
                type="button"
                @click.prevent="submit('newsletter')">
                absenden
              </button>
            </form-group>
          </div>
        </form>
      </template>
    </li>
    -->
  </ul>
</template>
<script>
import FormCheckbox from '@/form/components/form/Checkbox.vue';
import FormGroup from '@/form/components/form/Group.vue';
import FormInput from '@/form/components/form/Input.vue';
import ValidationErrors from '@/form/components/form/ValidationErrors.vue';
import Feedback from '@/form/components/form/Feedback.vue';

export default {

  components: {
    FormGroup,
    FormInput,
    FormCheckbox,
    ValidationErrors,
    Feedback,
  },

  data() {

    return {

      form: {
        member_type: 'Student:in',
        institution: null,
        firstname: null,
        name: null,
        street: null,
        additional_address: null,
        location: null,
        phone: null,
        occputation: null,
        email: null,
      },

      errors: {
        institution: null,
        firstname: null,
        name: null,
        email: null,
        street: null,
        location: null,
        phone: null,
        occputation: null,
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
        institution: null,
        member_type: 'Student:in',
        firstname: null,
        name: null,
        street: null,
        additional_address: null,
        location: null,
        phone: null,
        occputation: null,
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
    },

    setType(type) {
      this.form.member_type = type;
    }
  },
}
</script>