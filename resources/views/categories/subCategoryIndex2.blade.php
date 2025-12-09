@foreach($subcategories as $subcategory)
  <option value="{{$subcategory->id}}">---{{$subcategory->name}}</option> 
  @if(count($subcategory->subcategory))
    @include('categories.subCategoryIndex3',['subcategories' => $subcategory->subcategory])
  @endif
@endforeach