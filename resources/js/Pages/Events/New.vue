<template>
    <div class="w-10/12 mx-auto">
        <form @submit.prevent="submit">
            <div class="my-10">
                <input type="text" value="date.event.title" v-model="form.title"
                    class=" my-5 placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-400 focus:ring-1 sm:text-sm"
                    placeholder="Title">
                <div class="text-red-600 mt-2" v-if="$page.errors['title']">
                    {{ $page.errors['title'][0] }}
                </div>
                <label for="" class=""> Heure</label>
                <input type="time" v-model="form.date"
                    class="placeholder:italic placeholder:text-slate-400 block bg-white my-2 border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-400 focus:ring-1 sm:text-sm">
                <div class="text-red-600 mt-2" v-if="$page.errors['date']">
                    {{ $page.errors['date'][0] }}
                </div>
            </div>
            <div class="flex justify-between">
                <slot name="close-btn"></slot>
                <button type="submit" class="px-5 py-2 bg-blue-500 rounded-md text-white">Add Event</button>
            </div>
        </form>
    </div>
</template>

<script>

export default {
    data() {
        return {
            form: {
                title: null,
                date: null
            }
        }
    },
    props: ['date'],
    
    methods: {
        submit() {
            this.form.date = this.date.dateStr + ' ' + this.form.date
            this.$inertia.post('event', this.form)
        },

        add() {
            this.courseData.episodes.push({ title: null, description: null, video_url: null });
        },

        remove() {
            this.courseData.episodes.pop();
        },
    },
}
</script>