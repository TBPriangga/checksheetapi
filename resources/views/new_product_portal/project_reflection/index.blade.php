@extends('layouts.app-master')

@section('content')
    {{-- datatable library css --}}
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <script src="{{asset('js/js_agil/index.global1.js')}}"></script>
    <script src="{{asset('js/js_agil/index.global.min.js')}}"></script>
    <!-- ChartJS-->
    <script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>

    <!-- Sweet Alert -->
    <div class="ibox" >
        <div class="ibox-title">
            <h4>Project Reflection</h4>
        </div>
        <div class="ibox-content">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            
            <div class="row">
                <div class="col-2">
                    <label for="">Customer</label>
                    <select name="customer_search" id="customer_search" class="form-control">
                        <option value="">-</option>
                        @foreach ($customers as $customer)
                            <option value="{{$customer->code}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Project</label>
                    <select name="project_search" id="project_search" class="form-control">
                        <option value="">-</option>
                        @foreach ($projects as $project)
                            <option value="{{$project->project_title}}">{{$project->project_title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Product</label>
                    <select name="product_search" id="product_search" class="form-control">
                        <option value="">-</option>
                        @foreach ($products as $product)
                            <option value="{{$product->product}}">{{$product->product}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Milestone</label>
                    <select name="milestone_search" id="milestone_search" class="form-control">
                        <option value="">-</option>
                        @foreach ($milestones as $milestone)
                            <option value="{{$milestone->milestone}}">{{$milestone->milestone}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="">Departement</label>
                    <select name="dept_search" id="dept_search" class="form-control">
                        <option value="">-</option>
                        @foreach ($depts as $dept)
                            <option value="{{$dept->code}}">{{$dept->code}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="ibox mt-2">
                <div class="ibox-title">
                    <h5>Departement Progress</h5>
                </div>
                <div class="ibox-content">
                    <div class="text-right">
                        <button class="btn btn-default" id="capture-button"><i class="fa fa-download"></i> DOWNLOAD</button>
                    </div>
                    <div class="row dept_charts" id="dept_charts">
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')

<script type="text/javascript">

  $(document).ready(function() {

    $("#project_search, #customer_search, #dept_search,#product_search,#milestone_search").change(function(){
        var project = $('#project_search').val(); 
        var product = $('#product_search').val(); 
        var customer = $('#customer_search').val(); 
        var dept = $('#dept_search').val(); 
        var milestone = $('#milestone_search').val(); 

        var check = $.ajax({
                    url: "{{route('project_reflection.index')}}",
                    type: "get",
                    data: {
                        _token: '{{csrf_token()}}',
                        project: project,
                        customer: customer,
                        dept: dept,
                        product: product,
                        milestone: milestone,
                    },
                    success: function (res) {
                        $('.dept_charts').empty();
                        var milestone_all = JSON.parse(res['milestone_all']);
                        var milestone_selesai = JSON.parse(res['milestone_selesai']);
                        var data_delay = JSON.parse(res['data_delay']);
                        var array_per_milestone= [];
                        milestone_all.forEach(milestone => {
                            array_per_milestone[(milestone.milestone+"_"+"all").replace(/\s/g, '')]=milestone.count_milestone;
                            milestone_selesai.forEach(ms => {
                                if (ms.milestone == milestone.milestone) {
                                    var insert = array_per_milestone[(milestone.milestone+"_"+"selesai").replace(/\s/g, '')]=ms.count_milestone;
                                }else{
                                    // array_per_milestone[(milestone.milestone+"_"+"selesai").replace(/\s/g, '')]=0;
                                }
                            });
                       });

                       var persen_tooling_manufacturing =isNaN(array_per_milestone.ToolingManufacturing_selesai / array_per_milestone.ToolingManufacturing_all) ? 0:(array_per_milestone.ToolingManufacturing_selesai / array_per_milestone.ToolingManufacturing_all)*100;
                       var persen_product_study =isNaN(array_per_milestone.ProductStudy_selesai / array_per_milestone.ProductStudy_all) ? 0:(array_per_milestone.ProductStudy_selesai / array_per_milestone.ProductStudy_all)*100;
                       var persen_product_design =isNaN(array_per_milestone.ProductDesign_selesai / array_per_milestone.ProductDesign_all) ? 0:(array_per_milestone.ProductDesign_selesai / array_per_milestone.ProductDesign_all)*100;
                       var persen_homeline_trial =isNaN(array_per_milestone.HomelineTrial_selesai / array_per_milestone.HomelineTrial_all) ? 0:(array_per_milestone.HomelineTrial_selesai / array_per_milestone.HomelineTrial_all)*100;
                       
                        //product study Set the width of the progress bar
                            $('#product_study').css('width', persen_product_study + '%');
                            $('#product_study').attr('aria-valuenow', persen_product_study);
                            $('#product_study').html(persen_product_study.toFixed(2)+"%");
                        //tooling Manufacturing Set the width of the progress bar
                            $('#tooling_manufacturing').css('width', persen_tooling_manufacturing + '%');
                            $('#tooling_manufacturing').attr('aria-valuenow', persen_tooling_manufacturing);
                            $('#tooling_manufacturing').html(persen_tooling_manufacturing.toFixed(2)+"%");
                        //Product design Set the width of the progress bar
                            $('#product_design').css('width', persen_product_design + '%');
                            $('#product_design').attr('aria-valuenow', persen_product_design);
                            $('#product_design').html(persen_product_design.toFixed(2)+"%");
                        //Home line trial Set the width of the progress bar 
                            $('#homeline_trial').css('width', persen_homeline_trial + '%');
                            $('#homeline_trial').attr('aria-valuenow', persen_homeline_trial);
                            $('#homeline_trial').html(persen_homeline_trial.toFixed(2)+"%");

                        // set polar data milestone
                        var data = [
                                        Math.abs(persen_product_study.toFixed(0)),Math.abs(persen_product_design.toFixed(0)),Math.abs(persen_tooling_manufacturing.toFixed(0)),Math.abs(persen_homeline_trial.toFixed(0))
                                    ];

                                    // chart_milestone.data.datasets[0].data=data;
                                    // chart_milestone.update();


                        // set polar data dept charts
                            var dept_pic_all= JSON.parse(res['dept_pic_all']);
                            var dept_pic_selesai= JSON.parse(res['dept_pic_selesai']);
                            var array_per_dept= [];
                            var array_per_dept_obj= [];
                            var modernColors = [
                                'rgba(75, 192, 192, 0.7)',   // Teal
                                'rgba(128, 128, 128, 0.7)', // Gray
                                'rgba(255, 159, 64, 0.7)',  // Orange
                                'rgba(255, 205, 86, 0.7)',  // Yellow
                                'rgba(54, 162, 235, 0.7)',  // Blue
                                'rgba(153, 102, 255, 0.7)', // Purple
                                'rgba(255, 0, 0, 0.7)',     // Bright Red
                                'rgba(0, 255, 0, 0.7)',     // Bright Green
                                'rgba(0, 0, 255, 0.7)',     // Bright Blue
                                'rgba(255, 128, 0, 0.7)',   // Orange-Red
                                'rgba(255, 0, 255, 0.7)',   // Magenta
                                'rgba(0, 255, 255, 0.7)',   // Cyan
                                'rgba(128, 0, 128, 0.7)',   // Purple
                                'rgba(0, 128, 128, 0.7)',   // Teal
                                'rgba(128, 0, 0, 0.7)',     // Maroon
                                'rgba(0, 128, 0, 0.7)',     // Green
                                'rgba(0, 0, 128, 0.7)',     // Navy
                                'rgba(255, 99, 132, 0.7)',  // Red
                                'rgba(255, 255, 0, 0.7)',   // Yellow
                                'rgba(255, 255, 255, 0.7)', // White
                                'rgba(128, 128, 0, 0.7)',   // Olive
                                'rgba(128, 0, 128, 0.7)',   // Purple
                                'rgba(0, 128, 128, 0.7)',   // Teal
                                'rgba(0, 0, 0, 0.7)'        // Black
                                ];

                            dept_pic_all.forEach(dept => {
                                    // set qty all task
                                        array_per_dept[(dept.pic+"_"+"all").replace(/\s/g, '')]=dept.count_all_dept_task;
                                    // set qty selesai
                                        dept_pic_selesai.forEach(dept_selesai => {
                                            if (dept_selesai.pic == dept.pic) {
                                                var insert = array_per_dept[(dept.pic+"_"+"selesai").replace(/\s/g, '')]=dept_selesai.count_selesai_dept_task;
                                            }else{
                                                array_per_dept[(dept.pic+"_"+"selesai").replace(/\s/g, '')]=0;
                                            }
                                        });
                                    // set persen all/selesai %
                                        var delay_qty = 0;
                                        data_delay.forEach(item => {
                                            if (dept.pic == item.pic) {
                                                delay_qty = delay_qty + 1;
                                            }
                                        });
                                        var persen = (array_per_dept[(dept.pic+"_"+"selesai").replace(/\s/g, '')])/ array_per_dept[(dept.pic+"_"+"all").replace(/\s/g, '')];
                                        var persen_delay = (delay_qty)/ array_per_dept[(dept.pic+"_"+"all").replace(/\s/g, '')];
                                        
                                        console.log(persen,persen_delay);
                                        if (persen === Infinity || isNaN(persen) ) {
                                            persen = 0;
                                        }else{
                                            persen = (persen*100).toFixed(0);
                                        }
                                        if (persen_delay === Infinity ) {
                                            persen_delay = 0;
                                        }else{
                                            persen_delay = (persen_delay*100).toFixed(0);
                                        }
                                        var persen_all_belum_action = 100-persen-persen_delay;
                                        const obj = { dept: dept.pic, value: persen, delay:persen_delay, persen_sisa:persen_all_belum_action };
                                        array_per_dept_obj.push(obj);
                            });console.log(array_per_dept_obj);
                               
                            array_per_dept_obj.forEach((data, index) => {
                                                        //  set head title
                                                        var head_title = null;
                                                        head_title= data.dept;
                                                        
                                                        const canvas = document.createElement('canvas');
                                                        const columnDiv = $('<div></div>').addClass('col-lg-4');
                                                        const columnDiv2 = $('<div class="mt-3">Delay:</br></div>').addClass('col-lg-2');
                                                        canvas.id = `polarAreaChart${index}`;
                                                        columnDiv.append("<div class='row'><div class='col-12 text-center border mt-2'><h3>"+head_title+"</h3></div></div>");
                                                        columnDiv.append(canvas);
                                                        $('.dept_charts').append(columnDiv);
                                                        // foreach insert button detail
                                                        data_delay.forEach(item => {
                                                            if (data.dept == item.pic) {
                                                               columnDiv2.append("=> "+item.project_title+"-"+item.product+"-"+item.event+"("+item.detail_description+")</br>");
                                                            }
                                                        });
                                                        $('.dept_charts').append(columnDiv2);

                                                        const ctx = canvas.getContext('2d');
                                                        const chartData = {
                                                            labels: ["DONE (%)","NOT PROGRESS (%)","DELAY (%)"],
                                                            datasets: [{
                                                                data: [data.value, data.persen_sisa,data.delay], // You can adjust the data values as needed
                                                                backgroundColor: [
                                                                    '#88db8b',
                                                                    'rgba(229, 218, 224, 0.4)',
                                                                    'rgba(255, 99, 132, 0.7)'
                                                                ],
                                                            }],
                                                        };

                                                        new Chart(ctx, {
                                                            type: 'pie',
                                                            data: chartData,
                                                            options: {
                                                                plugins: {
                                                                    legend: {
                                                                        display: true, // Display the legend
                                                                    },
                                                                    tooltip: {
                                                                    },
                                                                }
                                                            }
                                                        });
                                                        delay_qty=0;

                                });
 
                    }
        });

    });

    

     // download
     $("#capture-button").click(function(){
            html2canvas(document.querySelector("#dept_charts")).then(canvas => {
                const imageDataURL = canvas.toDataURL('image/png');
                // Create a temporary link to download the image
                const a = document.createElement('a');
                a.href = imageDataURL;
                a.download = 'captured-image.png';

                // Simulate a click event to trigger the download
                a.click();
            });
        });

  

  });
    

</script>
<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/js_agil/html2canvas.min.js')}}"></script>


@endpush
