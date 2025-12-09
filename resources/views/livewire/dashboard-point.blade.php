<div id="dashboard-wrapper" class="wrapper wrapper-content animated fadeInRight" style="padding: 20px;">
    {{-- FILTER SECTION --}}
    <div class="ibox shadow-sm" style="border-radius: 8px;">
        <div class="ibox-content" style="padding: 20px;">
            <div class="row align-items-center">
                <div class="col-sm-4 col-md-3 m-b-xs">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-sm btn-white {{ $selectedOption == 1 ? 'active' : '' }}" style="border-radius: 4px;">
                            <input type="radio" name="options" value="1"> MONTH
                        </label>
                        <label class="btn btn-sm btn-white {{ $selectedOption == 2 ? 'active' : '' }}" style="border-radius: 4px;">
                            <input type="radio" name="options" value="2"> YEARS
                        </label>
                    </div>
                </div>
                <div class="col-sm-5 col-md-6 m-b-xs">
                    <div class="input-daterange input-group">
                        <span class="input-group-addon">FROM</span>
                        <input type="text" class="form-control" id="time-start" value="{{ $timeStartPick }}">
                        <span class="input-group-addon">TO</span>
                        <input type="text" class="form-control" id="time-end" value="{{ $timeEndPick }}">
                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <button id="exportScreenshot" class="btn btn-block btn-info" style="border-radius: 4px;">
                        EXPORT LAPORAN
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="capture" class="row mt-4">
        {{-- CHART SECTION --}}
        <div class="col-lg-8">
            <div class="ibox shadow-sm" style="border-radius: 8px;">
                <div class="ibox-title">
                    <h5>TOTAL TEMUAN UNSAFE ACTION & CONDITION</h5>
                </div>
                <div class="ibox-content" style="padding: 20px;">
                    <div id="chartContainer" style="height: 350px; width: 100%;"></div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR SECTION --}}
        <div class="col-md-4">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="ibox shadow-sm" style="border-radius: 8px;">
                        <div class="ibox-title" style="border-radius: 8px 8px 0 0; padding: 15px;">
                            <h5>Total Reports</h5>
                        </div>
                        <div class="ibox-content text-center" style="padding: 20px;">
                            <h1 class="no-margins font-bold text-primary">{{ number_format($totalReports) }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="ibox shadow-sm" style="border-radius: 8px;">
                        <div class="ibox-title  " style="border-radius: 8px 8px 0 0; padding: 15px;">
                            <h5>Top Reporters</h5>
                        </div>
                        <div class="ibox-content" style="padding: 20px;">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f8f9fa;">EMPLOYEE</th>
                                        <th style="background-color: #f8f9fa;">NPK</th>
                                        <th style="background-color: #f8f9fa;">REPORTS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topReporters as $reporter)
                                        <tr>
                                            <td>{{ $reporter['nama'] ?? 'Unknown' }}</td>
                                            <td>{{ $reporter['npk'] ?? '-' }}</td>
                                            <td>{{ $reporter['total'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
$(document).ready(function() {
    // DATEPICKER
    $('#time-start, #time-end').datepicker({ 
        format: 'dd/mm/yyyy', 
        autoclose: true,
        todayHighlight: true 
    });
    
    // RADIO BUTTON
    $(document).on('change', 'input[type="radio"]', function() {
        @this.call('receiveOption', $(this).val());
    });
    
    // DATE CHANGE
    $('#time-start').change(function() { 
        @this.call('setTimeStart', $(this).val()); 
    });
    $('#time-end').change(function() { 
        @this.call('setTimeEnd', $(this).val()); 
    });

    // Listen untuk chart update dari PHP
    window.addEventListener('chart-updated', function(event) {
        console.log('Chart update received:', event.detail.data);
        window.renderChart(event.detail.data, event.detail.option);
    });

    // **RENDER CHART FUNCTION**
    window.renderChart = function(chartData, option = {{ $selectedOption }}) {
        const container = document.getElementById('chartContainer');
        if (!container) {
            console.error('Chart container not found');
            return;
        }

        if (typeof CanvasJS === 'undefined') {
            console.error('CanvasJS not loaded');
            setTimeout(() => window.renderChart(chartData, option), 100);
            return;
        }

        const data = chartData || @json($chartData);
        console.log('Chart data received:', data);
        const axisTitle = option == 2 ? 'Years' : 'Months';
        
        if (!data || data.length === 0) {
            console.log('No chart data available');
            container.innerHTML = '<p class="text-center text-muted">No data available for selected period</p>';
            return;
        }

        // Destroy existing chart
        if (window.chartInstance) {
            window.chartInstance.destroy();
        }

        // Prepare data with labels
        const processedData = data.map(item => ({
            label: item.label,
            open: parseInt(item.open),
            closed: parseInt(item.closed),
            total: parseInt(item.open) + parseInt(item.closed)
        }));

        window.chartInstance = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: false,
            theme: "light1",
            title: {
                text: "TOTAL TEMUAN UNSAFE ACTION & CONDITION",
                fontFamily: "arial black",
                fontColor: "#695A42",
                fontSize: 18,
                padding: 10
            },
            axisX: {
                interval: 1,
                labelFontSize: 12,
                labelFontColor: "#555555",
                labelFontWeight: "normal",
                tickThickness: 0,
                lineThickness: 1,
                lineColor: "#B6B1A8",
                title: axisTitle,
                titleFontSize: 14,
                titleFontColor: "#695A42",
                titleFontWeight: "normal"
            },
            axisY: {
                valueFormatString: "#,##0",
                gridColor: "#B6B1A8",
                gridThickness: 0.5,
                tickThickness: 0,
                lineThickness: 1,
                lineColor: "#B6B1A8",
                labelFontSize: 12,
                labelFontColor: "#555555",
                title: "Number of Reports",
                titleFontSize: 14,
                titleFontColor: "#695A42",
                titleFontWeight: "normal"
            },
            legend: {
                enabled: true,
                fontSize: 12,
                fontColor: "#555555",
                horizontalAlign: "center",
                verticalAlign: "bottom"
            },
            data: [
                {
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "#28a745",
                    name: "CLOSED",
                    indexLabel: "CLOSED: {y}",
                    indexLabelFontColor: "#ffffff",
                    indexLabelFontSize: 10,
                    indexLabelFontWeight: "bold",
                    indexLabelPlacement: "inside",
                    dataPoints: processedData.map(dp => ({
                        y: dp.closed,
                        label: dp.label
                    }))
                },
                {
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "#dc3545",
                    name: "OPEN",
                    indexLabel: "OPEN: {y}",
                    indexLabelFontColor: "#ffffff",
                    indexLabelFontSize: 10,
                    indexLabelFontWeight: "bold",
                    indexLabelPlacement: "inside",
                    dataPoints: processedData.map(dp => ({
                        y: dp.open,
                        label: dp.label
                    }))
                },
                {
                    type: "line",
                    name: "TOTAL",
                    lineColor: "transparent",
                    markerType: "none",
                    toolTipContent: null,
                    indexLabel: "TOTAL: {y}",
                    indexLabelFontColor: "#000000",
                    indexLabelFontSize: 10,
                    indexLabelFontWeight: "bold",
                    dataPoints: processedData.map(dp => ({
                        y: dp.total,
                        label: dp.label
                    }))
                }
            ],
            toolTip: {
                shared: true,
                contentFormatter: function(e) {
                    let totalOpen = 0, totalClosed = 0;
                    e.entries.forEach(entry => {
                        if (entry.dataSeries.name === "CLOSED") totalClosed = entry.dataPoint.y;
                        if (entry.dataSeries.name === "OPEN") totalOpen = entry.dataPoint.y;
                    });
                    return `
                        <div style="padding: 8px; font-family: Arial; font-size: 12px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 4px;">
                            <strong style="color: #695A42;">${e.entries[0].dataPoint.label}</strong><br/>
                            <span style="color: #28a745;">CLOSED: ${totalClosed}</span><br/>
                            <span style="color: #dc3545;">OPEN: ${totalOpen}</span><br/>
                            <strong style="color: #695A42;">TOTAL: ${totalOpen + totalClosed}</strong>
                        </div>
                    `;
                }
            }
        });

        window.chartInstance.render();
        
        // **ADD TOTAL LABELS**
        function addTotalLabels(processedData) {
            const container = document.getElementById('chartContainer');
            const svg = container.querySelector('svg');
            if (svg && processedData.length > 0 && window.chartInstance) {
                processedData.forEach((dp, index) => {
                    const totalText = document.createElementNS("http://www.w3.org/2000/svg", "text");
                    const barWidth = window.chartInstance.axisX[0].bounds.width / processedData.length;
                    totalText.setAttribute("x", (index * barWidth) + (barWidth / 2));
                    totalText.setAttribute("y", window.chartInstance.axisY[0].bounds.y - 10);
                    totalText.setAttribute("text-anchor", "middle");
                    totalText.setAttribute("font-family", "arial black");
                    totalText.setAttribute("font-weight", "bold");
                    totalText.setAttribute("font-size", getResponsiveFontSize());
                    totalText.setAttribute("fill", "#695A42");
                    totalText.textContent = "TOTAL: " + dp.total;
                    svg.appendChild(totalText);
                });
                console.log('TOTAL labels added successfully for', processedData.length, 'bars');
            } else {
                console.warn('Cannot add TOTAL labels. SVG:', !!svg, 'Data:', processedData.length, 'ChartInstance:', !!window.chartInstance);
                let retries = 0;
                const maxRetries = 5;
                const retryInterval = setInterval(() => {
                    retries++;
                    const retrySvg = container.querySelector('svg');
                    if (retrySvg && processedData.length > 0 && window.chartInstance) {
                        processedData.forEach((dp, index) => {
                            const totalText = document.createElementNS("http://www.w3.org/2000/svg", "text");
                            const barWidth = window.chartInstance.axisX[0].bounds.width / processedData.length;
                            totalText.setAttribute("x", (index * barWidth) + (barWidth / 2));
                            totalText.setAttribute("y", window.chartInstance.axisY[0].bounds.y - 10);
                            totalText.setAttribute("text-anchor", "middle");
                            totalText.setAttribute("font-family", "arial black");
                            totalText.setAttribute("font-weight", "bold");
                            totalText.setAttribute("font-size", getResponsiveFontSize());
                            totalText.setAttribute("fill", "#695A42");
                            totalText.textContent = "TOTAL: " + dp.total;
                            retrySvg.appendChild(totalText);
                        });
                        console.log('TOTAL labels added on retry', retries);
                        clearInterval(retryInterval);
                    } else if (retries >= maxRetries) {
                        console.error('Failed to add TOTAL labels after', maxRetries, 'retries');
                        clearInterval(retryInterval);
                    }
                }, 500);
            }
        }

        // Call addTotalLabels after chart render
        setTimeout(() => {
            addTotalLabels(processedData);
        }, 2000);

        console.log('Chart rendered with', processedData.length, 'data points');
    };

    // **RESPONSIVE FONT SIZE**
    function getResponsiveFontSize() {
        if (window.innerWidth <= 480) return 8;
        if (window.innerWidth <= 768) return 10;
        return 12;
    }

    // **EXPORT SCREENSHOT**
    document.getElementById('exportScreenshot').addEventListener('click', function() {
        console.log('Export screenshot button clicked');
        const captureElement = document.getElementById('capture');
        if (!captureElement) {
            console.error('Capture element not found');
            alert('Dashboard tidak ditemukan!');
            return;
        }

        if (typeof html2canvas === 'undefined') {
            console.error('html2canvas not loaded');
            alert('Library html2canvas tidak tersedia!');
            return;
        }

        setTimeout(() => {
            html2canvas(captureElement, {
                backgroundColor: '#FFFFFF',
                scale: 2,
                useCORS: true,
                allowTaint: true,
                logging: false
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                console.log('Screenshot captured, size:', imgData.length);
                const link = document.createElement('a');
                link.download = 'Dashboard-Point.png';
                link.href = imgData;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                // Removed: alert('Screenshot dashboard berhasil diekspor!');
            }).catch(error => {
                console.error('html2canvas error:', error);
                alert('Gagal mengambil screenshot: ' + error.message);
            });
        }, 2500);
    });

    // Initial render
    window.renderChart();
});
</script>
@endpush
