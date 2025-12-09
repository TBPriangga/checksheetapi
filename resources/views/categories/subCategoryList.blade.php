      @foreach($subcategories as $subcategory)
      <!-- infinite tree child -->
        <ul>
          <li>{{$subcategory->name}}</li> 
          @if(count($subcategory->subcategory))
            @include('categories.subCategoryList',['subcategories' => $subcategory->subcategory])
          @endif
       </ul> 
      @endforeach