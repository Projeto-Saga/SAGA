document.addEventListener("DOMContentLoaded", function () {
	const daysContainer = document.querySelector(".days"),
		nextBtn = document.querySelector(".next-btn"),
		prevBtn = document.querySelector(".prev-btn"),
		month = document.querySelector(".month"),
		todayBtn = document.querySelector(".today-btn");

	const months = [
		"Janeiro",
		"Fevereiro",
		"Março",
		"Abril",
		"Maio",
		"Junho",
		"Julho",
		"Agosto",
		"Setembro",
		"Outubro",
		"Novembro",
		"Dezembro",
	];

	const days = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"];

	const date = new Date();

	let currentMonth = date.getMonth();
	let currentYear = date.getFullYear();

	function renderCalendar() {
		// date.setDate(1);
		const firstDay = new Date(currentYear, currentMonth, 1);
		const lastDay = new Date(currentYear, currentMonth + 1, 0);
		const lastDayIndex = lastDay.getDay();
		const lastDayDate = lastDay.getDate();
		const prevLastDay = new Date(currentYear, currentMonth, 0);
		const prevLastDayDate = prevLastDay.getDate();
		const nextDays = 7 - lastDayIndex - 1;

		month.innerHTML = `${months[currentMonth]} ${currentYear}`;

		let days = "";
		let weekday = "";

		var dark = localStorage.getItem("darkmode") == "S" ? "dark-mode" : "";

		for (let x = firstDay.getDay(); x > 0; x--) {
			days += `<div class="day prev ${dark}">${prevLastDayDate - x + 1}</div>`;
		}

		for (let i = 1; i <= lastDayDate; i++) {
			var date = new Date(currentYear, currentMonth, i);

			if (date.getDay() == 0 || date.getDay() == 6) {
				weekday = "sunday";
			}
			else {
				weekday = "";
			}

			if ((((date.getMonth() == 1) && (i == 21 || i == 20)) || ((date.getMonth() == 3) && (i == 7 || i == 21)) || ((date.getMonth() == 4) && (i == 1)) || ((date.getMonth() == 5) && (i == 8 || i == 9)) ||
				((date.getMonth() == 8) && (i == 7 || i == 8)) || ((date.getMonth() == 9) && (i == 12 || i == 13)) || ((date.getMonth() == 10) && (i == 2 || i == 3 || i == 15 || i == 20)) ||
				((date.getMonth() == 11) && (i == 25)))) {
				weekday = "holiday";
			}
			if (i === new Date().getDate() &&
				currentMonth === new Date().getMonth() &&
				currentYear === new Date().getFullYear()) {
				days += `<button class="day today ${dark} ${weekday}"><div>${i}</div></button>`;
			}
			else {
				days += `<button class="day ${dark} ${weekday}"><div>${i}</div></button>`;
			}
		}

		for (let j = 1; j <= nextDays; j++) {
			days += `<div class="day next ${dark}">${j}</div>`;
		}

		hideTodayBtn();
		daysContainer.innerHTML = days;
	}

	renderCalendar();

	nextBtn.addEventListener("click", () => {
		currentMonth++;

		if (currentMonth > 11) {
			currentMonth = 0;
			currentYear++;
		}

		renderCalendar();
	});

	prevBtn.addEventListener("click", () => {
		currentMonth--;

		if (currentMonth < 0) {
			currentMonth = 11;
			currentYear--;
		}

		renderCalendar();
	});

	todayBtn.addEventListener("click", () => {
		currentMonth = date.getMonth();
		currentYear = date.getFullYear();

		renderCalendar();
	});

	function hideTodayBtn() {
		if (currentMonth === new Date().getMonth() &&
			currentYear === new Date().getFullYear()) {
			todayBtn.style.display = "none";
		}
		else {
			todayBtn.style.display = "flex";
		}
	}
});