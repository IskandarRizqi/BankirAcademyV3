@foreach($lokers as $loker)
    @include('membernonkeanggotaan.components.ui.loker-card', ['loker' => $loker])
@endforeach
