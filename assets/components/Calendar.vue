<script>

import Day from './Day';
import CalendarHeader from './CalendarHeader';
import axios from 'axios';



export default {
    props: {
        year: Number,
        month: Number,
        firstDayOfWeek: Number,
        daysInMonth: Number,
        fetchURL: String,
        //singleDayURL: String,
    },
    data() {
        return {
            apts: {},

            dayProps: {},

            //TODO this will have to come from config/db to translate

            daysOfWeek: [
                'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'
            ],

            calendarHeaderProps: {
                // prevMonthURL: '#',
                // nextMonthURL: '#',
                // year: this.year,
                // month: this.month,
            },
        }
    },
    computed: {
        totalRows() {
            return parseInt(
                Math.ceil((this.countEmptyCells + this.daysInMonth) / 7));

        },

        countEmptyCells() {
            return this.firstDayOfWeek ? this.firstDayOfWeek - 1 : 6;

        },



    },

    methods: {
        getDay: function (row, i) {
            //console.log(arguments)
            return (row - 2) * 7 + i + this.firstDayOfWeek;
        },

        isValidDay: function (row, i) {
            const day = this.getDay(row, i);

            return day > 0 && day <= this.daysInMonth;
        },

        isToday(day) {
            const date = new Date();


            console.log(date.getDay() == day, date.getFullYear() == this.year,
                date.getMonth() == this.month - 1, day);

            return date.getDate() == day && date.getFullYear() == this.year &&
                date.getMonth() == this.month - 1;
        }

    },

    created() {
        //console.log('created')
        axios.get(this.fetchURL)
        .then(res => {
            this.apts = res.data.apts;
            this.dayProps = res.data.dayParams;

            this.calendarHeaderProps = {
                prevMonthURL: res.data.prevMonthURL,
                nextMonthURL: res.data.nextMonthURL,
                year: this.year,
                month: this.month,
            };

            console.log(this.calendarHeaderProps)
        })

        .catch(function (error) {
            console.log('err', error);
        })
        .finally(function () {
            // always executed
        });

    },

    components: {
        CalendarHeader,
        Day,

    }
}

</script>

<template>
    <div class="calendar">



    <CalendarHeader v-bind="calendarHeaderProps" />

    <table class="table">
    <thead class="thead-dark">
      <tr>
        <th v-for="day in daysOfWeek" scope="col">
            {{ day }}
        </th>
      </tr>
    </thead>


    <tbody>
    <tr v-for="n in this.totalRows">

        <td v-for="j in 7">
            <Day v-if="this.isValidDay(n, j)" :value="this.getDay(n, j)" :key="this.getDay(n, j)"
                :isToday="isToday(this.getDay(n, j))"
                :apts="apts[this.getDay(n, j)]" v-bind="this.dayProps" />
        </td>


    </tr>


    </tbody>
</table>


</div>

</template>
