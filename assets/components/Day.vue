<script>



export default {
    props: {
        value: Number,
        apts: {
            type: Array,
            default: () => [],
        },
        maxAptsPerDay: {
            type: Number,
            default: 8,
        },
        singleDayFetchURL: {
            type: String,
            default: '#?',
        },
        isToday: Boolean,
    },
    data() {
        return {

        }
    },
    computed: {
        availableHours() {
            return this.maxAptsPerDay - this.apts.length;
        },

        dayId() {
            return 'date-' + this.value;
        },

        genLink() {
            return this.singleDayFetchURL.replace('-0-', this.value);
        }
    },

    methods: {

    },

    mounted() {

        //console.log(this.apts);

    },

    components: {
        //Day,
    }
}

</script>

<template>
    <div class="day" :id="dayId">

        <a :href="genLink"><span class="date" :class="{
            today: isToday,
        }">{{ value }}</span></a>
        
        <span class="badge rounded-pill" :class="{
            'text-bg-success': availableHours,
            'text-bg-danger': !availableHours,
        }">{{ availableHours }}</span>
    </div>

</template>
