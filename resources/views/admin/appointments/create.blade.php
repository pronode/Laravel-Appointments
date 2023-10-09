@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.appointment.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.appointments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
                    <label for="client">{{ trans('cruds.appointment.fields.client') }}*</label>
                    <select name="client_id" id="client" class="form-control select2" required>
                        @foreach ($clients as $id => $client)
                            <option value="{{ $id }}"
                                {{ (isset($appointment) && $appointment->client ? $appointment->client->id : old('client_id')) == $id ? 'selected' : '' }}>
                                {{ $client }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('client_id') }}
                        </em>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                    <label for="employee">{{ trans('cruds.appointment.fields.employee') }}</label>
                    <select name="employee_id" id="employee" class="form-control select2">
                        @foreach ($employees as $id => $employee)
                            <option value="{{ $id }}"
                                {{ (isset($appointment) && $appointment->employee ? $appointment->employee->id : old('employee_id')) == $id ? 'selected' : '' }}>
                                {{ $employee }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('employee_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('employee_id') }}
                        </em>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                    <label for="start_time">{{ trans('cruds.appointment.fields.start_time') }}*</label>
                    <input type="text" step="900" id="start_time" name="start_time" class="form-control datetime"
                        value="{{ old('start_time', isset($appointment) ? $appointment->start_time : '') }}" required>
                    @if ($errors->has('start_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.start_time_helper') }}
                    </p>
                </div>

                <div class="form-group">
                    <label>Czas trwania:</label>
                    <div>
                        <button type="button" onclick="addMinutes(15)">15 min</button>
                        <button type="button" onclick="addMinutes(20)">20 min</button>
                        <button type="button" onclick="addMinutes(30)">30 min</button>
                        <button type="button" onclick="addMinutes(45)">45 min</button>
                        <button type="button" onclick="addMinutes(60)">60 min</button>
                        <script>
                            function addMinutes(minutes) {
                                var d = new Date(document.getElementById("start_time").value);
                                d.setMinutes(d.getMinutes() + minutes);
                                document.getElementById("finish_time").value = d;

                                // Format to YYYY-MM-DD HH:MM:SS:
                                var month = '' + (d.getMonth() + 1);
                                var day = '' + d.getDate();
                                var year = d.getFullYear();
                                var hour = '' + d.getHours();
                                var minute = '' + d.getMinutes();
                                var second = '' + d.getSeconds();

                                if (month.length < 2)
                                    month = '0' + month;
                                if (day.length < 2)

                                    day = '0' + day;
                                if (hour.length < 2)

                                    hour = '0' + hour;
                                if (minute.length < 2)
                                    minute = '0' + minute;

                                var finish_time = [year, month, day].join('-') + ' ' + [hour, minute].join(':');
                                document.getElementById("finish_time").value = finish_time;
                            }
                        </script>

                    </div>
                </div>

                <div class="form-group {{ $errors->has('finish_time') ? 'has-error' : '' }}">

                    <label for="finish_time">{{ trans('cruds.appointment.fields.finish_time') }}*</label>
                    <input type="text" id="finish_time" name="finish_time" class="form-control datetime"
                        value="{{ old('finish_time', isset($appointment) ? $appointment->finish_time : '') }}" required>
                    @if ($errors->has('finish_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('finish_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.finish_time_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                    <label for="price">{{ trans('cruds.appointment.fields.price') }}</label>
                    <input type="number" id="price" name="price" class="form-control"
                        value="{{ old('price', isset($appointment) ? $appointment->price : '') }}" step="0.01">
                    @if ($errors->has('price'))
                        <em class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.price_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('comments') ? 'has-error' : '' }}">
                    <label for="comments">{{ trans('cruds.appointment.fields.comments') }}</label>
                    <textarea id="comments" name="comments" class="form-control ">{{ old('comments', isset($appointment) ? $appointment->comments : '') }}</textarea>
                    @if ($errors->has('comments'))
                        <em class="invalid-feedback">
                            {{ $errors->first('comments') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.comments_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                    <label for="services">{{ trans('cruds.appointment.fields.services') }}
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="services[]" id="services" class="form-control select2" multiple="multiple">
                        @foreach ($services as $id => $services)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('services', [])) || (isset($appointment) && $appointment->services->contains($id)) ? 'selected' : '' }}>
                                {{ $services }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('services'))
                        <em class="invalid-feedback">
                            {{ $errors->first('services') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.services_helper') }}
                    </p>
                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
