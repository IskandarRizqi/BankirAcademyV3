@extends('backend.template')
@section('content')
@if ($errors->any())
@foreach ($errors->all() as $error)
    <div>{{$error}}</div>
@endforeach
@endif
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-heading">
                <a class="btn" data-dismiss="modal"
                    href="{{ Auth::user()->role == 3 ? '/instructor/classes' : '/admin/classes' }}"><i
                        class="flaticon-cancel-12"></i>Back</a>
            </div>
            <div class="widget-content">
                <h1>{{ $class->title }}</h1>
                <form action="/admin/classes/setevent" id="newClassEventForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
                    <input type="hidden" name="hdnClassesId" value="{{ $class->id }}" id="hdnClassesId">
                    <input type="hidden" name="hdnEventTBDId" value="0" class="hdnEventTBDId">

                    <div class="dynamicClassEventForm">
                        @foreach ($event as $v)
                            <div class="classEventContainer">
                                <div class="col-lg-12 text-right">
                                    <input type="hidden" name="txtClassEventId[]" class="form-control txtClassEventId"
                                        value="{{ $v->id }}">
                                    <button type="button" class="btn btn-danger"
                                        onclick="delClassEventRow($(this),{{ $v->id }})"><i
                                            class="bx bx-x"></i></button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="slcClassEventType">Type</label>
                                            <small class="inputerrormessage text-danger" input-target="slcClassEventType"
                                                style="display: none;"></small>
                                            <select name="slcClassEventType[]" class="form-control slcClassEventType"
                                                onchange="eventTypeChanged($(this))">
                                                <?php $n = 'selected';
                                                $f = '';
                                                if ($v->type == 1) {
                                                    $n = '';
                                                    $f = 'selected';
                                                } ?>
                                                <option value="0" {{ $n }}>Online</option>
                                                <option value="1" {{ $f }}>Offline</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="txtClassesTitle">Date Time</label>
                                            <small class="inputerrormessage text-danger" input-target="datClassesDateStart"
                                                style="display: none;"></small>
                                            <small class="inputerrormessage text-danger" input-target="datClassesDateEnd"
                                                style="display: none;"></small>
                                            <div class="input-group mb-4">
                                                <input type="datetime-local" class="form-control datClassesDateStart"
                                                    name="datClassesDateStart[]" placeholder="Date Start"
                                                    aria-label="Date Start" value="{{ $v->time_start }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon5">s/d</span>
                                                </div>
                                                <input type="datetime-local" class="form-control datClassesDateEnd"
                                                    name="datClassesDateEnd[]" placeholder="Date End" aria-label="Date End"
                                                    value="{{ $v->time_end }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group ctrClassEventLink">
                                            <label for="txtClassEventLink">Link</label>
                                            <small class="inputerrormessage text-danger" input-target="txtClassEventLink"
                                                style="display: none;"></small>
                                            <input type="text" name="txtClassEventLink[]"
                                                class="txtClassEventLink form-control" value="{{ $v->link }}">
                                        </div>
                                        <div class="form-group ctrClassEventLocation" style="display:none;">
                                            <label for="txtClassEventLocation">Location</label>
                                            <small class="inputerrormessage text-danger"
                                                input-target="txtClassEventLocation" style="display: none;"></small>
                                            <input type="text" name="txtClassEventLocation[]"
                                                class="txtClassEventLocation form-control" value="{{ $v->location }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="txaClassEventDescription">Description</label>
                                        <small class="inputerrormessage text-danger" input-target="txaClassEventDescription"
                                            style="display: none;"></small>
                                        <textarea type="text" name="txaClassEventDescription[]" class="txaClassEventDescription form-control">{{ $v->description }}</textarea>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <button type="button" class="btn btn-block btn-info" onclick="addNewClassEvent()">Add New
                                Event</button>
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-block btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        function addNewClassEvent() {
            $('.dynamicClassEventForm').append("" +
                '<div class="classEventContainer">' +
                '	<div class="col-lg-12 text-right">' +
                '		<input type="hidden" name="txtClassEventId[]" class="form-control txtClassEventId" value="">' +
                '		<button type="button" class="btn btn-danger" onclick="delClassEventRow($(this),0)"><i class="bx bx-x"></i></button>' +
                '	</div>' +
                '	<div class="row">' +
                '		<div class="col-lg-4">' +
                '			<div class="form-group">' +
                '				<label for="slcClassEventType">Type</label>' +
                '				<small class="inputerrormessage text-danger" input-target="slcClassEventType" style="display: none;"></small>' +
                '				<select name="slcClassEventType[]" class="form-control slcClassEventType" onchange="eventTypeChanged($(this))">' +
                '					<option value="0">Online</option>' +
                '					<option value="1">Offline</option>' +
                '				</select>' +
                '			</div>' +
                '		</div>' +
                '		' +
                '		<div class="col-lg-8">' +
                '			<div class="form-group">' +
                '				<label for="txtClassesTitle">Date Time</label>' +
                '				<small class="inputerrormessage text-danger" input-target="datClassesDateStart" style="display: none;"></small>' +
                '				<small class="inputerrormessage text-danger" input-target="datClassesDateEnd" style="display: none;"></small>' +
                '				<div class="input-group mb-4">' +
                '					<input type="datetime-local" class="form-control datClassesDateStart" name="datClassesDateStart[]"  placeholder="Date Start" aria-label="Date Start" required>' +
                '					<div class="input-group-append">' +
                '						<span class="input-group-text" id="basic-addon5">s/d</span>' +
                '					</div>' +
                '					<input type="datetime-local" class="form-control datClassesDateEnd" name="datClassesDateEnd[]"  placeholder="Date End" aria-label="Date End" required>' +
                '				</div>' +
                '			</div>' +
                '		</div>' +
                '		<div class="col-lg-12">' +
                '			<div class="form-group ctrClassEventLink">' +
                '				<label for="txtClassEventLink">Link</label>' +
                '				<small class="inputerrormessage text-danger" input-target="txtClassEventLink" style="display: none;"></small>' +
                '				<input type="text" name="txtClassEventLink[]" class="txtClassEventLink form-control">' +
                '			</div>' +
                '			<div class="form-group ctrClassEventLocation" style="display:none;">' +
                '				<label for="txtClassEventLocation">Location</label>' +
                '				<small class="inputerrormessage text-danger" input-target="txtClassEventLocation" style="display: none;"></small>' +
                '				<input type="text" name="txtClassEventLocation[]" class="txtClassEventLocation form-control">' +
                '			</div>' +
                '		</div>' +
                '		<div class="col-lg-12">' +
                '			<label for="txaClassEventDescription">Description</label>' +
                '			<small class="inputerrormessage text-danger" input-target="txaClassEventDescription" style="display: none;"></small>' +
                '			<textarea type="text" name="txaClassEventDescription[]" class="txaClassEventDescription form-control"></textarea>' +
                '		</div>' +
                '	</div>' +
                '	<hr>' +
                '</div>' +
                "");
        }

        function eventTypeChanged(ths) {
            var v = ths.val();
            var p = ths.parent('div').parent('div').parent('.row');
            p.find('.ctrClassEventLink').hide();
            p.find('.ctrClassEventLocation').hide();
            if (v == 0) {
                p.find('.ctrClassEventLink').show();
            } else {
                p.find('.ctrClassEventLocation').show();
            }
        }

        function delClassEventRow(ths, id) {
            var ctr = ths.parent('div').parent('.classEventContainer');
            $('.hdnEventTBDId').val($('.hdnEventTBDId').val() + ',' + id);
            ctr.remove();
        }
    </script>
@endsection
