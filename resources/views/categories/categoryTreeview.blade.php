@extends('layouts.app-master')

@section('content')
  <div class="bg-light p-4 rounded">
    <h2>Category</h2>
    <div class="lead">
        <!-- Add new Document. -->
    </div>
    <!-- {{auth()->user()->id}} -->
    <div class="container mt-4">
      <!-- parent -->
      @foreach($parentCategories as $category)
       
        {{$category->name}}

        <!-- {{$category->subcategory}} -->

        @if(count($category->subcategory))
          @include('categories.subCategoryList',['subcategories' => $category->subcategory])
        @endif
       
      @endforeach
    </div>       
  </div>
@endsection