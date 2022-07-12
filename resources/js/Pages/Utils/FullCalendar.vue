
<template>
    <div>
        <FullCalendar :options="calendarOptions" />
        <DialogModal :show="isOpen">
            <template #title>
                <h1 class="text-blue-500">{{ title }}</h1>
            </template>

            <template #content>
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
                            <input type="time" v-model="form.time"
                                class="placeholder:italic placeholder:text-slate-400 block bg-white my-2 border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-400 focus:ring-1 sm:text-sm">
                            <div class="text-red-600 mt-2" v-if="$page.errors['date']">
                                {{ $page.errors['date'][0] }}
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <button @click="closeModal" type="button"
                                class="px-5 py-2 bg-gray-800 rounded-md text-white">
                                Cancel </button>
                            <button type="submit" class="px-5 py-2 bg-blue-500 rounded-md text-white">Save</button>
                            <button v-show="editMode" class="px-5 py-2 bg-red-500 rounded-md text-white" type="submit" @click="editMode= null">Delete</button>
                        </div>
                        
                    </form>
                </div>
            </template>

        </DialogModal>

    </div>
</template>
<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import DialogModal from "../../Jetstream/DialogModal.vue"
import EventNew from '../Events/New.vue'

export default {
    components: {
        FullCalendar,
        DialogModal,
        EventNew

    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                dateClick: this.openModal,
                events: [],
                editable: true,
                selectable: true,
                eventClick: this.openModal
            },
            isOpen: false,
            title: 'Add an event',
            date: null,
            editMode: false,
             form: {
                title: null,
                time: null,
                date: null
            }
        }
    },
    props: ['events'],

    created() {
        // props are exposed on `this`
        this.calendarOptions.events = this.events
    },

    methods: {
        openModal: function (arg) {
            if (arg.event != undefined) {
                this.editMode = true
                this.title = 'Edit Event ' + arg.event.title
                this.form.title = arg.event.title
                this.form.date = ("0" + arg.event.start.getHours()).slice(-2) + ':' +("0" + arg.event.start.getMinutes()).slice(-2)
                this.form.id = arg.event.id
            }
            this.isOpen = true
            this.date = arg

        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();

        },
        reset: function () {
            this.form = {
                title: null,
                date: null,
                time:null,
                id: null
            }
            this.editMode = false

        },
        UpdateDate() {
            let day =this.date.event.start.getDate()
           let year = this.date.event.start.getFullYear()
           let month = this.date.event.start.getMonth()
            return  year+ '-'+ month + '-'+ day + ' '+ this.form.time;
        },
        submit() {
            if (this.editMode != false) {
                this.form.date = this.UpdateDate()
            } else {
                this.form.date = this.date.dateStr + ' ' + this.form.time
            }
            switch (this.editMode) {
                case false:
                    this.$inertia.post('event', this.form)
                    break;
                case true:
                    this.$inertia.patch('event/' + this.form.id, this.form)
                    break;
                case null:
                    this.$inertia.post('event/delete/' + this.form.id)
                    break;
            
                default:
                    break;
            }
            this.closeModal()
        }
    }
}
</script>
