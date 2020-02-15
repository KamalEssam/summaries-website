@extends('layouts.app')
@section('title','المباريات')

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
		<div class="m-portlet__head-caption"  style="width:70%;">                
            <form method="get" action="/matches" style="width:100%;">
                <div class="row">

                    <div class="col-md-3">
                        <select class="form-control" name="month">
                            <option value="">شهر</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '01' ? 'selected' : '' }} value="01">يناير</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '02' ? 'selected' : '' }} value="02">فبراير</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '03' ? 'selected' : '' }} value="03">مارس</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '04' ? 'selected' : '' }} value="04">ابريل</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '05' ? 'selected' : '' }} value="05">مايو</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '06' ? 'selected' : '' }} value="06">يونيو</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '07' ? 'selected' : '' }} value="07">يوليو</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '08' ? 'selected' : '' }} value="08">اغسطس</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '09' ? 'selected' : '' }} value="09">سبتمبر</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '10' ? 'selected' : '' }} value="10">اكتوبر</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '11' ? 'selected' : '' }} value="11">نوفمبر</option>
                            <option {{ isset($_GET['month']) && $_GET['month'] == '12' ? 'selected' : '' }} value="12">ديسمبر</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" name="year">
                            <option value="">سنة</option>
                            @for($i=2018; $i <= date("Y"); $i++)
                            <option {{ isset($_GET['year']) && $_GET['year'] == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-success">تصفية المباريات</button>
                    </div>

                </div>
            </form>
        </div>
        
		<div class="m-portlet__head-tools">
            <a href="/matches/create"><button class="btn btn-primry">أضافة</button></a>
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
                                <td width="5%">#</td>
                                <td width="10%">التاريخ</td>
                                <td width="5%">التوقيت</td>
                                <td width="20%">المباراة</td>
                                <td width="15%">البطولة</td>
                                <td width="15%">المعلق</td>
                                <td width="15%">القناة</td>
                                <td width="7.5%">تعديل</td>
                                <td width="7.5%">حذف</td>
                            </tr>
                        </thead>
                        <!--end::Thead-->
                        <!--begin::Tbody-->
                        <tbody>
                            @if(count($matches) > 0)
                                @foreach($matches as $match)
                                <tr>
                                    <td width="5%">{{ $match->id }}</td>
                                    <td width="10%">{{ $match->match_date }}</td>
                                    <td width="5%">{{ $match->match_time }}</td>
                                    <td width="20%">{{ isset($match->team_home) ? $match->team_home->name : '' }} {{ $match->team_home_result }} - {{ $match->team_away_result }} {{ isset($match->team_away) ? $match->team_away->name : '' }}</td>
                                    <td width="15%">{{ isset($match->league) ? $match->league->name : '' }}</td>
                                    <td width="15%">{{ isset($match->commentator) ? $match->commentator->name : '' }}</td>
                                    <td width="15%">{{ isset($match->channel) ? $match->channel->name : '' }}</td>
                                    <td width="7.5%">
                                        <a href="/matches/{{ $match->id }}/edit">
                                            <button type="submit" class="btn btn-xs btn-info">
                                                <i class="flaticon-edit"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td width="7.5%">
                                        <form action="/matches/{{ $match->id }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
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
                                    <td colspan="9" style="text-align:center">لا توجد نتائج</td>
                                </tr>
                            @endif

                        </tbody>
                        <!--end::Tbody-->  

                    </table>
                    <!--end::Table-->                        
                </div>
                <div class="m-widget11__action m--align-right">
                {{ $matches->links() }}

                </div>
            </div>
            <!--end::Widget 11-->

        </div>
    </div>

</div>
<!--end:: Widgets/Application Sales-->  
@endsection