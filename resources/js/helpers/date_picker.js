import {ref, unref, watch, computed} from "vue";

export function useDatePicker(day, month) {
    const months = ref(
        {
            "1": "January",
            "2": "February",
            "3": "March",
            "4": "April",
            "5": "May",
            "6": "June",
            "7": "July",
            "8": "August",
            "9": "September",
            "10": "October",
            "11": "November",
            "12": "December"
        }
    );

    const populateDays = computed( ()=> {
        // Create variable to hold new number of days to inject
        let dayNum;

        // 31 or 30 days?
        if (
            unref(month) === "4" ||
            unref(month) === "6" ||
            unref(month) === "9" ||
            unref(month) === "11"
        ) {
            dayNum = 30;
        } else if (unref(month) === "2") {
            const date = new Date();
            const year = date.getFullYear();
            // If month is February, calculate whether it is a leap year or not
            let leap = (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
            dayNum = leap ? 29 : 28;
        } else {
            dayNum = 31;
        }

        return dayNum;
    });

    return {
        months,
        populateDays,
    }

}