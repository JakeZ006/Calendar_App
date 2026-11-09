export function useDate(dateInput = "today") {
  let date;

  if (dateInput === "today") {
    date = Temporal.Now.plainDateTimeISO();
  } else {
    date = new Temporal.PlainDateTime(...dateInput.map(Number));
  }

  date.names = {
    day: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],

    month: [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ],
  };

  if (date.day >= 11 && date.day <= 13) {
    date.daySuffix = "th";
  } else {
    switch (date.day % 10) {
      case 1:
        date.daySuffix = "st";
        break;
      case 2:
        date.daySuffix = "nd";
        break;
      case 3:
        date.daySuffix = "rd";
        break;
      default:
        date.daySuffix = "th";
        break;
    }
  }

  date.timeString = Temporal.Now.instant().toString().substring(11, 19);

  date.dateString = `${date.toString().substring(0, 10)}`;

  date.dayName = date.names.day[date.dayOfWeek - 1];
  date.monthName = date.names.month[date.month - 1];

  return date;
}
