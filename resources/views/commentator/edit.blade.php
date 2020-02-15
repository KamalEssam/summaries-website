@extends('layouts.app')
@section('title','تعديل معلق')

@section('content')
<div class="row">

	<div class="col-md-12">
		<!--begin::Portlet-->
        <div class="m-portlet m-portlet--full-height">
  
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">تعديل معلق</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>

            <div class="m-portlet__body">
                <form action="/commentators/{{ request()->route('commentator') }}" method="POST">
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group row">
                        <label class="col-3 col-form-label">اسم المعلق</label>
                        <div class="col-9">
                            <input class="form-control" name="name" value="{{ $commentator->name }}" placeholder="اسم المعلق" />
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-3 col-form-label"></label>
                        <div class="col-9">
                            <input type="submit" class="btn btn-primry" value="تعديل" />
                        </div>
                    </div>
                    
                </from>
            </div>
        </div>
        <!--end::Portlet-->
	</div>


</div>
@endsection