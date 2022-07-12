
<template>
    <div class="p-5">
        <div v-if="$page.flash.success" class="bg-green-100 p-5 text-green-600">
            {{ $page.flash.success }}
        </div>
        <DateRangePicker />
        
        <Full-Calendar :events="events" />
    </div>
</template>

<script>
import FullCalendar from "../Utils/FullCalendar";
import DateRangePicker from "../Utils/DateRangePicker.vue";
export default {
    components: {
        FullCalendar,
        DateRangePicker
    },
    props: ['events'],
    data() {
        return {
        }
    },

}
</script>