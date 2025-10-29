<style>
    /* --- Global Input & Select Styling --- */
    .form-control, .btn-light, .btn-primary {
        border-radius: 20px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #dce3f1;
        font-size: 14px;
    }

    label {
        font-weight: 600;
        font-size: 13px;
        color: #555;
    }

    .filter-panel {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .accordion-button-custom {
        background-color: #f8f9fa;
        border-radius: 20px;
        text-align: left;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #d1d1d1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-button-custom:hover {
        background-color: #eef4ff;
        border-color: #007bff;
    }

    .accordion-body-custom {
        padding: 15px;
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        margin-top: 8px;
    }

    .checkbox-style-1-label {
        margin-left: 5px;
        font-size: 14px;
        font-weight: normal;
        cursor: pointer;
    }

    .checkbox-style {
        width: 18px;
        height: 18px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056d2;
        border-color: #0056d2;
        transform: translateY(-1px);
    }

</style>

<form action="/list-class" method="POST">
    @csrf
    <div class="filter-panel">
        <div class="row">
            <!-- Input Pencarian -->
            <div class="form-group col-md-2">
                <label for="">Pencarian:</label>
                <input type="text" name="titlekelas" id="titlekelas" class="form-control"
                    value="{{ isset($titlekelas) ? $titlekelas : '' }}">
            </div>

            <!-- Kategori -->
            <div class="form-group col-md-2">
                <label for="">Kategori:</label>
                <select class="form-control tagging slc2tag" name="slcClassesCategory" id="slcClassesCategory">
                    <option value="">Pilih</option>
                    @foreach ($pencarian['category'] as $ctg)
                    <option value="{{ $ctg }}" @if (isset($slcClassesCategory)) {{ $slcClassesCategory==$ctg ? 'selected'
                        : '' }} @endif>
                        {{ $ctg }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Instructor -->
            <div class="form-group col-md-2">
                <label for="">Instructor:</label>
                <select class="form-control tagging" name="instructor" id="instructor">
                    <option value="">Pilih</option>
                    @foreach ($pencarian['instructor'] as $key => $ctg)
                    <option value="{{ $ctg }}" @if (isset($instructor)) {{ $instructor==$ctg ? 'selected' : '' }} @endif>
                        {{ $key }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis & Tipe -->
            <div class="col-md-4">
                <label for="">Filter Tambahan:</label>
                <div class="accordion" id="accordionExample">

                    <!-- Jenis -->
                    <div class="mb-2">
                        <button class="accordion-button-custom" type="button" data-toggle="collapse"
                            data-target="#collapseJenis" aria-expanded="false" aria-controls="collapseJenis">
                            Jenis <span>▼</span>
                        </button>
                        <div id="collapseJenis" class="collapse" data-parent="#accordionExample">
                            <div class="accordion-body-custom">
                                <div class="row">
                                    @foreach ($pencarian['jenis'] as $key => $ctg)
                                    <div class="col-md-6 d-flex align-items-center mb-2">
                                        <input id="jenis-{{ $key }}" class="checkbox-style ini-checkbox-1"
                                            name="jeniss[{{ $ctg }}]" type="checkbox"
                                            @if (isset($jeniss)) {{ in_array(strtolower($ctg), $jeniss) ? 'checked' : ''
                                            }} @endif value="{{$ctg}}">
                                        <label for="jenis-{{ $key }}" class="checkbox-style-1-label">{{ $ctg }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipe -->
                    <div class="mb-2">
                        <button class="accordion-button-custom" type="button" data-toggle="collapse"
                            data-target="#collapseTipe" aria-expanded="false" aria-controls="collapseTipe">
                            Tipe <span>▼</span>
                        </button>
                        <div id="collapseTipe" class="collapse" data-parent="#accordionExample">
                            <div class="accordion-body-custom">
                                <div class="row">
                                    @foreach ($pencarian['tipe'] as $key => $ctg)
                                    <div class="col-md-6 d-flex align-items-center mb-2">
                                        <input id="tipe-{{ $key }}" class="checkbox-style ini-checkbox-2"
                                            name="tipe[{{ $ctg }}]" type="checkbox"
                                            @if (isset($tipe)) {{ in_array($ctg, $tipe) ? 'checked' : '' }} @endif
                                            value="{{$ctg}}">
                                        <label for="tipe-{{ $key }}" class="checkbox-style-1-label">{{ $ctg }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <button class="accordion-button-custom" type="button" data-toggle="collapse"
                            data-target="#collapseTag" aria-expanded="false" aria-controls="collapseTag">
                            Tags <span>▼</span>
                        </button>
                        <div id="collapseTag" class="collapse" data-parent="#accordionExample">
                            <div class="accordion-body-custom">
                                <div class="row">
                                    @foreach ($pencarian['tags'] as $key => $ctg)
                                    <div class="col-md-6 d-flex align-items-center mb-2">
                                        <input id="checkbox-{{ $key }}" class="checkbox-style ini-checkbox-1"
                                            name="checkbox[{{ $ctg }}]" type="checkbox"
                                            @if (isset($tags)) {{ array_key_exists($ctg, $tags) ? 'checked' : '' }}
                                            @endif>
                                        <label for="checkbox-{{ $key }}"
                                            class="checkbox-style-1-label">{{ $ctg }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Button -->
            <div class="col-lg-2 mt-4">
                <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnlistkelascari">TELUSURI</button>
            </div>
        </div>
    </div>
</form>
