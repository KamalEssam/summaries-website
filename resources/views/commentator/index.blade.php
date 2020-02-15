@extends('layouts.app')
@section('title','المعلقين')

@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ $message }}
</div>
@endif

<!--begin:: Widgets/Application Sales-->
<div class="m-portlet m-portlet--full-height  m-portlet--unair">

    <div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">المعلقين</h3>
			</div>
        </div>
        
		<div class="m-portlet__head-tools">
            <a href="/commentators/create"><button class="btn btn-primry">أضافة</button></a>
		</div>
    </div>

    <div class="m-portlet__body">
        <div class="tab-content">

            <!--begin::Widget 11--> 
            <div class="m-widget11">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped m-table">
                        <!--begin::Thead-->
                        <thead>
                            <tr>
                                <td width="10%">#</td>
                                <td width="70%">الاسم</td>
                                <td width="10%">تعديل</td>
                                <td width="10%">حذف</td>
                            </tr>
                        </thead>
                        <!--end::Thead-->
                        <!--begin::Tbody-->
                        <tbody>
                            @if(count($commentators) > 0)
                                @foreach($commentators as $commentator)
                                <tr>
                                    <td width="10%">{{ $commentator->id }}</td>
                                    <td width="70%">{{ $commentator->name }}</td>
                                    <td width="10%">
                                        <a href="/commentators/{{ $commentator->id }}/edit">
                                            <button type="submit" class="btn btn-xs btn-info">
                                                <i class="flaticon-edit"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td width="10%">
                                        <form action="/commentators/{{ $commentator->id }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="flaticon-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="text-align:center">لا توجد نتائج</td>
                                </tr>
                            @endif

                        </tbody>
                        <!--end::Tbody-->  

                    </table>
                    <!--end::Table-->                        
                </div>
                <div class="m-widget11__action m--align-right">
                {{ $commentators->links() }}

                </div>
            </div>
            <!--end::Widget 11-->

        </div>
    </div>

</div>
<!--end:: Widgets/Application Sales-->  
@endsection