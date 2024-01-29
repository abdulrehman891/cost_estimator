<!--begin::Chart widget 27-->
<div class="card card-flush h-xl-100">
	<!--begin::Header-->
	<div class="card-header py-7">
		<!--begin::Statistics-->
		<div class="m-0">
			<!--begin::Heading-->
			<div class="d-flex align-items-center mb-2">
                <h3 class="card-title align-items-start flex-column">Quotation's Pipeline </h3>							 
			</div>
			<!--end::Heading-->			
            <!--begin::Title-->
            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$quote_status_based_report_data['all_counter']}}</span>
            <!--begin::Description-->
			<span class="fs-6 fw-semibold text-gray-500">All Quotations</span> 
            <!--end::Title-->	
			<!--end::Description-->
		</div>
		<!--end::Statistics-->
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body pt-0 pb-1">
		<div id="kt_charts_widget_for_status_counters" class="min-h-auto"></div>
	</div>
	<!--end::Body-->
</div>
<!--end::Chart widget 27-->

<script>

document.addEventListener('DOMContentLoaded', () => {
"use strict";

// Class definition
var KTChartsWidget27 = function () {
    var chart = {
        self: null,
        rendered: false
    };
    // Private methods
    var initChart = function(chart) {
        var element = document.getElementById("kt_charts_widget_for_status_counters");
		 
        if (!element) {
            return;
        }
 
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-800');
        var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');
        var maxValue = 18;

        var options = {
            series: [{
                name: 'Quotations',
                data: {!! json_encode($quote_status_based_report_data['count']) !!}
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: true,
                    distributed: true,
                    barHeight: 50,
                    dataLabels: {
				        position: 'bottom' // use 'bottom' for left and 'top' for right align(textAnchor)
			        }
                }
            },
            dataLabels: {  // Docs: https://apexcharts.com/docs/options/datalabels/
                enabled: true,
                textAnchor: 'start',
                offsetX: 0,
                formatter: function (val, opts) {
                    var val = val;
                    var Format = wNumb({
                        //prefix: '$',
                        //suffix: ',-',
                        thousand: ','
                    });
                    return Format.to(val);
                },
                style: {
                    fontSize: '14px',
                    fontWeight: '600',
                    align: 'left',
                }
            },
            legend: {
                show: true
            },
            colors: {!! json_encode($quote_status_based_report_data['colors']) !!},
            xaxis: {
                categories: {!! json_encode($quote_status_based_report_data['label']) !!},
                labels: {
                    formatter: function (val) {
                        return val.toFixed(1)
                    },
                    style: {
                        colors: labelColor,
                        fontSize: '14px',
                        fontWeight: '600',
                        align: 'left'
                    }
                },
                axisBorder: {
					show: false
				}
            },
            yaxis: {
                labels: {
                    formatter: function (val, opt) {
                        if (Number.isInteger(val)) {
                            var percentage = parseInt(val * 100 / maxValue) . toString();
                            return val + ' - ' + percentage + '%';
                        } else {
                            return val;
                        }
                    },
                    style: {
                        colors: labelColor,
                        fontSize: '14px',
                        fontWeight: '600'
                    },
                    offsetY: 2,
                    align: 'left'
                }
            },
            grid: {
                borderColor: borderColor,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                strokeDashArray: 4
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return val;
                    }
                }
            }
        };

        chart.self = new ApexCharts(element, options);

        // Set timeout to properly get the parent elements width
        setTimeout(function() {
            chart.self.render();
            chart.rendered = true;
        }, 200);
    }

    // Public methods
    return {
        init: function () {
            initChart(chart);

            // Update chart on theme mode change
            KTThemeMode.on("kt.thememode.change", function() {
                if (chart.rendered) {
                    chart.self.destroy();
                }

                initChart(chart);
            });
        }
    }
}();
// Webpack support
if (typeof module !== 'undefined') {
	module.exports = KTChartsWidget27;
}

	// On document ready
	KTUtil.onDOMContentLoaded(function() {
		KTChartsWidget27.init();
	});
});  
</script>
