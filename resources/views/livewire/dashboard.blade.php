<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <form>
                    <div class="row">
                        <div class="col-sm-4 m-b-xs">
                            <div class="btn-group btn-group-toggle">
                                <label class="btn btn-sm btn-white @if($selectedOption == 1)active @endif">
                                    <input type="radio" id="option1" name="options" value="1" autocomplete="off" @if($selectedOption == 3)checked @endif> Day
                                </label>
                                <label class="btn btn-sm btn-white @if($selectedOption == 2)active @endif">
                                    <input type="radio" id="option2" name="options" value="2" autocomplete="off" @if($selectedOption == 3)checked @endif> Week
                                </label>
                                <label class="btn btn-sm btn-white @if($selectedOption == 3)active @endif">
                                    <input type="radio" id="option3" name="options" value="3" autocomplete="off" @if($selectedOption == 3)checked @endif> Month
                                </label>
                            </div>
                        </div>

                        <input type="hidden" id="jsonDataEHS" value=@json($temuanEHS)>
                        {{-- <input type="hidden" id="jsonareas" value=@json($areas)> --}}
                        <input type="hidden" id="jsonDataGenba" value=@json($temuanGenba)>


                        <div class="col-sm-5 m-b-xs form-group ">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                <input type="text" class="form-control-sm form-control" id="time-start" name="timeStart" value="{{ \Carbon\Carbon::parse($timeStart)->format('d/m/Y') }}"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" id="time-end" name="timeEnd" value="{{ \Carbon\Carbon::parse($timeEnd)->format('d/m/Y') }}" />
                            </div>
                        </div>
                       
                        <div class="col-sm-2 offset-1">
                            <button class="btn btn-block btn-info compose-mail" type="button" id="exportScreenshot">Export laporan</button>
               
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>        
       
        <div id="capture" class="gray-bg">
        <div class="row">
            <div class="col-sm-7">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Rank Potential Accident Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div id="chartContainer_pyramid" style="height: 400px; width:100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Rank Potential Hazard</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div id="chartContainer2" style="height: 400px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Category Potential Hazard</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="col-md-12 mt-2">
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Laporan Patrol</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div id="chartContainer4" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                        {{-- <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div id="chartContainer3" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>




    </div>






       


    {{-- </div> --}}


    @push('scripts')
    <!-- Add your JavaScript libraries here -->
    <script>
       
    </script>
    <script>


       
       
        document.getElementById('exportScreenshot').addEventListener('click', function() {
            // Mengambil elemen dengan ID "capture"
            var captureElement = document.getElementById("capture");


            // Mengambil tangkapan layar dari elemen dengan ID "capture"
            html2canvas(captureElement).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var link = document.createElement('a');
                link.download = 'Dashboard.png';
                link.href = imgData;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
        document.addEventListener('livewire:load', function () {
            function getResponsiveFontSize() {
                if (window.innerWidth <= 480) {
                    return 4; // Ukuran font untuk layar kecil (ponsel)
                } else if (window.innerWidth <= 768) {
                    return 6; // Ukuran font untuk layar sedang (tablet)
                } else {
                    return 10; // Ukuran font untuk layar besar (desktop)
                }
            }


            $('#time-start').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
                });
            $('#time-end').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
                });
           
            const radioButtons = document.querySelectorAll('input[type="radio"]');


            radioButtons.forEach(radioButton => {
                radioButton.addEventListener('change', () => {
                    livewire.emit('radio_change', radioButton.value);
            });
            });
            var timeStartInput = $('#time-start');
            var timeEndInput = $('#time-end');


            window.addEventListener('updateDate', event => {
                $('#time-start').datepicker('setDate', @this.timeStartPick);
            })


            timeStartInput.on('change', function() {
                livewire.emit('time_start_change', timeStartInput.val());
            });


            timeEndInput.on('change', function() {
                livewire.emit('time_end_change', timeEndInput.val());
            });


            Livewire.hook('message.processed', function (message, component) {
                $('#time-start').datepicker({
                    format: 'dd/mm/yyyy', // Format tampilan
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                    });
                $('#time-end').datepicker({
                    format: 'dd/mm/yyyy', // Format tampilan
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                    });
               
                const radioButtons = document.querySelectorAll('input[type="radio"]');


                radioButtons.forEach(radioButton => {
                    radioButton.addEventListener('change', () => {
                        livewire.emit('radio_change', radioButton.value);
                });
                });
                var timeStartInput = $('#time-start');
                var timeEndInput = $('#time-end');


                window.addEventListener('updateDate', event => {
                    $('#time-start').datepicker('setDate', @this.timeStartPick);
                })


                timeStartInput.on('change', function() {
                    livewire.emit('time_start_change', timeStartInput.val());
                });


                timeEndInput.on('change', function() {
                    livewire.emit('time_end_change', timeEndInput.val());
                });
                // check point


                var jsonDataEHS = document.getElementById('jsonDataEHS').value;
                var temuanEHSJson = JSON.parse(jsonDataEHS);


                var jsonDataGenba = document.getElementById('jsonDataGenba').value;
                var temuanGenbaJson = JSON.parse(jsonDataGenba);


                var areas = @this.areasFound;
                var countOpen = 0
                var countClosed = 0
                var countOpen2 = 0
                var countClosed2 = 0
                var dataPointsOpen = [];
                var dataPointsClosed = [];
                var dataPointsTotal = [];
                var dataPointsOpenGenba = [];
                var dataPointsClosedGenba = [];


                // Proses iterasi untuk mengisi dataPoints
                areas.forEach(function(area) {
                    var countOpen = 0;
                    var countClosed = 0;
                    var countOpen2 = 0;
                    var countClosed2 = 0;


                    temuanEHSJson.forEach(function(temuan) {
                        if (temuan.area_id == area.id) {
                            if(temuan.progress == 13){
                                countClosed += 1;
                            }
                            else {
                                countOpen += 1;
                            }
                        }
                    });


                    temuanGenbaJson.forEach(function(temuan) {
                        if (temuan.area_id == area.id) {
                            if(temuan.progress == 13){
                                countClosed2 += 1;
                            }
                            else {
                                countOpen2 += 1;
                            }
                        }
                    });


                    dataPointsOpen.push({ y: countOpen, label: area.name, toolTipContent:"<span>"+ area.name + "</br>Open: "+ countOpen + "</br>Close: "+ countClosed + "</br>Total: " + (countOpen+countClosed) +"</span>" });
                    dataPointsClosed.push({ y: countClosed, label: area.name, toolTipContent:"<span>"+ area.name + "</br>Open: "+ countOpen + "</br>Close: "+ countClosed  + "</br>Total: " + (countOpen+countClosed) +"</span>" });
                    dataPointsTotal.push({ y: countOpen + countClosed, label: area.name });
                    dataPointsOpenGenba.push({ y: countOpen2, label: area.name });
                    dataPointsClosedGenba.push({ y: countClosed2, label: area.name });
                });


                var chart1 = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    exportEnabled: true,
                    title:{
                        text: "CATEGORY POTENTIAL HAZARD",
                        fontFamily: "arial black",
                        labelFontSize: 12,
                        fontColor: "#695A42"
                    },
                    axisX: {
                        interval: 1,
                    },
                    axisY:{
                        valueFormatString:"#0",
                        gridColor: "#B6B1A8",
                        tickColor: "#B6B1A8"
                    },
                    data: [{
                        type: "stackedColumn",
                        showInLegend: true,
                        color: "green",
                        name: "CLOSED : " + @this.rankClosed,
                        indexLabel: "CLOSED : {y}",
                        indexLabelFontColor: "#EEEEEE",
                        indexLabelFontWeight: "bold",
                        indexLabelFontSize: getResponsiveFontSize(),
                        indexLabelPlacement: "inside",
                        dataPoints: [
                            { y: @this.category5RClosed, label: "5R",toolTipContent: "<span> Open: " + @this.category5ROpen + "</br> Close: " + @this.category5RClosed + "</span>" },
                            { y: @this.categoryAClosed, label: "A",toolTipContent: "<span> Open: " + @this.categoryAOpen + "</br> Close: " + @this.categoryAClosed + "</span>" },
                            { y: @this.categoryBClosed, label: "B",toolTipContent: "<span> Open: " + @this.categoryBOpen + "</br> Close: " + @this.categoryBClosed + "</span>" },
                            { y: @this.categoryCClosed, label: "C",toolTipContent: "<span> Open: " + @this.categoryCOpen + "</br> Close: " + @this.categoryCClosed + "</span>" },
                            { y: @this.categoryDClosed, label: "D",toolTipContent: "<span> Open: " + @this.categoryDOpen + "</br> Close: " + @this.categoryDClosed + "</span>" },
                            { y: @this.categoryEClosed, label: "E",toolTipContent: "<span> Open: " + @this.categoryEOpen + "</br> Close: " + @this.categoryEClosed + "</span>" },
                            { y: @this.categoryFClosed, label: "F",toolTipContent: "<span> Open: " + @this.categoryFOpen + "</br> Close: " + @this.categoryFClosed + "</span>" },
                            { y: @this.categoryGClosed, label: "G",toolTipContent: "<span> Open: " + @this.categoryGOpen + "</br> Close: " + @this.categoryGClosed + "</span>" },
                            { y: @this.categoryOClosed, label: "O",toolTipContent: "<span> Open: " + @this.categoryOOpen + "</br> Close: " + @this.categoryOClosed + "</span>" },
                        ]
                    },
                    {        
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "OPEN : " + @this.rankOpen,
                        color: "red",
                        indexLabel: "OPEN : {y}",
                        indexLabelFontColor: "#EEEEEE",
                        indexLabelFontWeight: "bold",
                        indexLabelFontSize: getResponsiveFontSize(),
                        indexLabelPlacement: "inside",
                        dataPoints: [
                            { y: @this.category5ROpen, label: "5R",toolTipContent: "<span> Open: " + @this.category5ROpen + "</br> Close: " + @this.category5RClosed + "</span>" },
                            { y: @this.categoryAOpen, label: "A",toolTipContent: "<span> Open: " + @this.categoryAOpen + "</br> Close: " + @this.categoryAClosed + "</span>" },
                            { y: @this.categoryBOpen, label: "B",toolTipContent: "<span> Open: " + @this.categoryBOpen + "</br> Close: " + @this.categoryBClosed + "</span>" },
                            { y: @this.categoryCOpen, label: "C",toolTipContent: "<span> Open: " + @this.categoryCOpen + "</br> Close: " + @this.categoryCClosed + "</span>" },
                            { y: @this.categoryDOpen, label: "D",toolTipContent: "<span> Open: " + @this.categoryDOpen + "</br> Close: " + @this.categoryDClosed + "</span>" },
                            { y: @this.categoryEOpen, label: "E",toolTipContent: "<span> Open: " + @this.categoryEOpen + "</br> Close: " + @this.categoryEClosed + "</span>" },
                            { y: @this.categoryFOpen, label: "F",toolTipContent: "<span> Open: " + @this.categoryFOpen + "</br> Close: " + @this.categoryFClosed + "</span>" },
                            { y: @this.categoryGOpen, label: "G",toolTipContent: "<span> Open: " + @this.categoryGOpen + "</br> Close: " + @this.categoryGClosed + "</span>" },
                            { y: @this.categoryOOpen, label: "O",toolTipContent: "<span> Open: " + @this.categoryOOpen + "</br> Close: " + @this.categoryOClosed + "</span>" },
                        ]
                    },
                    {
                        type: "line", // or "column"
                        name: "TOTAL",
                        lineColor:"transparent",
                        markerType: "null",
                        toolTipContent: null,
                        indexLabel: "TOTAL: {y}",
                        indexLabelFontColor: "#000000",
                        indexLabelFontWeight: "bold",
                        indexLabelFontSize: getResponsiveFontSize(),
                        dataPoints: [
                            { y: @this.category5ROpen + @this.category5RClosed, label: "5R" },
                            { y: @this.categoryAOpen + @this.categoryAClosed, label: "A" },
                            { y: @this.categoryBOpen + @this.categoryBClosed, label: "B" },
                            { y: @this.categoryCOpen + @this.categoryCClosed, label: "C" },
                            { y: @this.categoryDOpen + @this.categoryDClosed, label: "D" },
                            { y: @this.categoryEOpen + @this.categoryEClosed, label: "E" },
                            { y: @this.categoryFOpen + @this.categoryFClosed, label: "F" },
                            { y: @this.categoryGOpen + @this.categoryGClosed, label: "G" },
                            { y: @this.categoryOOpen + @this.categoryOClosed, label: "O" },
                        ]
                    }]
                });
                chart1.render();


                var chart2 = new CanvasJS.Chart("chartContainer2", {
                    animationEnabled: true,
                    exportEnabled: true,
                    title:{
                        text: "RANK POTENTIAL HAZARD",
                        fontFamily: "arial black",
                        labelFontSize: 12,
                        fontColor: "#695A42"
                    },
                    axisX: {
                        interval: 1,
                    },
                    axisY:{
                        valueFormatString:"#0",
                        gridColor: "#B6B1A8",
                        tickColor: "#B6B1A8"
                    },
                    data: [{
                        type: "stackedColumn",
                        showInLegend: true,
                        color: "green",
                        name: "CLOSED : " + @this.rankClosed,
                        indexLabel: "CLOSED : {y}",
                        indexLabelFontColor: "#EEEEEE",
                        indexLabelFontWeight: "bold",
                        indexLabelFontSize: getResponsiveFontSize(),
                        indexLabelPlacement: "inside",
                        dataPoints: [
                                { y:  @this.rankAClosed, label: "RANK A",toolTipContent: "<span> RANK A </br> Open: " + @this.rankAOpen + "</br> Close: " + @this.rankAClosed +"</br>Total: "+ (@this.rankAOpen + @this.rankAClosed) +"</span>", color: "green" },
                                { y:  @this.rankBClosed, label: "RANK B",toolTipContent: "<span>RANK B </br> Open: " + @this.rankBOpen + "</br> Close: " + @this.rankBClosed +"</br>Total: "+ (@this.rankBOpen + @this.rankBClosed) + "</span>", color: "green" },
                                { y:  @this.rankCClosed, label: "RANK C",toolTipContent: "<span>RANK C </br> Open: " + @this.rankCOpen + "</br> Close: " + @this.rankCClosed +"</br>Total: " + (@this.rankCOpen + @this.rankCClosed) + "</span>", color: "green" }
                            ]
                    },
                    {        
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "OPEN : " + @this.rankOpen,
                        color: "red",
                        indexLabel: "OPEN : {y}",
                        indexLabelFontSize: getResponsiveFontSize(),
                        indexLabelFontColor: "#EEEEEE",
                        indexLabelFontWeight: "bold",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                                { y:  @this.rankAOpen, label: "RANK A",toolTipContent: "<span> RANK A </br> Open: " + @this.rankAOpen + "</br> Close: " + @this.rankAClosed +"</br>Total: "+ (@this.rankAOpen + @this.rankAClosed) +"</span>", color: "red" },
                                { y:  @this.rankBOpen, label: "RANK B",toolTipContent: "<span>RANK B </br> Open: " + @this.rankBOpen + "</br> Close: " + @this.rankBClosed +"</br>Total: "+ (@this.rankBOpen + @this.rankBClosed) + "</span>", color: "red" },
                                { y:  @this.rankCOpen, label: "RANK C",toolTipContent: "<span>RANK C </br> Open: " + @this.rankCOpen + "</br> Close: " + @this.rankCClosed +"</br>Total: " + (@this.rankCOpen + @this.rankCClosed) + "</span>", color: "red" }
                            ]
                    },
                    {
                        type: "line", // or "column"
                        name: "TOTAL",
                        lineColor:"transparent",
                        markerType: "null",
                        indexLabelFontSize: getResponsiveFontSize(),
                        toolTipContent: null,
                        indexLabel: "TOTAL: {y}",
                        indexLabelFontColor: "#000000",
                        indexLabelFontWeight: "bold",
                        dataPoints: [
                            { y: @this.rankAOpen + @this.rankAClosed, label: "RANK A" },
                            { y: @this.rankBOpen + @this.rankBClosed, label: "RANK B" },
                            { y: @this.rankCOpen + @this.rankCClosed, label: "RANK C" }
                        ]
                    }]
                });
                chart2.render();


                // var chart3 = new CanvasJS.Chart("chartContainer3", {
                //     animationEnabled: true,
                //     exportEnabled: true,
                //     title:{
                //         text: "Genba Management Follow Up",
                //         fontFamily: "arial black",
                //         fontColor: "#695A42"
                //     },
                //     axisX: {
                //         interval: 1,
                //     },
                //     axisY:{
                //         valueFormatString:"#0",
                //         gridColor: "#B6B1A8",
                //         tickColor: "#B6B1A8"
                //     },
                //     toolTip: {
                //         shared: true,
                //         content: toolTipContent
                //     },
                //     data: [{
                //         type: "stackedColumn",
                //         showInLegend: true,
                //         color: "green",
                //         name: "Closed",
                //         dataPoints: dataPointsClosedGenba
                //     },
                //     {        
                //         type: "stackedColumn",
                //         showInLegend: true,
                //         name: "Open",
                //         color: "red",
                //         dataPoints: dataPointsOpenGenba
                //     }]
                // });
                // chart3.render();


                var chart4 = new CanvasJS.Chart("chartContainer4", {
                    animationEnabled: true,
                    exportEnabled: true,
                    title:{
                        text: "EHS PATROL FOLLOW UP",
                        fontFamily: "arial black",
                        fontColor: "#695A42",
                        labelFontSize: 12,
                    },
                    axisX: {
                        labelFontSize: 12,
                    },
                    axisY:{
                        valueFormatString:"#0",
                        gridColor: "#B6B1A8",
                        tickColor: "#B6B1A8",
                        labelFontSize: 12
                    },
                    data: [{
                        type: "stackedColumn",
                        showInLegend: true,
                        color: "green",
                        name: "CLOSED : " + @this.rankClosed,
                        indexLabel: "CLOSED : {y}",
                        indexLabelFontColor: "#EEEEEE",
                        indexLabelFontWeight: "bold",
                        indexLabelPlacement: "inside",
                        indexLabelFontSize: getResponsiveFontSize(),
                        dataPoints: dataPointsClosed
                    },
                    {        
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "OPEN : " + @this.rankOpen,
                        color: "red",
                        indexLabel: "OPEN : {y}",
                        indexLabelFontColor: "#EEEEEE",
                        indexLabelFontWeight: "bold",
                        indexLabelPlacement: "inside",
                        indexLabelFontSize: getResponsiveFontSize(),
                        dataPoints: dataPointsOpen
                    },
                    {
                        type: "line", // or "column"
                        name: "TOTAL",
                        lineColor:"transparent",
                        markerType: "null",
                        toolTipContent: null,
                        indexLabel: "TOTAL: {y}",
                        indexLabelFontColor: "#000000",
                        indexLabelFontWeight: "bold",
                        indexLabelFontSize: getResponsiveFontSize(),
                        dataPoints: dataPointsTotal
                    }]
                });
                chart4.render();


                var chartPyramid = new CanvasJS.Chart("chartContainer_pyramid", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light1",
                    title:{
                        text: "RANK POTENTITAL ACCIDENT REPORT",
                        fontFamily: "arial black",
                        labelFontSize: 12,
                        fontColor:"#695A42"
                    },
                    subtitles:[
                    {
                        text: "TOTAL TEMUAN : "+(@this.rankOpen + @this.rankClosed)+" | CLOSED : "+@this.rankClosed + " | OPEN : "+@this.rankOpen , toolTipContent: "TOTAL TEMUAN: " + (@this.rankOpen + @this.rankClosed) + " OPEN: " + @this.rankOpen + " CLOSED: " + @this.rankClosed,
                        verticalAlign: "bottom",
                        // fontWeight: "regular",
                        // fontSize: 12,


                    }
                    ],
                    data: [{
                        type: "pyramid",
                        yValueFormatString: "#\"\"",
                        indexLabelFontColor: "black",
                        indexLabelFontSize: 13,
                       
                        dataPoints: [
                            // { y: 1, label: "TOTAL TEMUAN : "+(@this.rankOpen + @this.rankClosed)+ " TEMUAN OPEN : "+@this.rankOpen+" TEMUAN CLOSED : "+@this.rankClosed , toolTipContent: "TOTAL TEMUAN: " + (@this.rankOpen + @this.rankClosed) + " OPEN: " + @this.rankOpen + " CLOSED: " + @this.rankClosed, color: "#228B22"  },
                                { y: 1, label: "RANK C : " + (@this.rankCOpen + @this.rankCClosed), toolTipContent: "RANK C : " + (@this.rankCOpen + @this.rankCClosed), color: "#4169E1" },
                                { y: 1, label: "RANK B : " + (@this.rankBOpen + @this.rankBClosed), toolTipContent: "RANK B : " + (@this.rankBOpen + @this.rankBClosed), color: "#FFD700" },
                                { y: 1, label: "RANK A : " + (@this.rankAOpen + @this.rankAClosed), toolTipContent: "RANK A : " + (@this.rankAOpen + @this.rankAClosed), color: "#B22222" },
                        ]
                    }]
                });


                chartPyramid.render();


                function toolTipContent(e) {
                    var str = "";
                    var total = 0;
                    var str2, str3;
                    for (var i = 0; i < e.entries.length; i++) {
                        var str1 = "<span style=\"color:" + e.entries[i].dataSeries.color + "\"> " + e.entries[i].dataSeries.name + "</span> <br/>";
                        total += e.entries[i].dataPoint.y;
                        str += str1;
                    }
                    // for (var i = 0; i < e.entries.length; i++) {
                    //     var str1 = "<span style=\"color:" + e.entries[i].dataSeries.color + "\"> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong><br/>";
                    //     total += e.entries[i].dataPoint.y;
                    //     str += str1;
                    // }
                    str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong><br/>";
                    total = Math.round(total * 100) / 100;
                    str3 = "<span style=\"color:Tomato\">Total:</span> <strong>" + total + "</strong><br/>";
                    return (str2.concat(str)).concat(str3);
                };
               
               
        });
           
            var jsonDataEHS = document.getElementById('jsonDataEHS').value;
            var temuanEHSJson = JSON.parse(jsonDataEHS);


            var jsonDataGenba = document.getElementById('jsonDataGenba').value;
            var temuanGenbaJson = JSON.parse(jsonDataGenba);


            var areas = @this.areasFound;
            var countOpen = 0
            var countClosed = 0
            var countOpen2 = 0
            var countClosed2 = 0
            var dataPointsOpen = [];
            var dataPointsClosed = [];
            var dataPointsTotal = [];
            var dataPointsOpenGenba = [];
            var dataPointsClosedGenba = [];


            // Proses iterasi untuk mengisi dataPoints
            areas.forEach(function(area) {
                var countOpen = 0;
                var countClosed = 0;
                var countOpen2 = 0;
                var countClosed2 = 0;


                temuanEHSJson.forEach(function(temuan) {
                    if (temuan.area_id == area.id) {
                        if(temuan.progress == 13){
                            countClosed += 1;
                        }
                        else {
                            countOpen += 1;
                        }
                    }
                });


                temuanGenbaJson.forEach(function(temuan) {
                    if (temuan.area_id == area.id) {
                        if(temuan.progress == 13){
                            countClosed2 += 1;
                        }
                        else {
                            countOpen2 += 1;
                        }
                    }
                });


                dataPointsOpen.push({ y: countOpen, label: area.name, toolTipContent:"<span>"+ area.name + "</br>Open: "+ countOpen + "</br>Close: "+ countClosed + "</br>Total: " + (countOpen+countClosed) +"</span>" });
                dataPointsClosed.push({ y: countClosed, label: area.name, toolTipContent:"<span>"+ area.name + "</br>Open: "+ countOpen + "</br>Close: "+ countClosed  + "</br>Total: " + (countOpen+countClosed) +"</span>" });
                dataPointsTotal.push({ y: countOpen + countClosed, label: area.name });
                dataPointsOpenGenba.push({ y: countOpen2, label: area.name });
                dataPointsClosedGenba.push({ y: countClosed2, label: area.name });
            });


            var chart1 = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                title:{
                    text: "CATEGORY POTENTIAL HAZARD",
                    fontFamily: "arial black",
                    labelFontSize: 12,
                    fontColor: "#695A42"
                },
                axisX: {
                    interval: 1,
                },
                axisY:{
                    valueFormatString:"#0",
                    gridColor: "#B6B1A8",
                    tickColor: "#B6B1A8"
                },
                data: [{
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "green",
                    name: "CLOSED : " + @this.rankClosed,
                    indexLabel: "CLOSED : {y}",
                    indexLabelFontColor: "#EEEEEE",
                    indexLabelFontWeight: "bold",
                    indexLabelFontSize: getResponsiveFontSize(),
                    indexLabelPlacement: "inside",
                    dataPoints: [
                        { y: @this.category5RClosed, label: "5R",toolTipContent: "<span> Open: " + @this.category5ROpen + "</br> Close: " + @this.category5RClosed + "</span>" },
                        { y: @this.categoryAClosed, label: "A",toolTipContent: "<span> Open: " + @this.categoryAOpen + "</br> Close: " + @this.categoryAClosed + "</span>" },
                        { y: @this.categoryBClosed, label: "B",toolTipContent: "<span> Open: " + @this.categoryBOpen + "</br> Close: " + @this.categoryBClosed + "</span>" },
                        { y: @this.categoryCClosed, label: "C",toolTipContent: "<span> Open: " + @this.categoryCOpen + "</br> Close: " + @this.categoryCClosed + "</span>" },
                        { y: @this.categoryDClosed, label: "D",toolTipContent: "<span> Open: " + @this.categoryDOpen + "</br> Close: " + @this.categoryDClosed + "</span>" },
                        { y: @this.categoryEClosed, label: "E",toolTipContent: "<span> Open: " + @this.categoryEOpen + "</br> Close: " + @this.categoryEClosed + "</span>" },
                        { y: @this.categoryFClosed, label: "F",toolTipContent: "<span> Open: " + @this.categoryFOpen + "</br> Close: " + @this.categoryFClosed + "</span>" },
                        { y: @this.categoryGClosed, label: "G",toolTipContent: "<span> Open: " + @this.categoryGOpen + "</br> Close: " + @this.categoryGClosed + "</span>" },
                        { y: @this.categoryOClosed, label: "O",toolTipContent: "<span> Open: " + @this.categoryOOpen + "</br> Close: " + @this.categoryOClosed + "</span>" },
                    ]
                },
                {        
                    type: "stackedColumn",
                    showInLegend: true,
                    name: "OPEN : " + @this.rankOpen,
                    color: "red",
                    indexLabel: "OPEN : {y}",
                    indexLabelFontColor: "#EEEEEE",
                    indexLabelFontWeight: "bold",
                    indexLabelFontSize: getResponsiveFontSize(),
                    indexLabelPlacement: "inside",
                    dataPoints: [
                        { y: @this.category5ROpen, label: "5R",toolTipContent: "<span> Open: " + @this.category5ROpen + "</br> Close: " + @this.category5RClosed + "</span>" },
                        { y: @this.categoryAOpen, label: "A",toolTipContent: "<span> Open: " + @this.categoryAOpen + "</br> Close: " + @this.categoryAClosed + "</span>" },
                        { y: @this.categoryBOpen, label: "B",toolTipContent: "<span> Open: " + @this.categoryBOpen + "</br> Close: " + @this.categoryBClosed + "</span>" },
                        { y: @this.categoryCOpen, label: "C",toolTipContent: "<span> Open: " + @this.categoryCOpen + "</br> Close: " + @this.categoryCClosed + "</span>" },
                        { y: @this.categoryDOpen, label: "D",toolTipContent: "<span> Open: " + @this.categoryDOpen + "</br> Close: " + @this.categoryDClosed + "</span>" },
                        { y: @this.categoryEOpen, label: "E",toolTipContent: "<span> Open: " + @this.categoryEOpen + "</br> Close: " + @this.categoryEClosed + "</span>" },
                        { y: @this.categoryFOpen, label: "F",toolTipContent: "<span> Open: " + @this.categoryFOpen + "</br> Close: " + @this.categoryFClosed + "</span>" },
                        { y: @this.categoryGOpen, label: "G",toolTipContent: "<span> Open: " + @this.categoryGOpen + "</br> Close: " + @this.categoryGClosed + "</span>" },
                        { y: @this.categoryOOpen, label: "O",toolTipContent: "<span> Open: " + @this.categoryOOpen + "</br> Close: " + @this.categoryOClosed + "</span>" },
                    ]
                },
                {
                    type: "line", // or "column"
                    name: "TOTAL",
                    lineColor:"transparent",
                    markerType: "null",
                    toolTipContent: null,
                    indexLabel: "TOTAL: {y}",
                    indexLabelFontColor: "#000000",
                    indexLabelFontSize: getResponsiveFontSize(),
                    indexLabelFontWeight: "bold",
                    dataPoints: [
                        { y: @this.category5ROpen + @this.category5RClosed, label: "5R" },
                        { y: @this.categoryAOpen + @this.categoryAClosed, label: "A" },
                        { y: @this.categoryBOpen + @this.categoryBClosed, label: "B" },
                        { y: @this.categoryCOpen + @this.categoryCClosed, label: "C" },
                        { y: @this.categoryDOpen + @this.categoryDClosed, label: "D" },
                        { y: @this.categoryEOpen + @this.categoryEClosed, label: "E" },
                        { y: @this.categoryFOpen + @this.categoryFClosed, label: "F" },
                        { y: @this.categoryGOpen + @this.categoryGClosed, label: "G" },
                        { y: @this.categoryOOpen + @this.categoryOClosed, label: "O" },
                    ]
                }]
            });
            chart1.render();


            var chart2 = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                exportEnabled: true,
                title:{
                    text: "RANK POTENTIAL HAZARD",
                    fontFamily: "arial black",
                    labelFontSize: 12,
                    fontColor: "#695A42"
                },
                axisX: {
                    interval: 1,
                },
                axisY:{
                    valueFormatString:"#0",
                    gridColor: "#B6B1A8",
                    tickColor: "#B6B1A8"
                },
                data: [{
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "green",
                    name: "CLOSED : " + @this.rankClosed,
                    indexLabel: "CLOSED : {y}",
                    indexLabelFontColor: "#EEEEEE",
                    indexLabelFontWeight: "bold",
                    indexLabelFontSize: getResponsiveFontSize(),
                    indexLabelPlacement: "inside",
                    dataPoints: [
                            { y:  @this.rankAClosed, label: "RANK A",toolTipContent: "<span> RANK A </br> Open: " + @this.rankAOpen + "</br> Close: " + @this.rankAClosed +"</br>Total: "+ (@this.rankAOpen + @this.rankAClosed) +"</span>", color: "green" },
                            { y:  @this.rankBClosed, label: "RANK B",toolTipContent: "<span>RANK B </br> Open: " + @this.rankBOpen + "</br> Close: " + @this.rankBClosed +"</br>Total: "+ (@this.rankBOpen + @this.rankBClosed) + "</span>", color: "green" },
                            { y:  @this.rankCClosed, label: "RANK C",toolTipContent: "<span>RANK C </br> Open: " + @this.rankCOpen + "</br> Close: " + @this.rankCClosed +"</br>Total: " + (@this.rankCOpen + @this.rankCClosed) + "</span>", color: "green" }
                        ]
                },
                {        
                    type: "stackedColumn",
                    showInLegend: true,
                    name: "OPEN : " + @this.rankOpen,
                    color: "red",
                    indexLabel: "OPEN : {y}",
                    indexLabelFontSize: getResponsiveFontSize(),
                    indexLabelFontColor: "#EEEEEE",
                    indexLabelFontWeight: "bold",
                    indexLabelPlacement: "inside",
                    dataPoints: [
                            { y:  @this.rankAOpen, label: "RANK A",toolTipContent: "<span> RANK A </br> Open: " + @this.rankAOpen + "</br> Close: " + @this.rankAClosed +"</br>Total: "+ (@this.rankAOpen + @this.rankAClosed) +"</span>", color: "red" },
                            { y:  @this.rankBOpen, label: "RANK B",toolTipContent: "<span>RANK B </br> Open: " + @this.rankBOpen + "</br> Close: " + @this.rankBClosed +"</br>Total: "+ (@this.rankBOpen + @this.rankBClosed) + "</span>", color: "red" },
                            { y:  @this.rankCOpen, label: "RANK C",toolTipContent: "<span>RANK C </br> Open: " + @this.rankCOpen + "</br> Close: " + @this.rankCClosed +"</br>Total: " + (@this.rankCOpen + @this.rankCClosed) + "</span>", color: "red" }
                        ]
                },
                {
                    type: "line", // or "column"
                    name: "TOTAL",
                    lineColor:"transparent",
                    markerType: "null",
                    indexLabelFontSize: getResponsiveFontSize(),
                    toolTipContent: null,
                    indexLabel: "TOTAL: {y}",
                    indexLabelFontColor: "#000000",
                    indexLabelFontWeight: "bold",
                    dataPoints: [
                        { y: @this.rankAOpen + @this.rankAClosed, label: "RANK A" },
                        { y: @this.rankBOpen + @this.rankBClosed, label: "RANK B" },
                        { y: @this.rankCOpen + @this.rankCClosed, label: "RANK C" }
                    ]
                }]
            });
            chart2.render();


            // var chart3 = new CanvasJS.Chart("chartContainer3", {
            //     animationEnabled: true,
            //     exportEnabled: true,
            //     title:{
            //         text: "Genba Management Follow Up",
            //         fontFamily: "arial black",
            //         fontColor: "#695A42"
            //     },
            //     axisX: {
            //         interval: 1,
            //     },
            //     axisY:{
            //         valueFormatString:"#0",
            //         gridColor: "#B6B1A8",
            //         tickColor: "#B6B1A8"
            //     },
            //     toolTip: {
            //         shared: true,
            //         content: toolTipContent
            //     },
            //     data: [{
            //         type: "stackedColumn",
            //         showInLegend: true,
            //         color: "green",
            //         name: "Closed",
            //         dataPoints: dataPointsClosedGenba
            //     },
            //     {        
            //         type: "stackedColumn",
            //         showInLegend: true,
            //         name: "Open",
            //         color: "red",
            //         dataPoints: dataPointsOpenGenba
            //     }]
            // });
            // chart3.render();


            var chart4 = new CanvasJS.Chart("chartContainer4", {
                animationEnabled: true,
                exportEnabled: true,
                title:{
                    text: "EHS PATROL FOLLOW UP",
                    fontFamily: "arial black",
                    fontColor: "#695A42",
                    labelFontSize: 12,
                },
                axisX: {
                    labelFontSize: 12,
                },
                axisY:{
                    valueFormatString:"#0",
                    gridColor: "#B6B1A8",
                    tickColor: "#B6B1A8",
                    labelFontSize: 12
                },
                data: [{
                    type: "stackedColumn",
                    showInLegend: true,
                    color: "green",
                    name: "CLOSED : " + @this.rankClosed,
                    indexLabel: "CLOSED : {y}",
                    indexLabelFontColor: "#EEEEEE",
                    indexLabelFontWeight: "bold",
                    indexLabelPlacement: "inside",
                    indexLabelFontSize: getResponsiveFontSize(),
                    dataPoints: dataPointsClosed
                },
                {        
                    type: "stackedColumn",
                    showInLegend: true,
                    name: "OPEN : " + @this.rankOpen,
                    color: "red",
                    indexLabel: "OPEN : {y}",
                    indexLabelFontColor: "#EEEEEE",
                    indexLabelFontWeight: "bold",
                    indexLabelPlacement: "inside",
                    indexLabelFontSize: getResponsiveFontSize(),
                    dataPoints: dataPointsOpen
                },
                {
                    type: "line", // or "column"
                    name: "TOTAL",
                    lineColor:"transparent",
                    markerType: "null",
                    toolTipContent: null,
                    indexLabel: "TOTAL: {y}",
                    indexLabelFontColor: "#000000",
                    indexLabelFontWeight: "bold",
                    indexLabelFontSize: getResponsiveFontSize(),
                    dataPoints: dataPointsTotal
                }]
            });
            chart4.render();


            var chartPyramid = new CanvasJS.Chart("chartContainer_pyramid", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1",
                title:{
                    text: "RANK POTENTITAL ACCIDENT REPORT",
                    fontFamily: "arial black",
                    labelFontSize: 12,
                    fontColor:"#695A42"
                },
                subtitles:[
                {
                    text: "TOTAL TEMUAN : "+(@this.rankOpen + @this.rankClosed)+" | CLOSED : "+@this.rankClosed + " | OPEN : "+@this.rankOpen , toolTipContent: "TOTAL TEMUAN: " + (@this.rankOpen + @this.rankClosed) + " OPEN: " + @this.rankOpen + " CLOSED: " + @this.rankClosed,
                    verticalAlign: "bottom",
                    // fontWeight: "regular",
                    // fontSize: 12,


                }
                ],
                data: [{
                    type: "pyramid",
                    yValueFormatString: "#\"\"",
                    indexLabelFontColor: "black",
                    indexLabelFontSize: getResponsiveFontSize(),
                   
                    dataPoints: [
                        // { y: 1, label: "TOTAL TEMUAN : "+(@this.rankOpen + @this.rankClosed)+ " TEMUAN OPEN : "+@this.rankOpen+" TEMUAN CLOSED : "+@this.rankClosed , toolTipContent: "TOTAL TEMUAN: " + (@this.rankOpen + @this.rankClosed) + " OPEN: " + @this.rankOpen + " CLOSED: " + @this.rankClosed, color: "#228B22"  },
                            { y: 1, label: "RANK C : " + (@this.rankCOpen + @this.rankCClosed), toolTipContent: "RANK C : " + (@this.rankCOpen + @this.rankCClosed), color: "#4169E1" },
                            { y: 1, label: "RANK B : " + (@this.rankBOpen + @this.rankBClosed), toolTipContent: "RANK B : " + (@this.rankBOpen + @this.rankBClosed), color: "#FFD700" },
                            { y: 1, label: "RANK A : " + (@this.rankAOpen + @this.rankAClosed), toolTipContent: "RANK A : " + (@this.rankAOpen + @this.rankAClosed), color: "red" },
                    ]
                }]
            });


            chartPyramid.render();


            function toolTipContent(e) {
                var str = "";
                var total = 0;
                var str2, str3;
                for (var i = 0; i < e.entries.length; i++) {
                    var str1 = "<span style=\"color:" + e.entries[i].dataSeries.color + "\"> " + e.entries[i].dataSeries.name + "</span> <br/>";
                    total += e.entries[i].dataPoint.y;
                    str += str1;
                }
                // for (var i = 0; i < e.entries.length; i++) {
                //     var str1 = "<span style=\"color:" + e.entries[i].dataSeries.color + "\"> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong><br/>";
                //     total += e.entries[i].dataPoint.y;
                //     str += str1;
                // }
                str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong><br/>";
                total = Math.round(total * 100) / 100;
                str3 = "<span style=\"color:Tomato\">Total:</span> <strong>" + total + "</strong><br/>";
                return (str2.concat(str)).concat(str3);
            };
           
           
    });
    </script>
@endpush
