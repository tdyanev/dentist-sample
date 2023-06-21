<script>

const monthNames = [
    'Jan', 'Feb', 'March', 'April', 'May', 'June', 'July',
    'August', 'September', 'October', 'November', 'December'
];

export default {
    props: {
        prevMonthURL: {
            type: String,
            default: '#',
        },
        nextMonthURL: {
            type: String,
            default: '#',
        },
        month: Number,
        year: Number,
    },
    data() {
        return {

        }
    },
    computed: {
        monthName() {
            return monthNames[this.month - 1] || '';
        },
    },

    methods: {

    },

    mounted() {

       console.log('i was born')

    },

    components: {

    }
}

</script>

<template>

    <div class="container">
        <div class="row align-items-start">
            <div class="col-3 prev-month">
                <a :href="prevMonthURL">Previous Month</a>
            </div>
            <div class="col-6 text-center">
                <h3>{{ monthName }}, {{ year }}</h3>
            </div>
            <div class="col-3 next-month">
                <a :href="nextMonthURL">Next Month</a>
            </div>
        </div>
    </div>    


</template>