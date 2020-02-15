@extends('layouts.app')
@section('title','تعديل مباراة')

@section('content')
<div class="row">

	<div class="col-md-12">
		<!--begin::Portlet-->
        <div class="m-portlet m-portlet--full-height">
            
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">تعديل مباراة</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>

            <div class="m-portlet__body">
                <form action="/matches/{{ request()->route('match') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT" />

                    <div class="form-group row">
                        <label class="col-3 col-form-label">التاريخ</label>
                        <div class="col-9">
                            <input class="form-control m_datetimepicker_6" name="match_date" value="{{ $match->match_date }}" placeholder="التاريخ" />
                            @if ($errors->has('match_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('match_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">التوقيت</label>
                        <div class="col-9">
                            <input class="form-control m_datetimepicker_7" name="match_time" value="{{  date('H:i', strtotime($match->match_time)) }}" placeholder="التوقيت" />
                            @if ($errors->has('match_time'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('match_time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">بلد الفريق المستضيف</label>
                        <div class="col-9">
                            <select class="form-control" name="team_home_country_id" onChange="getHomeTeams(this.value)">
                                <option value="">اختر البلد</option>
                                @foreach($countries as $country)
                                    <option {{ $country->id == $match->team_home_country_id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('team_home_country_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('team_home_country_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">الفريق المستضيف</label>
                        <div class="col-9">

                            <select class="form-control" name="team_home_id" id="team_home_id">
                                <option value="">اختر الفريق</option>
                                @foreach($home_teams as $team)
                                    <option {{ $team->id == $match->team_home_id ? 'selected' : '' }} value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('team_home_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('team_home_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">أهداف الفريق المستضيف</label>
                        <div class="col-9">
                            <input class="form-control" type="number" name="team_home_result" value="{{ $match->team_home_result }}" placeholder="أهداف الفريق المستضيف" />
                            @if ($errors->has('team_home_result'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('team_home_result') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">بلد الفريق الضيف</label>
                        <div class="col-9">
                            <select class="form-control" name="team_away_country_id" onChange="getAwayTeams(this.value)">
                                <option value="">اختر البلد</option>
                                @foreach($countries as $country)
                                <option {{ $country->id == $match->team_away_country_id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('team_away_country_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('team_away_country_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">الفريق الضيف</label>
                        <div class="col-9">

                            <select class="form-control" name="team_away_id" id="team_away_id">
                                <option value="">اختر الفريق</option>
                                @foreach($away_teams as $team)
                                    <option {{ $team->id == $match->team_away_id ? 'selected' : '' }} value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('team_away_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('team_away_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">أهداف الفريق الضيف</label>
                        <div class="col-9">
                            <input class="form-control" type="number" name="team_away_result" value="{{ $match->team_away_result }}" placeholder="أهداف الفريق الضيف" />
                            @if ($errors->has('team_away_result'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('team_away_result') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">البطولة</label>
                        <div class="col-9">
                            <select class="form-control" name="league_id">
                                <option value="">اختر البطولة</option>
                                @foreach($leagues as $league)
                                    <option {{ $league->id == $match->league_id ? 'selected' : '' }} value="{{ $league->id }}">{{ $league->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('league_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">المعلق</label>
                        <div class="col-9">
                            <select class="form-control" name="commentator_id">
                                <option value="">اختر المعلق</option>
                                @foreach($commentators as $commentator)
                                    <option {{ $commentator->id == $match->commentator_id ? 'selected' : '' }} value="{{ $commentator->id }}">{{ $commentator->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('commentator_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('commentator_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">القناة</label>
                        <div class="col-9">
                            <select class="form-control" name="channel_id">
                                <option value="">اختر القناة</option>
                                @foreach($channels as $channel)
                                    <option {{ $channel->id == $match->channel_id ? 'selected' : '' }} value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('channel_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('channel_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">رابط البث المباشر</label>
                        <div class="col-9">
                            <input class="form-control" name="live_stream_url" value="{{ $match->live_stream_url }}" placeholder="رابط البث المباشر" />
                            @if ($errors->has('live_stream_url'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('live_stream_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">رابط الملخص</label>
                        <div class="col-9">
                            <input class="form-control" name="summary_url" value="{{ $match->summary_url }}" placeholder="رابط الملخص" />
                            @if ($errors->has('summary_url'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('summary_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">رابط الأهداف</label>
                        <div class="col-9">
                            <input class="form-control" name="goals_url" value="{{ $match->goals_url }}" placeholder="رابط الأهداف" />
                            @if ($errors->has('goals_url'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('goals_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label">انتهت</label>
                        <div class="col-9">
                            <input type="hidden" value="0" name="finished" checked />
                            <input type="checkbox" class="form-control" name="finished" {{ $match->finished == 1 ? 'checked' : '' }} value="1" />
                            @if ($errors->has('finished'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('finished') }}</strong>
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

@section('scripts')
<script type="text/javascript">
    
    function getHomeTeams(countryId){
        $.ajax({
            type: "GET",
            url: "/countries/"+countryId+"/teams",
            data: "",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                var team_home_id = $("#team_home_id");
                team_home_id.empty();
                team_home_id.append($("<option />").val('').text('اختر الفريق'));
                $.each(data, function() {
                    team_home_id.append($("<option />").val(this.id).text(this.name));
                });
            }
        });        
    }

    function getAwayTeams(countryId){
        $.ajax({
            type: "GET",
            url: "/countries/"+countryId+"/teams",
            data: "",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                var team_away_id = $("#team_away_id");
                team_away_id.empty();
                team_away_id.append($("<option />").val('').text('اختر الفريق'));
                $.each(data, function() {
                    team_away_id.append($("<option />").val(this.id).text(this.name));
                });
            }
        }); 
    }
</script>
@endsection