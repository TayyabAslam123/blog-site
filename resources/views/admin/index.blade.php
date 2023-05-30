@extends('admin.layout')
@section('content')
<div class="container-fluid pt-4 px-4">
    <h1 class="display-5 text-center mt-3">{{$title}}</h1>

    <div class="row">
        <!--Add form with in page-->
        @if(!isset($add))
        <div class="col-sm-3">
            <a href="#addme">
                <button class="btn btn-success">Add {{$title}}</button>
            </a>
        </div>
        @endif
        <!--Custom add form-->
        @if(isset($custom_add))
        <div class="col-sm-3">
            <a href="{{$custom_add}}">
                <button class="btn btn-success">ADD {{$title}}</button>
            </a>
        </div>
        @endif

    </div>
    <hr>

    <!--SUCCESS/FAILURE MESSAGES-->
    @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <!-- END -->

    <!--LISTING ALL ENTRIES-->
    <div class="table-responsive">
        <table id="dt" class="table table-striped table-bordered second" style="width:100%">
            <thead>
                <tr>
                    <!--Loop through heading-->
                    @foreach ($headings as $heading)
                        <th scope="col">{{$heading}}</th>
                    @endforeach
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            <tbody id="myTable">
                @foreach ($values as $value)
                <tr>
                    @foreach ($headings as $key=>$paired_value)
                    <td>
                        @if($key=='created_at')
                        {{date('d M Y', strtotime($value->created_at))}}
                        @elseif($key=='updated_at')
                        {{date('d M Y', strtotime($value->updated_at))}}
                        @elseif($key=='date')
                        {{date('d M Y', strtotime($value->date))}}
                        @elseif($key=='image')
                        <img src="{{asset('storage/'.strtolower($title).'/'.$value->image)}}" width="100px" height="100px">
                        @elseif($key=='resume')
                        <a href="{{asset('storage/applicants/'.$value->resume)}}" download>Download Resume..</a>
                        @else
                        {{$value->$key}}
                        @endif
                    </td>
                    @endforeach

                    <!--Actions-->
                    <td>
                  
                        @if(!isset($disable_del))
                            <!--DELETE THE ENTRY-->
                            <form action="{{ $url.'/'.$value->id }}" method="POST" onsubmit="return confirm('Are you sure, You want to delete?')">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-circle "><i class="fa fa-trash"></i></button>
                            </form>
                            <!--END-->
                        @endif

                        @if(!isset($disable_edit))
                            <!--EDIT THE ENTRY-->
                            <a href="{{$url.'/'.$value->id.'/edit'}}">
                                <button class="btn btn-warning btn-circle "><i class="fa fa-pen"></i></button>
                            </a>
                            <!--END-->
                        @endif

                        @if($url=='client')
                        <a href="{{url('/dashboard/plot?client_id='.$value->id)}}" class="btn btn-info">Add / View Plots</a>
                        @endif

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <!--PAGINATIONS-->

        <!--PAGINATIONS END-->

    </div>

    @if(isset($data))
    <!--ADDING ENTRY FORM-->
    <hr class="sidebar-divider">
    <div class="jumbotron" id="addme">
        <h3>Add {{$title}}</h3>
        <form action="{{$url}}" method="POST" enctype='multipart/form-data'>
            @csrf
            <div class="form-group">

                @foreach ($data as $key => $value)
                <div class='form-group'>
                    <label>{{$value['name']}}</label>
                    @if($value['type'] == "select")
                    <select class='form-control select_box_custom' {!! $value['attrib']!!}>
                        @foreach ($value['data'] as $k2 => $dd)
                        <option value='{{$k2}}'>{{$dd}}</option>
                        @endforeach
                    </select>
                    @else
                    <input class='form-control' type="{{$value['type']}}" {!! $value['attrib'] !!}>
                    @endif
                </div>
                @endforeach

            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-lg ">Submit</button>
        </form>

    </div>

</div>
<!--END-->
@endif

<!---SCRIPTS--->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

</script>
<!--END SCRIPTS-->

@endsection
