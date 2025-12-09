@extends('layouts.app-master')

@section('content')

<div class="bg-light p-4 rounded">
  @foreach ($departments as $key2 => $dept)
    @if ($dept_id == $dept->id)      
      <h2>{{ $dept->code }} Documents</h2>
    @endif
  @endforeach
  <div class="lead">       
    <!-- cek jika ada dokumen yang expired -->    
    @if($check_date_exp > 0)
      <div class="accordion accordion-flush text-danger" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header text-danger" id="flush-headingOne">
            <button class="accordion-button collapsed text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              There are <b> ({{$total_date_exp}}) </b> documents expiring soon.
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              @foreach ($files_exp as $key => $file)

                @if($file->doc_date_exp)
                  <?php
                  $date_exp = $file->doc_date_exp;
                  $date_exp_n = date_create($date_exp);
                  $date_exp_n = date_format($date_exp_n,"Y-m-d");
                  // echo $date_exp_n;
                  // echo $date_exp."<br/>";
                  $orderdate=$date_exp;
                  $orderdate = explode('-', $orderdate);
                  $day   = $orderdate[2];
                  $month = $orderdate[1];
                  $year  = $orderdate[0];

                  $date_exp = Carbon\Carbon::create($year, $month, $day, 0);
                  // expire date
                  // echo $date_exp."<br/>"; // sampai sini udah benar exp date nya

                  // 1 month to expired
                  $date_exp_2mo = $date_exp->subMonth(2);
                  // echo $date_exp_2mo."<br/>"; 
                  // if curr_date >= 2-mo-to-exp && curr_date <= date_exp
                  // if (($current_date >= $date_exp_2mo) && ($current_date <= $date_exp)) {
                  // jika ada dokumen yang expired
                  if (($current_date >= $date_exp_2mo) || ($current_date >= $date_exp)) {
                    // echo $file->doc_name;
                    // echo " masuk ke masa tenggang expired di ".$date_exp."<br/>";
                      echo $file->doc_name;
                    // echo " expired di ".$date_exp."<br/>"; 
                    $originalDate = $date_exp->addMonth(2);
                    $newDate = date("Y-m-d", strtotime($originalDate));                       
                      // echo " expired di ".$newDate."<br/>";                          
                      // echo " expired di ".$date_exp."<br/>";                          
                      echo " expired di ".$date_exp_n."<br/>";                          
                  } 
                ?>
                @endif

              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endif
    <!-- cek jika ada dokumen yang expired end -->
    <br/>
    <a href="{{ route('files.create') }}" class="btn btn-primary btn-sm float-left">Add Document</a>
    <br/><br/>
    <div class="mb-3">
      <label for="category_id" class="label">Categories :</label>

      <form action="">
        <select class="" id="category_id" name="category_id">        
          <option value="" selected="selected"> All Categories </option>
          @foreach($parentCategories as $category)   
            <option value="{{$category->id}}"> {{$category->name}} </option>
            @if(count($category->subcategory))
              @include('categories.subCategoryIndex',['subcategories' => $category->subcategory])
            @endif       
          @endforeach
        </select>
        <input type="submit" class="btn btn-sm btn-primary" value="Search"/>
      </form>

    </div>
  </div>

  <div class="mt-2">
    @include('layouts.partials.messages')
  </div>

  <table id="datatable" class="display">
    <thead>
      <tr>
        <th>No</th>
        <th>Dept.</th>
        <th>No. Dok</th>
        <th>Name</th>
        <th>Tanggal</th>
        <th>Tanggal Exp.</th>
        <th>Notes</th>
        <!-- <th>Size</th> -->
        <!-- <th>Type</th> -->
        <th>Upload By</th>
        <th>Upload At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody> 
      @foreach ($files as $key => $file)
      <tr>
        <td>{{ $loop->iteration + (($files->currentPage() -1) * $files->perPage())  }}</td>
        <td>
          @foreach ($departments as $key2 => $dept)
            @if ($file->dept_id == $dept->id)
              {{ $dept->name }}<br/>
            @endif
          @endforeach

          @foreach ($categories as $key3 => $cat)
            @if ($file->category_id == $cat->id)
              <span class="badge" style="color:#333; font-size: 14px;">{{ $cat->name }}</span>
              @break
            @endif
          @endforeach

        </td>
        <td>{{ $file->doc_number }}</td>
        <td>{{ $file->doc_name }}</td>
        <td>{{ $file->doc_date }}</td>
        <td>{{ $file->doc_date_exp }}</td>
        <td>{{ $file->doc_note }}</td>
        <!-- <td>{{ $file->doc_size }}</td> -->
        <!-- <td>{{ $file->doc_type }}</td> -->
        <td>
          @foreach ($users as $key3 => $user)
            @if ($file->created_by == $user->id)
              {{ $user->name }}
            @endif
          @endforeach
        </td>
        <td>{{ $file->created_at }}</td>
        <td>
          <!-- <a href="{{url('')}}/file/{{ $file->doc_name }}" target="_newtab">Download</a> -->
          <a href="{{url('')}}/files/{{$file->id}}/downloadfile" target="_newtab">Download</a>
          <br/><br/><br/>
          {!! Form::open(['method' => 'DELETE','route' => ['files.destroy', $file->id],'style'=>'display:inline']) !!}
          {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure?")']) !!}
          {!! Form::close() !!}
        </td>
      </tr>
      @endforeach
    </tbody>         
  </table>

  <div class="d-flex">
    {!! $files->links() !!}

    &nbsp; 
    <div style="position: relative; left: 50px;"><a href="{{ route('files.create') }}" class="btn btn-primary btn-sm float-left">Add Document</a></div> 
  </div>

</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#datatable').DataTable({
        // "pageLength": 2
      });
  } );
</script>
@endpush
