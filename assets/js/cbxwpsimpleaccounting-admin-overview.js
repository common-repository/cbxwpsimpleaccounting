(function ($) {
    'use strict';

    $(document).ready(function () {

        //delete any expinc
        $(".cbxdelexpinc").on('click',function (e) {
            e.preventDefault();

            if (!confirm(cbxwpsimpleaccounting.permission)) {
                return false;
            }

            var $this   = $(this);
            var $id     = parseInt($this.attr('id'));
            var $busy   = parseInt($this.data('busy'));


            if($busy == 0){
				$this.data('busy', 1);
				$('#cbxaccountingloading').show();
				var data = {
					'action': 'delete_expinc',
					'id': $id,
					'security': cbxwpsimpleaccounting.nonce
				};
				//ajax call for deleting expinc
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: ajaxurl,
					data: data,
					success: function (response) {
						if (!response.error) {
							$('#cbxaccountingloading').hide();
							$this.closest("tr").remove();
							//$('.msg').show();
							//$('.msg').html(response.msg);
						}
						else {
							$('#cbxaccountingloading').hide();
							$this.data('busy', 0);
							//$('.msg').hide();
							//$('.msg').html(response.msg);
						}
					}
				});//end ajax calling for category
            }
        });


		var date  = new Date();//current date
		var month = date.getMonth();//current month exp.5
		var year  = date.getFullYear();//current year exp.2016
		var chart;
		var month_chart;
		var year_chart;

		//chart option for linechart
		var options = {
			curveType      : 'function',
			legend         : {position: 'bottom'},
			colors         : cbxwpsimpleaccounting.chart_colors, //Line color
			backgroundColor: '#f7f7f9',
			random_id      : true
		};


		// data holder array for expinc by month of this year
		var year_expinc_by_month = [[cbxwpsimpleaccounting.month, cbxwpsimpleaccounting.income, cbxwpsimpleaccounting.expense]];
		// data holder array for expinc by day of this month
		var month_expinc_by_day = [[cbxwpsimpleaccounting.day, cbxwpsimpleaccounting.income, cbxwpsimpleaccounting.expense]];
		// month names array
		//var months = [<?php echo '"' . implode('","', $monthnames) . '"' ?>];
		var months               = cbxwpsimpleaccounting.monthnames;
		// days of each month
		//var all_month_days = [<?php echo '"' . implode('","', $month_days_array) . '"' ?>];
		var all_month_days       = cbxwpsimpleaccounting.month_days_array;

		//current month days
		var current_month_days = parseInt(all_month_days[month]);

		// arranging year income|expense data for chart
		var year_income_by_month = $.map(cbxwpsimpleaccounting.year_income_by_month, function (el) {
			return el
		});
		var year_expense_by_month = $.map(cbxwpsimpleaccounting.year_expense_by_month, function (el) {
			return el
		});

		$(months).each(function (index) {
			var data = [months[index], year_income_by_month[index], year_expense_by_month[index]];
			year_expinc_by_month.push(data);
		});
		//finish

		// arranging month income|expense data for chart
		var month_income_by_day = $.map(cbxwpsimpleaccounting.daywise_income2, function (el) {
			return el
		});
		var month_expense_by_day = $.map(cbxwpsimpleaccounting.daywise_expense2, function (el) {
			return el
		});

		for (var i = 0; i <= current_month_days; i++) {
			var data = [i + 1, month_income_by_day[i], month_expense_by_day[i]];
			month_expinc_by_day.push(data);
		}
		//finish

		$('.cbxyear').html(year);
		$('.cbxmonthyear').html(months[month] +' Year: '+year);


		//draw line charts for year and month
		var drawChart = function() {

			year_chart = new google.visualization.LineChart(document.getElementById('cbxaccountchart'));
			month_chart = new google.visualization.LineChart(document.getElementById('cbxaccountchartmonth'));

			var year_data = google.visualization.arrayToDataTable(year_expinc_by_month);
			var month_data = google.visualization.arrayToDataTable(month_expinc_by_day);

			year_chart.draw(year_data, options);
			month_chart.draw(month_data, options);
		};

		google.load("visualization", "1", {packages: ["corechart"], "callback": drawChart});
		google.setOnLoadCallback(drawChart);

		//peryear traversal of year data
		$(".cbxaccounting_peryear").on('click' , function (e) {

			e.preventDefault();
			$('#cbxaccountingloading').show();
			var $this = $(this);
			year = parseInt($this.attr('data-year'));

			var data = {
				'action': 'load_nextprev_year',
				'year': year,
				'security': cbxwpsimpleaccounting.nonce
			};
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: ajaxurl,
				data: data,
				success: function (data) {
					if (data) {

						var year_income_by_month = $.map(data.year_income_by_month, function (el) {
							return el
						});

						var year_expense_by_month = $.map(data.year_expense_by_month, function (el) {
							return el
						});

						var year_expinc_by_month = [[cbxwpsimpleaccounting.month, cbxwpsimpleaccounting.income, cbxwpsimpleaccounting.expense]];

						$(months).each(function (index) {

							var data = [months[index], year_income_by_month[index], year_expense_by_month[index]];

							year_expinc_by_month.push(data);

						});


						$(".cbxaccounting_peryear[data-type='next']").attr("data-year", (parseInt(year) + 1));
						$(".cbxaccounting_peryear[data-type='prev']").attr("data-year", (parseInt(year) - 1));

						var cyear = (new Date().getFullYear());

						if($(".cbxaccounting_peryear[data-type='next']").attr("data-year") <= cyear){
							$(".cbxaccounting_peryear[data-type='next']").removeClass('hidden');
						}else{
							$(".cbxaccounting_peryear[data-type='next']").addClass('hidden');
						}

						$('.cbxyear').html(year);


						var year_data = google.visualization.arrayToDataTable(year_expinc_by_month);

						$('#cbxaccountingloading').hide();
						year_chart.draw(year_data, options);

					}
				},
			});
		});
		//finish peryear traversal of year data

		//permonth traversal of year data
		$(".cbxaccounting_permonth").on('click', function (e) {

			e.preventDefault();
			$('#cbxaccountingloading').show();
			var $this = $(this);
			year = parseInt($this.attr('data-year'));
			month = parseInt($this.attr('data-month'));

			var data = {
				'action': 'load_nextprev_month',
				'year': year,
				'month': month,
				'security': cbxwpsimpleaccounting.nonce
			};
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: ajaxurl,
				data: data,
				success: function (data) {
					if (data) {

						var month_income_by_day = $.map(data.daywise_income2, function (el) {
							return el
						});
						var month_expense_by_day = $.map(data.daywise_expense2, function (el) {
							return el
						});

						var month_expinc_by_day = [[cbxwpsimpleaccounting.day, cbxwpsimpleaccounting.income, cbxwpsimpleaccounting.expense]];

						for (var i = 0; i <= parseInt(all_month_days[month]); i++) {
							var data = [i + 1, month_income_by_day[i], month_expense_by_day[i]];
							month_expinc_by_day.push(data);
						}

						for (var i = 0; i <= current_month_days; i++) {
							var data = [i + 1, month_income_by_day[i], month_expense_by_day[i]];
							month_expinc_by_day.push(data);
						}

						var month_data = google.visualization.arrayToDataTable(month_expinc_by_day);

						$('#cbxaccountingloading').hide();
						month_chart.draw(month_data, options);

						if (month == 12) {
							var cbxaccounting_prev_month = parseInt(month) - 1;
							var cbxaccounting_next_month = 1;
							var cbxaccounting_prev_year  = parseInt(year);
							var cbxaccounting_next_year  = parseInt(year) + 1;
						}else if (month == 1) {
							var cbxaccounting_prev_month = 12;
							var cbxaccounting_next_month = parseInt(month) + 1;
							var cbxaccounting_prev_year  = parseInt(year) - 1;
							var cbxaccounting_next_year  = parseInt(year);
						}else {
							var cbxaccounting_prev_month = parseInt(month) - 1;
							var cbxaccounting_next_month = parseInt(month) + 1;
							var cbxaccounting_prev_year  = parseInt(year);
							var cbxaccounting_next_year  = parseInt(year);
						}

						var cmonth = (new Date().getMonth());
						var cyear = (new Date().getFullYear());

						$(".cbxaccounting_permonth[data-type='next']").attr("data-year", (cbxaccounting_next_year));
						$(".cbxaccounting_permonth[data-type='next']").attr("data-month", (cbxaccounting_next_month));

						$(".cbxaccounting_permonth[data-type='prev']").attr("data-year", (cbxaccounting_prev_year));
						$(".cbxaccounting_permonth[data-type='prev']").attr("data-month", (cbxaccounting_prev_month));


						if($(".cbxaccounting_permonth[data-type='next']").attr("data-year") < cyear){
							$(".cbxaccounting_permonth[data-type='next']").removeClass('hidden');
						}else{

							if($(".cbxaccounting_permonth[data-type='next']").attr("data-month") <= (cmonth + 1)){

								$(".cbxaccounting_permonth[data-type='next']").removeClass('hidden');
							}else{

								$(".cbxaccounting_permonth[data-type='next']").addClass('hidden');
							}

						}

						$('.cbxmonthyear').html(months[month-1] +' Year: '+ (year));
					}
				},
			});
		});
		//finish permonth traversal of year data

		/**Start third chart of the overview page(overview chart by cat of income and expenses)**/

				 // data holder array for income by cat. of this currnet month
		var month_income_by_cat = $.map(cbxwpsimpleaccounting.latest_income_by_cat, function (el) {
			return [[el.label, el.value]];
		});
		// data holder array for expense by cat. of this currnet month
		var month_expense_by_cat = $.map(cbxwpsimpleaccounting.latest_expense_by_cat, function (el) {
			return [[el.label, el.value]];
		});

		//pie chart for month income by cat
		new Chartkick.PieChart("cbxaccinc", month_income_by_cat);

		//pie chart for month expense by cat
		new Chartkick.PieChart("cbxaccexp", month_expense_by_cat);
		/**end chart**/

		/**for resposiveness of year overview chart**/
		$(window).resize(function () {
			drawChart();
		});

    }); //end DOM ready

})(jQuery);
