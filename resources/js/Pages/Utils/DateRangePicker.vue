

<template>
  <div>
    <form @submit.prevent="submit">
        <date-picker range v-model="form.date"></date-picker>
         <button type="submit" class="px-5 py-2 bg-blue-500 rounded-md text-white">Search</button>
    </form>
  </div>
</template>
<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    data() {
      return {
        form: {
            range: null
        }
      };
    },
    methods: {
        submit(){
            this.$inertia.post('events/filter', this.form.date)
        }
    },
  };
</script>