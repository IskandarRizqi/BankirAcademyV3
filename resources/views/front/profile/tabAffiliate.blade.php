<form action="/set-master-refferal" method="POST">
    @csrf
    <input type="text" name="id" id="id" class="form-control" value="{{$reff?$reff->id:''}}" hidden>
    <div class="row">
        <div class="col">
            <label for="form-control">Kode Referral</label>
            <input type="text" name="kode" id="kode" class="form-control" value="{{$reff?$reff->code:''}}">
            @error('kode')
            <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="col">
            <label for="form-control">URL <small>spesial karakter akan di rubah ke (-) atau (_)</small></label>
            <input type="text" name="url" id="url" class="form-control" value="{{$reff?$reff->url:''}}">
            @error('url')
            <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
    </div>
    <button class="button button-primary">Set</button>
</form>
<table id="affiliate" class="table table-hover" style="width:100%" hidden>
    <thead>
        <tr>
            <th>No</th>
            <th>Nominal</th>
            <th class="dt-no-sorting text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>1</td>
            <td>1</td>
        </tr>
        {{-- @foreach ($data as $key => $l)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$l->nominal}}</td>
            <td>
                <button class="btn btn-warning" id="edit" title="Edit"><i class='bx bx-edit'></i></button>
                <button class="btn btn-danger" onclick="deleteLaman({{$l->id}})" title="Delete"> <i
                        class='bx bx-trash'></i></button>
                <form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach --}}
    </tbody>
</table>
<script>
</script>